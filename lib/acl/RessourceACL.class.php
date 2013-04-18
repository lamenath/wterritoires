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
	Définit le comportement à adopter pour les ressources (autorisations)
	---

**/

class RessourceACL extends ACLRules
{
	static function init($ressource, $step = false, $stop = false)
	{
		$result = self::find($ressource);
		return parent::go($result, $step, $stop);
	}

	static function find($ressource)
	{
		$check = false;

		if(!is_array($ressource))
		{
			$ressource = Doctrine_Query::create()->from("Ressource")->where("id=?", $ressource)->fetchOne(array(), Doctrine::HYDRATE_ARRAY);
		}

		// Autorisations créateur
		if($ressource["createur_id"] == sfContext::getInstance()->getUser()->getId())
			return self::$acl_owner;
		elseif($ressource["createur_id"] == null)
			self::$fatherless = true;

		// Check Role Project OPr Event
		if($ressource["projet_id"])
			if(ProjectACL::init($ressource["projet_id"], "admin") === true)
				return (self::$fatherless === true ? self::$acl_owner : self::$acl_admin);

		if($ressource["event_id"])
			if(EventACL::init($ressource["event_id"], "admin") === true)
				return (self::$fatherless === true ? self::$acl_owner : self::$acl_admin);

		return self::$acl;
	}
}

?>