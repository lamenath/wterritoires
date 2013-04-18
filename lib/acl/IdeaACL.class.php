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
	Définit le comportement à adopter pour les idées (dialogues) - ACL
	---

**/

class IdeaACL extends ACLRules
{
	static function init($idea, $step = false, $stop = false)
	{
		$result = self::find($idea);
		return parent::go($result, $step, $stop);
	}

	static function find($idea)
	{
		$check = false;

		if(!is_array($idea))
		{
			$idea = Doctrine_Query::create()->from("ProjetIdee")->where("id=?", $idea)->fetchOne(array(), Doctrine::HYDRATE_ARRAY);

			if(!$idea)
				return self::$acl;
		}

		// Autorisations créateur
		if($idea["profil_id"] == sfContext::getInstance()->getUser()->getId())
			return self::$acl_owner;
		elseif($idea["profil_id"] == null)
			self::$fatherless = true;

		// Check Role Project OPr Event
		if($idea["projet_id"])
			if(ProjectACL::init($idea["projet_id"], "admin") === true)
				return (self::$fatherless === true ? self::$acl_owner : self::$acl_admin);

		if($idea["event_id"])
			if(EventACL::init($idea["event_id"], "admin") === true)
				return (self::$fatherless === true ? self::$acl_owner : self::$acl_admin);

		return self::$acl;
	}
}

?>