<?php

/**
	wTerritoires <http://www.wterritoires.fr/>
	Copyright (C) 2010 Simon Lamellière <opensource@worketer.fr>

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

class myUser extends sfBasicSecurityUser
{
	/*public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array())
	{
		$options['timeout'] = false;
		parent::initialize($dispatcher, $storage, $options);
	}

	public function __construct(sfEventDispatcher $e, sfStorage $s)
	{
		parent::__construct($e,$s);
	}*/

	public function requireLogin($redirect=false, $forced = false)
	{
		if(!$this->isLogged())
		{
			sfContext::getInstance()->getConfiguration()->loadHelpers('Url');

			if($forced === false)
				sfContext::getInstance()->getController()->redirect(url_for("actions/login")."?goto=" . urlencode(sfContext::getInstance()->getRequest()->getUri()));
			else
				sfContext::getInstance()->getController()->redirect($forced);
		}
	}

	public function isLogged()
	{
		if($this->hasAttribute("id") && $this->getAttribute("id") && $this->isAuthenticated()) return true;
		return false;
	}

	public function sendSubscribeMail($password = false)
	{
		if($this->isLogged() && $password != false)
		{
			rMail::create($this->getObject()->getId(), null, "subscribe", array("password" => $password))
					->send();
		}
	}

	public function getObject()
	{
		return $this->getAttribute("object");
	}

	public function isAdmin()
	{
		if(!$this->getObject()) return false;
		if(!$this->isLogged()) return false;
		return $this->getObject()->getIsAdmin();
	}

	public function getId()
	{
		return $this->hasAttribute("id") ? $this->getAttribute("id") : false;
	}

	public function denyLoggedIn($redirect="@homepage?loggedin=true")
	{
		if($this->isLogged())
		{
			sfContext::getInstance()->getController()->redirect($redirect);
		}
	}

	// Has new messages (count)
	public function getNewMessagesCount($contact = false)
	{
		if($contact == false) $contact = $this->getId(); // me :)

		$newmsg = Doctrine_Query::create()
					->from('Messagerie m')
					->where('m.profil_id = ' . (int) $contact )
					->andWhere('m.seen_at IS NULL')
					->andWhere('m.is_deleted_receiver = 0')
					->count();

		return $newmsg;
	}

	// Total d'amis
	public function getFriendsIds()
	{
		$list = array();
		$friends = $this->getObject()->getFriendsArray();
		foreach($friends as $f) {
			$list[] = $f["contact_id"];
		}
		return $list;
	}

	public function getFriendsCount($contact = false)
	{
		if($contact == false) $contact = $this->getId(); // me :)

		$check_pending = Doctrine_Query::create()
					->from('ProfilProfil p')
					->where('p.profil_id = ? ',  $contact )
					->andWhere('p.is_activated = 1')
					->count();

		return $check_pending;
	}

	// Has friend requests (count for notification)
	public function getFriendsRequestCount($contact = false)
	{
		if($contact == false) $contact = $this->getId(); // me :)

		$check_pending = Doctrine_Query::create()
					->from('ProfilProfil p')
					->where('p.contact_id = ? ', $contact )
					->andWhere('p.is_activated = 0')
					->count();

		return $check_pending;
	}

	// user = ASKER / contact = person who received the demand
	public function hasPendingRequest($user, $contact = false)
	{
		if($contact == false) $contact = $this->getId(); // me :)

		$check_pending = Doctrine_Query::create()
					->from('ProfilProfil p')
					->where("(p.profil_id=?", $user)
					->andWhere("p.contact_id=?)", $contact)
					->andWhere('(p.is_activated = 0 OR p.is_activated = -1)')
					->fetchOne();

		return ($check_pending ? $check_pending : false);
	}

	// User ($contact) is in projet ?
	public function isInProjet($pid, $contact = false)
	{
		if($contact == false) $contact = $this->getId(); // me :)

		// check creator ?
		$creator = Doctrine_Query::create()
					->from('Projet p')
					->where("p.id = ?", $pid)
					->fetchOne();

		if($creator)
		{
			//if($creator->getCreateurId() == $contact)
			//	return false;
		}

		$check = Doctrine_Query::create()
					->from('ProfilProjet p')
					->where("p.profil_id = ?" ,$contact)
					->andWhere("p.projet_id = ?", $pid)
					->fetchOne();

		return $check ? true : false;
	}

	// User ($contact) is in event ?
	public function isInEvent($eid, $contact = false)
	{
		if($contact == false) $contact = $this->getId(); // me :)

		// check creator ?
		$creator = Doctrine_Query::create()
									->from('Event p')
									->where("p.id = ?", $eid)
									->fetchOne();

		if($creator)
		{
			/*if($creator->getCreateurId() == $contact)
				return "yes";*/
		}

		// Check relation
		$relation = Doctrine_Query::create()
									->from('EventInvite p')
									->where("p.event_id = ?", $eid)
									->andWhere("p.profil_id = ?", $contact)
									->fetchOne();

		if($relation)
		{
			return $relation->getEtat();
		}
		else
		{
			return "pending";
		}
	}

	public function editProject($projet_id, $redirec)
	{
		// Check existance
		$this->projet = Doctrine::getTable('Projet')->find($projet_id);
		if(!$this->projet) $this->redirect404();

		// Check rights
		if($this->hasProjetRight($projet_id) || $this->isAdmin())
		{
			// OK
			return $this->projet;
		}
		else
		{
			sfContext::getInstance()->getController()->redirect($redirec);
		}
	}

	public function hasProjetRight($projet_id)
	{
		if($this->getRoleInProjet($projet_id) == Projet::ROLE_REFERENT || $this->getRoleInProjet($projet_id) == Projet::ROLE_CREATOR)
			return true;

		return false;
	}

	public function getRoleInProjet($pid, $contact = false)
	{
		if($contact == false) $contact = $this->getId(); // me :)

		// check creator ?
		$creator = Doctrine_Query::create()
					->from('Projet p')
					->where("p.id = ?", $pid)
					->fetchOne();

		if($creator)
		{
			if($creator->getCreateurId() == $contact)
				return Projet::ROLE_CREATOR;
		}

		$check = Doctrine_Query::create()
					->from('ProfilProjet p')
					->where("p.profil_id = ?" , $this->getId())
					->andWhere("p.projet_id = ?", $pid)
					->fetchOne();

		return isset($check["role"]) && $check["role"] ? $check["role"] : "foreigner";
	}

	public function isFriendWith($user, $contact = false, $confirmed=1)
	{
		if($contact == false) $contact = $this->getId(); // me :)

		$check_relation = Doctrine_Query::create()
					->from('ProfilProfil p')
					->where('(p.profil_id = ' . (int) $user . ' AND p.contact_id = ' . (int) $contact . ') OR (p.profil_id = ' . (int) $contact . ' AND p.contact_id = ' . (int) $user . ')')
					->fetchOne();

		return $check_relation ? $check_relation : false;
	}

	public function flush()
	{
		$this->setAuthenticated(false);
		$this->setAttribute('login', false);
		$this->setAttribute('email', false);
		$this->setAttribute('id', false);
		$this->setAttribute('nom', false);
		$this->setAttribute('prenom', false);
		$this->setAttribute('object', false);

		sfContext::getInstance()->getResponse()->setCookie('AUTHKEY', '', time() - 13600, '/');
	}

	public function regenSession($user)
	{
		if($user)
		{
			$this->setAttribute('login', $user->getLogin());
			$this->setAttribute('email', $user->getEmail());
			$this->setAttribute('id', $user->getId());
			$this->setAttribute('nom', $user->getNom());
			$this->setAttribute('prenom', $user->getPrenom());
			$this->setAuthenticated(true);
			$this->setAttribute('object', $user);
		}
	}

	public function createAuth($user)
	{
		if($user)
		{
			$this->regenSession($user);
		}
	}

	public function formatRelations($object, $method=false)
	{
		if(is_object($object))
		{
			$r = array();
			foreach($object as $item)
			{
				if(!$method)
					$r[] = $item->getId();
				else
					$r[] = $item->{$method}();
			}
			return $r;
		}

		return array();
	}

	public function saveRelations($data, $model, $limit, $id=false, $idforce=false, $querys = array(), $reverse = false, $delother = false)
	{
		if($id == false) $id = $this->getId();

		// Create relations if exists
		list($m1,$m2) = explode(",", $model);
		$fresh = str_replace(",", "",$model);

		// Flush precedent relations
		$query = Doctrine_Query::create()->delete()
				->from($m1.$m2);

		if(!$reverse)
				$query->where( $m1 . '_id = ?', $id);
		else
				$query->where( $m2 . '_id = ?', $id);

		if(count($querys))
		{
			foreach($querys as $param => $value)
			{
				$query->andWhere($param . " = ?", $value);
			}
		}

		$query->execute();

		$counter=0;

		if(count($data))
		{
			$time = 1;

			foreach($data as $item_id)
			{
				if($counter >= $limit) continue;
				$relation = new $fresh();

				if(!$reverse)
				{
					$relation->set(strtolower($m1)."_id", $id);
					$relation->set(($idforce ? $idforce : strtolower($m2))."_id", $item_id);

					if($delother)
					{
						// Nothing
					}
				}
				else
				{
					// Pour les référents
					$relation->set(strtolower($m2)."_id", $id);
					$relation->set(($idforce ? $idforce : strtolower($m1))."_id", $item_id);

					if($delother)
					{
						$delo = Doctrine_Query::create()
										->delete()
										->from($fresh)
										->where(($idforce ? $idforce : strtolower($m1))."_id = ?", $item_id)
										->andWhere(strtolower($m2)."_id = ?", $id)
										->execute();
					}

					if(count($querys))
					{
						foreach($querys as $param => $value)
						{
							$relation->set($param, $value);
						}
					}

					if($model == "Profil,Projet")
					{
						$relation->setDate(date('Y-m-d H:i:s', strtotime("+".++$time." seconds")));
					}
				}

				$relation->save();

				$counter++;
			}
		}
	}

	public function checkLogin($username, $password)
	{
		$user = Doctrine_Query::create()
							->from('Profil p')
							->where('p.login = ?', $username)
							->andWhere('p.password = ?', md5($password))
							->fetchOne();

		return $user;
	}
}
