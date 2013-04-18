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

class CommentACL extends ACLRules
{
	static function init($comment, $step = false, $stop = false)
	{
		$result = self::find($comment);
		return parent::go($result, $step, $stop);
	}

	static function find($comment)
	{
		$check = false;

		if(!is_array($comment))
		{
			$comment = Doctrine_Query::create()->from("Commentaire")->where("id=?", $comment)->fetchOne(array(), Doctrine::HYDRATE_ARRAY);

			if(!$comment)
				return self::$acl;
		}

		// Autorisations créateur
		if($comment["profil_id"] == sfContext::getInstance()->getUser()->getId())
			return self::$acl_owner;
		elseif($comment["profil_id"] == null)
			self::$fatherless = true;

		// Check Role Project OPr Event
		switch($comment["content_type"])
		{
			case "idea":
				$relation = Doctrine_Query::create()->from("ProjetIdee")->where("id=?", $comment["content_id"])->fetchOne(array(), "idea");
				return $relation["ACL"];
			break;
			default:
				return self::$acl;
			break;
		}

		return self::$acl;
	}
}

?>