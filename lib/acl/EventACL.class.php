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
	Définit le comportement à adopter pour les événements (autorisations)
	---

**/

class EventACL extends ACLRules
{
	static function init($event, $step = false, $stop = false)
	{
		if(!is_array($event))
		{
			$event = Doctrine_Query::create()->from("Event")->where("id=?", $event)->fetchOne(array(), "event");
		}

		$result = self::find($event);

		if($event["visibilite"] == "private" && $result["write"] === false)
			$result["invite"] = false;

		return parent::go($result, $step, $stop);
	}

	static function find($event)
	{
		// Autorisations créateur
		if($event["createur_id"] == sfContext::getInstance()->getUser()->getId())
			return self::$acl_owner;
		elseif($event["createur_id"] == null)
			self::$fatherless = true;

		// Check Admins
		$check = Doctrine_Query::create()
								->from('EventAdmin p')
								->where("p.profil_id = ?" , sfContext::getInstance()->getUser()->getId())
								->andWhere("p.event_id = ?", $event["id"])
								->fetchOne(array(), Doctrine::HYDRATE_ARRAY);

		if($check)
		{
			return (self::$fatherless === true ? self::$acl_owner : self::$acl_admin);
		}

		// Check Participants
		$check = Doctrine_Query::create()
								->from('EventInvite p')
								->where("p.profil_id = ?" , sfContext::getInstance()->getUser()->getId())
								->andWhere("p.event_id = ?", $event["id"])
								->fetchOne(array(), Doctrine::HYDRATE_ARRAY);

		if($check)
		{
			switch($check["etat"])
			{
				case "yes":
					return self::$acl_actor;
				break;
				case "no":
				case "pending":
					return self::$acl_follower;
				break;
			}
		}

		return ($event["visibilite"] == "private" ? self::$acl_private : self::$acl);
	}
}

?>