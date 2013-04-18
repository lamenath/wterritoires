<?php

/**
   wTerritoires <http://www.wterritoires.fr/>
   Copyright (C) 2013 Simon Lamellière <opensource@worketer.fr>

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

class actionsActions extends sfActions
{
	public function preExecute()
	{
		$this->result = array();
	}

	public function postExecute()
	{
		if(count($this->result)) die(json_encode($this->result));
	}

	public function executeLogout(sfWebRequest $request)
	{
		$this->getUser()->flush();
		$this->redirect("@homepage?loggedout=true");
	}

	public function executeLogin(sfWebRequest $request)
	{
		$this->getUser()->denyLoggedIn(($request->getParameter("goto") ? $request->getParameter("goto") : "@homepage"));
		$this->form = new ProfilLoginForm();
		$this->error_auth = false;

		if($request->isMethod("POST"))
		{
			$this->form->bind(
				$request->getParameter($this->form->getName()),
				$request->getFiles($this->form->getName())
			);

			$profil = (object) $request->getParameter("profil");
			$user = $this->getUser()->checkLogin($profil->login, $profil->password);

			if ($this->form->isValid() && $user)
			{
				$this->getUser()->createAuth($user);

				if($request->getParameter("goto"))
					$this->redirect($request->getParameter("goto"));
				else
					$this->redirect("@homepage");
			}
			else
			{
				$this->error_auth = true;
			}
		}
	}

	public function executeJoin_projet(sfWebRequest $request)
	{
		$this->projet = Doctrine_Query::create()
					->from('Projet p')
					->where('p.id = ?', $request->getParameter("pid"))
					->fetchOne();
	}

	public function executeVideo(sfWebRequest $request) {}

	public function executeJoin_event(sfWebRequest $request)
	{
		$this->event = Doctrine_Query::create()
										->from('Event p')
										->where('p.id = ?', $request->getParameter("eid"))
										->fetchOne(array(), "event");
	}

	/*public function executeAdd_photo(sfWebRequest $request)
	{
		RRR::$sidebar = $this->projet = Doctrine_Query::create()
						->from('Projet p')
						->where('p.id = ?', $request->getParameter("pid"))
						->fetchOne();

		if($this->projet && ($this->getUser()->isInProjet($request->getParameter("pid")) || $this->getUser()->isAdmin())) { } else { $this->redirect404(); }

		$this->form = new PhotoProjetFrontendForm();

		if($request->isMethod("POST") && $this->form->isCSRFProtected())
		{
			$this->form->bind(
				$request->getParameter($this->form->getName()),
				$request->getFiles($this->form->getName())
			);

			if($this->form->isValid())
			{
				$this->form->getObject()->setProjetId($request->getParameter("pid"));
				$this->form->getObject()->setCreateurId($this->getUser()->getId());
				$this->form->getObject()->setDate(date("Y-m-d H:i:s"));
				$this->form->save();

				$img = $this->form->getObject();

				// magick !
				exec("/usr/bin/convert ".sfConfig::get('sf_upload_dir')."/galerie/".$img->getFichier()." -strip -interlace line -quality 90 -resize 140x100\! ".sfConfig::get('sf_upload_dir')."/galerie/140px_".$img->getFichier());

				$this->redirect("@projet?page=galerie&slug=".$this->projet->get("slug")."&document=added");
			}
		}
	}*/

	public function executeConfirm_contact(sfWebRequest $request)
	{
		if($this->getUser()->isFriendWith($this->getUser()->getId(), $request->getParameter("uid")))
			die("Il n'y a rien à confirmer");

		$this->profil = Doctrine_Query::create()
					->from('Profil p')
					->where('p.id = ?', $request->getParameter("uid"))
					->fetchOne();
	}

	public function executeRetrieve(sfWebRequest $request)
	{
		$this->getUser()->denyLoggedIn("@homepage");

		$this->tick = Doctrine_Query::create()
			->from('ActionPassword u')
			->where('u.ticket = ?', $request->getParameter("ticket"))
			->fetchOne();

		if(!$this->tick) $this->redirect("@homepage");

		if($request->isMethod("POST"))
		{
			if($this->tick->getProfil()->getEmail() == trim($request->getParameter("mail")))
			{
				if( $request->getParameter("pass2") == $request->getParameter("pass1") && mb_strlen($request->getParameter("pass1"), "UTF-8") >= 6)
				{
					$user = $this->tick->getProfil();
					$user->setPassword(md5($request->getParameter("pass1")));
					$user->save();

					$this->tick->delete();

					$this->posted = true;
				}
				else
				{
					$this->err = "Les mots de passes ne correspondent pas, ou font moins de 6 caractères";
				}
			}
			else
			{
				$this->err = "Impossible de changer votre mot de passe, l'email ne correspond pas au compte de " . $this->tick->getProfil() . ". Veuillez réessayer...";
			}
		}
	}

	public function executeAdmin_project(sfWebRequest $request)
	{
		$this->project = Doctrine_Query::create()
										->from("Projet p")
										->where("p.id=?", $request->getParameter("pid"))
										->fetchOne(array(), "project_light");

		$this->profil = Doctrine_Query::create()
										->from('Profil p')
										->where('p.id = ?', $request->getParameter("uid"))
										->fetchOne(array(), "profile_light");
	}
	
	public function executeAdmin_structure(sfWebRequest $request)
	{
		$this->project = Doctrine_Query::create()
										->from("Structure p")
										->where("p.id=?", $request->getParameter("pid"))
										->fetchOne(array(), "structure");

		$this->profil = Doctrine_Query::create()
										->from('Profil p')
										->where('p.id = ?', $request->getParameter("uid"))
										->fetchOne(array(), "profile_light");
	}

	public function executeAdd_contact(sfWebRequest $request)
	{
		$this->profil = Doctrine_Query::create()
										->from("Profil p")
										->where("p.id=?", $request->getParameter("uid"))
										->fetchOne(array(), "profile_light");
	}
	
	public function executeLost(sfWebRequest $request)
	{
		$this->getUser()->denyLoggedIn("@homepage");

		if($request->isMethod("POST") && trim($request->getParameter("mail_login")) != "")
		{
			$this->posted = "test";

			$user = Doctrine_Query::create()
				->from('Profil u')
				->where('u.login = ?', $request->getParameter("mail_login"))
				->orWhere('u.email = ?', $request->getParameter("mail_login"))
				->fetchOne();

			if($user)
			{
				$ticket = sha1(time()."-".$user->getLogin());

				$action = new ActionPassword();
				$action->setProfilId($user->getId());
				$action->setTicket($ticket);
				$action->setDate(new Doctrine_Expression('NOW()'));
				$action->save();

				// Envoi du mail
				rMail::create($user->getId(), "", "lost", array("link" => sfConfig::get("app_url") . "actions/retrieve?ticket=" . $ticket), true)
						->send();
			}
		}
	}
}
