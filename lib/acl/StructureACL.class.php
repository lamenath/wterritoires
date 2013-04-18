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

class StructureACL extends ACLRules
{
	static function init($structure, $step = false, $stop = false)
	{
		if(!is_array($structure))
		{
			$structure = Doctrine_Query::create()->from("Structure")->where("id=?", $structure)->fetchOne(array(), "structure");
		}

		$result = self::find($structure);

		return parent::go($result, $step, $stop);
	}

	static function find($structure)
	{
		// Autorisations créateur
		if($structure["createur_id"] == sfContext::getInstance()->getUser()->getId())
			return self::$acl_owner;
		elseif($structure["createur_id"] == null)
			self::$fatherless = true;

		// Check Role
		$check = Doctrine_Query::create()
								->from('ProfilStructure p')
								->where("p.profil_id = ?" , sfContext::getInstance()->getUser()->getId())
								->andWhere("p.structure_id = ?", $structure["id"])
								->fetchOne(array(), Doctrine::HYDRATE_ARRAY);

		if($check)
		{
			switch($check["role"])
			{
				case "admin":
					return (self::$fatherless === true ? self::$acl_owner : self::$acl_admin);
				break;
				default:
					return self::$acl_actor;
				break;
			}
		}

		return self::$acl;
	}
}

?>