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
**/

class ideasComponents extends sfComponents
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->ideas = Doctrine_Query::create()
											->from("ProjetIdee r")
											->leftJoin("r.Profil p");

		switch($this->identifier)
		{
			case "project":
				$this->ideas =	$this->ideas->where("projet_id=?", $this->id);
			break;
			case "groupe":

			break;
			case "event":
				$this->ideas =	$this->ideas->where("event_id=?", $this->id);
			break;
			default:
				$this->ideas = array();
			break;
		}

		$this->ideas = $this->ideas->orderBy("r.created_at DESC");

		$numPage = $request->getParameter('page', $request->getParameter("page"));
		$nbPosts = sfConfig::get('app_posts_number_per_page', 10);

		$this->pager = new sfDoctrinePager('ProjetIdee', $nbPosts);
		$this->pager->setQuery($this->ideas);
		$this->pager->setPage($numPage);
		$this->pager->init();
	}
}

?>