<?php

/**
	wTerritoires <http://www.wterritoires.fr/>
	Copyright (C) 2011 Simon Lamellière <opensource@worketer.fr>

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU Affero General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU Affero General Public License for more details.

	You should have received a copy of the GNU Affero General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
**/

class inviteActions extends sfActionsJson
{
	public $bypass = array("wish_confirm");
	
	public function executeHide($request)
	{
		$invit = Doctrine::getTable("Invitation")->find($request->getParameter("iid"));

		if($invit)
		{
			if($invit->getProfilId() == $this->getUser()->getId())
			{
				$invit->setHidden(1);
				$invit->save();

				$this->setJsonContents(parent::$SUCCESS_RELOAD);
				return false;
			}
		}

		$this->setJsonContents(parent::$ERROR_RELOAD);
	}
	
	public function executeWish_confirm()
	{
		
	}
	
	// Demande d'invitation pour les groupes de travail privés
	public function executeWish(sfWebRequest $request)
	{
		$project = Doctrine::getTable("Projet")->find($request->getParameter("pid"));
		
		if($project && $project->getType() == "group")
		{
			// L'user ne doit pas faire partir du projet
			if( !$this->getUser()->isInProjet($request->getParameter("pid")) )
			{
				if(!Doctrine_Query::create()->from("WishInvitation")->where("projet_id=?", $request->getParameter("pid"))->andWhere("profil_id=?", $this->getUser()->getId())->fetchOne())	
				{
					$wish = new WishInvitation();
					$wish->setProfilId($this->getUser()->getId()) ;
					$wish->setProjetId($request->getParameter("pid"));
					$wish->setHidden("0");
					$wish->save();
					
					// Go JSON
					$this->setJsonContents(array("message" => sfContext::getInstance()->getI18n()->__("Votre demande a bien été transmise à l'administrateur !")));
					return false;
				}
			}
		}
		
		$this->setJsonContents(array("message" => sfContext::getInstance()->getI18n()->__("Votre demande n'a pas pu être transmise : vous êtes déjà dans le groupe ou déjà invité.")));
	}

	public function prefetch($request, $level)
	{
		// On regarde s'il n'est pas déjà invité pour ce projet
		if($request->getParameter("pid"))
		{
			// ACL
			$acl = ProjectACL::init($request->getParameter("pid"), $level, true);

			// Suite
			$type = "project";

			$this->object = Doctrine::getTable("Projet")->find($request->getParameter("pid"));
			$this->name = $this->object->getNom();
			$this->id = $this->object->getId();
			$this->url = $this->getController()->genUrl("@project?slug=".$this->object->getSlug(), true);
		}
		elseif($request->getParameter("eid"))
		{
			// ACL
			EventACL::init($request->getParameter("eid"), $level, true);

			$type = "event";

			$this->object = Doctrine::getTable("Event")->find($request->getParameter("eid"));
			$this->name = $this->object->getTitre();
			$this->id = $this->object->getId();
			$this->url = $this->getController()->genUrl("@event?slug=".$this->object->getSlug(), true);
		}
		else
		{
			die("Opération Impossible");
		}

		return $type;
	}

	// Envoyer un email aux membres d'un projet/groupe ou d'un event
	public function executeMailing(sfWebRequest $request)
	{
		$type = $this->prefetch($request, "write");

		if($request->isMethod("POST"))
		{
			$emails = explode("\n", $request->getParameter("pooled_emails"));
			$countinvite = 0;

			if(trim($request->getParameter("message")) == "")
			{
				$this->setJsonContents(array("method" => "display", "status" => 500, "errors" => array("local" => array("message" => "Champ requis."))));
				return false;
			}

			if(count($request->getParameter("pool_friends")))
			{
				// Les membres sollicités
				foreach((array)$request->getParameter("pool_friends") as $fid)
				{
					if(!$this->object)
						break;

					// Protection contre les injections d'IDs (ils doivent absolument faire partie du projet ou de l'event)
					switch($type)
					{
						case "project":

							if(!$this->getUser()->isInProjet($this->id, $fid))
								continue;

							break;
						case "event":

							if("yes" != $this->getUser()->isInEvent($this->id, $fid))
								continue;

							break;
					}

					// Check user
					$user = Doctrine::getTable('Profil')->find($fid);

					if(!$user)
						continue;

					// Continuer
					$result = rMail::create($fid, null, "mailing", array("message" => $request->getParameter("message"), "inviter" => $this->getUser()->getObject()->__toString(), "link_text" => $this->url, "link" => $this->url, "name" => $this->name, "type" => $type), true)
						->send();

					if($result === true)
					{
						error_log("[SENT-MAILING] Type: ".$type." Id: ".$this->id." To: ".$user->getEmail()." From: ".$this->getUser()->getObject()->getEmail()."/".$this->getUser()->getObject()->__toString());
						$countinvite++;
					}
				}

				$this->setJsonContents(array("status" => 200, "method" => "display", "message" => sfContext::getInstance()->getI18N()->__("Votre message a été transmis avec succès à %count personne(s)", array("%count" => $countinvite)) ));
			}
		}
		else
		{
			switch($type)
			{
				case "project":
					$this->contacts = Doctrine_Query::create()
													->from("ProfilProjet c")
													->leftJoin("c.Profil")
													->where("projet_id=?", $this->id)
													->execute(array(), "profile_light");
				break;
				case "event":
					$this->contacts = Doctrine_Query::create()
													->from("EventInvite c")
													->leftJoin("c.Profil")
													->where("event_id=?", $this->id)
													->andWhere("etat=?", "yes")
													->execute(array(), "profile_light");
				break;
			}

			$this->controller = $this;
			$this->isJsonable(false);
		}
	}

	public function executeIndex(sfWebRequest $request)
	{
		$this->contacts = $this->getUser()->getObject()->getFriends();

		// On regarde s'il n'est pas déjà invité pour ce projet
		$type = $this->prefetch($request, "invite");

		if($request->isMethod("POST"))
		{
			$emails = explode("\n", $request->getParameter("pooled_emails"));
			$countinvite = 0;

			if(count($request->getParameter("pool_friends")) || count($emails))
			{
				$invited = array();

				// Emails libres
				foreach((array)$emails as $email)
				{
					if(trim($email) == "")
						continue;

					$this->invited = Doctrine_Query::create()
													->from('InvitationEmail i')
													->where('i.email= ?', $email)
													->andWhere('(i.projet_id = ?', $request->getParameter("pid"))
													->orWhere('i.event_id = ?)', $request->getParameter("eid"))
													->fetchOne();

					// Register Invitation
					$invit = new InvitationEmail();
					$invit->setInviteurId($this->getUser()->getId());
					$invit->setEmail($email);
					$invit->setDate(new Doctrine_Expression('NOW()'));

					switch($type)
					{
						case "project":
							$invit->setProjetId($request->getParameter("pid"));
							$invit->save();
						break;
						case "event":
							$invit->setEventId($request->getParameter("eid"));
							$invit->save();
						break;
					}

					// Déjà invité ?
					if(!$this->invited)
					{
						$result = rMail::create(0, "", "invite", array("message" => $request->getParameter("message"), "inviter" => $this->getUser()->getObject()->__toString(), "link_text" => $this->url, "link" => $this->url, "name" => $this->name, "type" => $type), true, $email)
							->send();

						if($result === true)
						{
							$countinvite++;
						}
					}
				}

				// Mes amis invités
				foreach((array)$request->getParameter("pool_friends") as $fid)
				{
					if(!$this->object)
						break;

					// Check relation
					$crel = $this->getUser()->isFriendWith($fid);

					// Déjà invité ?
					if($this->isInvited($fid, $request) === false && ($crel && $crel->get("is_activated") == 1))
					{
						// Check user
						$user = Doctrine::getTable('Profil')->find($fid);

						if(!$user)
							continue;

						// Go !
						$invit = new Invitation();
						$invit->setInviteurId($this->getUser()->getId());
						$invit->setProfilId($fid);
						$invit->setDate(new Doctrine_Expression('NOW()'));

						switch($type)
						{
							case "project":
								$invit->setProjetId($request->getParameter("pid"));
								$invit->save();
							break;
							case "event":
								$invit->setEventId($request->getParameter("eid"));
								$invit->save();

								// Create Invitation
								$eventin = new EventInvite();
								$eventin->setProfilId($fid);
								$eventin->setEventId($request->getParameter("eid"));
								$eventin->setEtat("pending");
								$eventin->save();
							break;
						}

						$result = rMail::create($fid, "", "invite", array("message" => $request->getParameter("message"), "inviter" => $this->getUser()->getObject()->__toString(), "link_text" => $this->url, "link" => $this->url, "name" => $this->name, "type" => $type), true)
								->send();

						if($result === true)
							$countinvite++;

						$invited[] = $fid;
					}
				}

				// On créé une story si besoin
				if(count($invited) > 0)
				{
					switch($type)
					{
						case "project":
							Story::publish(
								"invite",
								"Projet",
								$request->getParameter("pid"),
								sfContext::getInstance()->getUser()->getId(),
								"invite",
								"",
								array(),
								$invited
							);
							break;
						case "event":
							Story::publish(
								"invite",
								"Event",
								$request->getParameter("eid"),
								sfContext::getInstance()->getUser()->getId(),
								"invite",
								"",
								array(),
								$invited
							);
							break;
					}
				}

				$this->setJsonContents(array("status" => 200, "method" => "display-refresh", "message" => sfContext::getInstance()->getI18N()->__("%count personne(s) ont bien été invitée(s)", array("%count" => $countinvite)) ));
			}
		}
		else
		{
			$this->controller = $this;
			$this->isJsonable(false);
		}
	}

	public function isInvited($fid, $request)
	{
		return (Doctrine_Query::create()
										->from('Invitation i')
										->where('i.profil_id = ?', $fid)
										->andWhere('(i.projet_id = ?', $request->getParameter("pid"))
										->orWhere('i.event_id = ?)', $request->getParameter("eid"))
										->count() ? true : false);
	}
}

?>
