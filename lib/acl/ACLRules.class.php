<?php

/**
	wTerritoires <http://www.wterritoires.fr/>
	Copyright (C) 2011 Simon Lamellière <opensource@worketer.fr>

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

class ACLRules
{
	static $saved_acl = array();
	static $acl_profile = array("read" => true, "notify" => true, "inbox" => true, "invite" => true);
	static $acl_private = array("admin" => false, "remove" => false, "read" => false, "write" => false, "publish" => false, "invite" => false);
	static $acl = array("admin" => false, "remove" => false, "read" => true, "write" => false, "publish" => false, "invite" => false);
	static $acl_owner = array("admin" => true, "remove" => true, "read" => true, "write" => true, "publish" => true, "invite" => true);
	static $acl_admin = array("admin" => true, "remove" => false, "read" => true, "write" => true, "publish" => true, "invite" => true);
	static $acl_actor = array("admin" => false, "remove" => false, "read" => true, "write" => false, "publish" => true, "invite" => true);
	static $acl_follower = array("admin" => false, "remove" => false, "read" => true, "write" => false, "publish" => false, "invite" => true);
	static $fatherless = false;

	static function auto($a, $b)
	{
		$request = sfContext::getInstance()->getRequest();

		if($request->getParameter("pid"))
			ProjectACL::init($request->getParameter("pid"), $a, $b);
	}

	static function go($result, $step, $stop)
	{
		// Les administrateurs ont les pleins pouvoirs (à mettre plus tard)
		if(sfContext::getInstance()->getUser()->isAuthenticated() && sfContext::getInstance()->getUser()->getObject()->get("is_admin") === true)
			$result = self::$acl_owner;

		// save result
		self::$saved_acl = $result;
		
		// On continue;
		if($step === false)
			$result = $result;
		else
			$result = (isset($result[$step]) ? $result[$step] : false);

		if($stop === true && $result === false)
			throw new Exception("Vous n'avez pas l'autorisation de modifier ceci !");

		return $result;
	}
}

?>