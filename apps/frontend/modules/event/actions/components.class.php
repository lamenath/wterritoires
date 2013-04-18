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

class eventComponents extends sfComponents
{
	public function executeSidebar()
	{
		// No Left Join in main query (performance)
		$this->pictures =  Doctrine_Query::create()
										->from("PhotoProjet p")
										->where("p.event_id=?", $this->event["id"])
										->orderBy("created_at DESC")
										->execute(array(), "photo");
	}

	public function executePresentation(sfWebRequest $request)
	{
		
	}

	public function executeGuests()
	{

	}

	// Reusable list (horizontal)
	public function executeList()
	{
		if(isset($this->pager))
			$this->total = $this->pager->getNbResults();
		else
			$this->total = 0;
	}
}

?>