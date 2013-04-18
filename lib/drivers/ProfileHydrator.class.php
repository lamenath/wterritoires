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

class ProfileHydrator extends Doctrine_Hydrator_ArrayDriver
{
	static function blank()
	{
		$user = array("id" => 0, "full_name" => "Inconnu");

		return $user;
	}

	static function hydrate($user)
	{
		// Relations ?
		if(isset($user["Profil"]) || isset($user["Contact"]) || isset($user["Sender"]))
		{
			$block = true;
			$old = $user;
			$user = isset($user["Profil"]) ? $user["Profil"] : (isset($user["Contact"]) ?  $user["Contact"] :  $user["Sender"]);
			$user["extraData"] = $old;

			// Inbox and co
			if(isset($user["extraData"]["Sender"]))
			{
				$user["extraData"]["Sender"] = self::hydrate($user["extraData"]["Sender"]);
			}

			unset($old, $user["extraData"]["Profil"]);
		}

		// Set User Data
		$user["full_name"] = ucfirst(trim($user["prenom"])) . " " . mb_strtoupper($user["nom"], "UTF-8");
		$user["full_name_me"] = $user["id"] != sfContext::getInstance()->getUser()->getId() ? $user["full_name"] : sfContext::getInstance()->getI18n()->__("vous");
		$user["url"] = sfContext::getInstance()->getController()->genUrl("@public_profile?slug=".$user["slug"], true);

		// Set User images
		$user["photo_mini"] = sfConfig::get("app_cdn_full") . ($user["photo"] ? "profil/mini_" . $user["photo"] : "profil/default.png");
		$user["photo_std"] = sfConfig::get("app_cdn_full") . ($user["photo"] ? "profil/normal_" . $user["photo"] : "profil/default.png");
		$user["photo_max"] = sfConfig::get("app_cdn_full") . "/user/" . ($user["photo"] ? "profil/max_" . $user["photo"] : "profil/default.png");

		// ACL
		if(!isset($user["ACL"]))
			$user["ACL"] = ProfileACL::init($user);

		// Hydrate Buddies
		if(isset($user["extraData"]["Buddies"]))
		{
			foreach($user["extraData"]["Buddies"] as &$buddie)
			{
				$buddie = self::hydrate($buddie);
			}
		}

		return $user;
	}

	public function hydrateResultSet($stmt)
	{
		$users = parent::hydrateResultSet($stmt);
		$block = false;

		foreach($users as &$user)
		{
			// Default hydratation
			$user = self::hydrate($user);

			// Comptes
			$user["count_observer"] = Doctrine_Query::create()
															->from("ProfilProjet p")
															->where("p.role=?", "observateur")
															->andWhere("p.projet_id=?", $user["id"])
															->useResultCache(true, 3600)
															->count();

			$user["count_actor"] = Doctrine_Query::create()
															->from("ProfilProjet p")
															->where("p.role!=?", "observateur")
															->andWhere("p.projet_id=?", $user["id"])
															->useResultCache(true, 3600)
															->count();

			// Relations formattées
			$user["contribute_on"] = Doctrine_Query::create()
														->from("ProfilProjet p")
														->leftJoin("p.Projet pf")
														->where("p.role=?", "contributeur")
														->andWhere("p.profil_id=?", $user["id"])
														->execute(array(), "project_light");

			$user["observe_on"] = Doctrine_Query::create()
															->from("ProfilProjet p")
															->leftJoin("p.Projet pf")
															->where("p.role=?", "observateur")
															->andWhere("p.profil_id=?", $user["id"])
															->execute(array(), "project_light");

			$user["referent_on"] = Doctrine_Query::create()
															->from("ProfilProjet p")
															->leftJoin("p.Projet pf")
															->where("p.role=?", "referent")
															->andWhere("p.profil_id=?", $user["id"])
															->execute(array(), "project_light");
		}

		return $users;
	}
}

?>