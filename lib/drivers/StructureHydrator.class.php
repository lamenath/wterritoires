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

class StructureHydrator extends Doctrine_Hydrator_ArrayDriver
{
	static function hydrate($structure)
	{
		if(isset($structure["Structure"]))
		{
			$block = true;
			$old = $structure;
			$structure = $structure["Structure"];
			$structure["extraData"] = $old;

			unset($old, $structure["extraData"]["Structure"]);
		}

		// Set images
		$structure["photo_mini"] = sfConfig::get("app_cdn_full") . "/structure/" . ($structure["photo"] ? "mini_" . $structure["photo"] : "default.png");
		$structure["photo_std"] = sfConfig::get("app_cdn_full") . "/structure/" . ($structure["photo"] ? "normal_" . $structure["photo"] : "default.png");
		$structure["photo_max"] = sfConfig::get("app_cdn_full") . "/structure/" . ($structure["photo"] ? "max_" . $structure["photo"] : "default.png");
		
		// ACL
		$structure["ACL"] = StructureACL::init($structure);

		// Url
		$structure["website"] = $structure["url"];
		$structure["url"] = sfContext::getInstance()->getController()->genUrl("@structure2?slug=".$structure["slug"], true);

		return $structure;
	}

	public function hydrateResultSet($stmt)
	{
		$structures = parent::hydrateResultSet($stmt);

		foreach($structures as &$structure)
		{
			$structure = self::hydrate($structure);

			// Creator
			$structure["creator"] = Doctrine_Query::create()
														->from("Profil p")
														->where("p.id=?", $structure["createur_id"])
														->fetchOne(array(), "profile_light");

			// Relations formattées
			$structure["members"] = Doctrine_Query::create()
													->from("ProfilStructure p")
													->leftJoin("p.Profil pf")
													->where("p.structure_id=?", $structure["id"])
													->execute(array(), "profile_light");

			// Relations formattées
			$structure["admins"] = Doctrine_Query::create()
													->from("ProfilStructure p")
													->leftJoin("p.Profil pf")
													->where("p.structure_id=?", $structure["id"])
													->andWhere("p.role = ?", "admin")
													->execute(array(), "profile_light");
		}

		return $structures;
	}
}

?>