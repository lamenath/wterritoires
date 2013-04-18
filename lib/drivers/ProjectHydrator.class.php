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

class ProjectHydrator extends Doctrine_Hydrator_ArrayDriver
{
	static function hydrate($project)
	{
		if(isset($project["Projet"]))
		{
			$block = true;
			$old = $project;
			$project = $project["Projet"];
			$project["extraData"] = $old;

			unset($old, $project["extraData"]["Projet"]);
		}

		// Portée
		switch($project["action"])
		{
			case "regional":
				$project["action"] = sfContext::getInstance()->getI18N()->__("Régionale");
			break;
			case "territorial":
				$project["action"] = sfContext::getInstance()->getI18N()->__("Territoriale");
			break;
			case "local":
				$project["action"] = sfContext::getInstance()->getI18N()->__("Locale");
			break;
			case "ultralocal":
				$project["action"] = sfContext::getInstance()->getI18N()->__("Ultra-Locale");
			break;
		}

		// Set images
		$project["photo_mini"] = sfConfig::get("app_cdn_full") . "/projet/" . ($project["photo"] ? "mini_" . $project["photo"] : "default.png");
		$project["photo_std"] = sfConfig::get("app_cdn_full") . "/projet/" . ($project["photo"] ? "normal_" . $project["photo"] : "default.png");
		$project["photo_max"] = sfConfig::get("app_cdn_full") . "/projet/" . ($project["photo"] ? "max_" . $project["photo"] : "default.png");

		// ACL
		$project["ACL"] = ProjectACL::init($project);

		// Url
		$project["url"] = sfContext::getInstance()->getController()->genUrl("@project?slug=".$project["slug"], true);

		return $project;
	}

	public function hydrateResultSet($stmt)
	{
		$projects = parent::hydrateResultSet($stmt);

		foreach($projects as &$project)
		{
			$project = self::hydrate($project);

			// Creator
			$project["creator"] = Doctrine_Query::create()
														->from("Profil p")
														->where("p.id=?", $project["createur_id"])
														->fetchOne(array(), "profile_light");

			// Comptes
			$project["count_observers"] = Doctrine_Query::create()
													->from("ProfilProjet p")
													->where("p.role=?", "observateur")
													->andWhere("p.projet_id=?", $project["id"])
													->useResultCache(true, 3600)
													->count();

			$project["count_actors"] = Doctrine_Query::create()
													->from("ProfilProjet p")
													->where("p.role!=?", "observateur")
													->andWhere("p.projet_id=?", $project["id"])
													->useResultCache(true, 3600)
													->count();

			$project["count_total"] = $project["count_observers"] + $project["count_actors"];
			
			$project["count_ideas"] = Doctrine_Query::create()
													->from("ProjetIdee p")
													->where("p.projet_id=?", $project["id"])
													->count();

			$project["count_ressources"] = Doctrine_Query::create()
													->from("Ressource p")
													->where("p.projet_id=?", $project["id"])
													->count();

			// Relations formattées
			$project["contributors"] = Doctrine_Query::create()
													->from("ProfilProjet p")
													->leftJoin("p.Profil pf")
													->where("p.role=?", "contributeur")
													->andWhere("p.projet_id=?", $project["id"])
													->execute(array(), "profile_light");

			$project["observers"] = Doctrine_Query::create()
													->from("ProfilProjet p")
													->leftJoin("p.Profil pf")
													->where("p.role=?", "observateur")
													->andWhere("p.projet_id=?", $project["id"])
													->execute(array(), "profile_light");

			$project["referents"] = Doctrine_Query::create()
													->from("ProfilProjet p")
													->leftJoin("p.Profil pf")
													->where("p.role=?", "referent")
													->andWhere("p.projet_id=?", $project["id"])
													->execute(array(), "profile_light");
		}

		return $projects;
	}
}

?>