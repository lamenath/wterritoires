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
	Définit le comportement à adopter pour les profils (autorisations)
	---

**/

class ProfileACL extends ACLRules
{
	static function init($profile, $step = false, $stop = false)
	{
		if(!is_array($profile))
		{
			$profile = Doctrine_Query::create()->from("Profil")->where("id=?", $profile)->fetchOne(array(), "profile");
		}

		$result = self::find($profile);

		return parent::go($result, $step, $stop);
	}

	static function find($profile)
	{
		$acl = parent::$acl_profile;

		// Check Public
		if($profile["privacy_type"] == "friends")
		{
			if(!sfContext::getInstance()->getUser()->isAuthenticated())
			{
				$acl["read"] = false;
			}
			else
			{
				// Check if they are friends
				if(!sfContext::getInstance()->getUser()->isFriendWith(sfContext::getInstance()->getUser()->getId(), $profile["id"]))
				{
					$acl["read"] = false;
				}
			}
		}

		if($profile["privacy_type"] == "private")
		{
			// Check if user is identified
			if(!sfContext::getInstance()->getUser()->isAuthenticated())
			{
				$acl["read"] = false;
			}
		}

		return $acl;
	}
}

?>