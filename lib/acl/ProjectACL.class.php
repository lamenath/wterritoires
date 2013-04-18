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

	---
	Définit le comportement à adopter pour les projets (autorisations)
	---

**/

class ProjectACL extends ACLRules
{
	static function init($project, $step = false, $stop = false)
	{
		if(!is_array($project))
		{
			$project = Doctrine_Query::create()->from("Projet")->where("id=?", $project)->fetchOne(array(), "project_light");
		}

		$result = self::find($project);

		// Visibilité (projet public, ou groupe de travail privé)
		if($project["type"] == "group" && $result["write"] === false)
			$result["invite"] = false;

		return parent::go($result, $step, $stop);
	}

	static function find($project)
	{
		// Autorisations créateur
		if($project["createur_id"] == sfContext::getInstance()->getUser()->getId())
			return self::$acl_owner;
		elseif($project["createur_id"] == null)
			self::$fatherless = true;

		// Check Role
		$check = Doctrine_Query::create()
								->from('ProfilProjet p')
								->where("p.profil_id = ?" , sfContext::getInstance()->getUser()->getId())
								->andWhere("p.projet_id = ?", $project["id"])
								->fetchOne(array(), Doctrine::HYDRATE_ARRAY);

		if($check)
		{
			switch($check["role"])
			{
				case "referent":
					return (self::$fatherless === true ? self::$acl_owner : self::$acl_admin);
				break;
				case "contributeur":
					return self::$acl_actor;
				break;
				case "observateur":
					return self::$acl_follower;
				break;
			}
		}

		// Check Invitations (si le projet est privé)
		if($project["type"] == "group")
		{
			$check = Doctrine_Query::create()
									->from('Invitation p')
									->where("p.profil_id = ?" , sfContext::getInstance()->getUser()->getId())
									->andWhere("p.projet_id = ?", $project["id"])
									->fetchOne(array(), Doctrine::HYDRATE_ARRAY);

			if($check)
			{
				return self::$acl;
			}
		}

		return ($project["type"] == "group" ? self::$acl_private : self::$acl);
	}
}

?>