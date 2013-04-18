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

class IdeaHydrator extends Doctrine_Hydrator_ArrayDriver
{
	public function hydrateResultSet($stmt)
	{
		$ideas = parent::hydrateResultSet($stmt);

		foreach($ideas as &$user)
		{
			// ACL
			$user["ACL"] = IdeaACL::init($user);

			if(isset($user["Profil"]))
				$user["Profil"] = ProfileHydrator::hydrate($user["Profil"]);

			$user["nb_vote"] = Doctrine_Query::create()
												->from("CommentaireVote p")
												->where("p.content_type=?", "idea")
												->andWhere("p.content_id=?", $user["id"])
												->count();

			$user["did_i_vote"] = Doctrine_Query::create()
												->from("CommentaireVote p")
												->where("p.content_type=?", "idea")
												->andWhere("p.profil_id=?", sfContext::getInstance()->getUser()->getId())
												->andWhere("p.content_id=?", $user["id"])
												->count();
		}

		return $ideas;
	}
}

?>