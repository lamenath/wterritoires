<?php

/***
	wTerritoires <http://www.wterritoires.fr/>
	Copyright (C) 2013 Simon Lamellière <opensource@worketer.fr>

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

class dashboardComponents extends sfComponents
{
	public function executeVariations(sfWebRequest $request)
	{
		// preparing data
		$this->data = array(
			"profile" => array("Profils", "Profil", 0, 0, 0),
			"project" => array("Projets", "Projet", 0, 0, 0),
			"event" => array("Evénements", "Event", 0, 0, 0)
		);

		// prepare
		foreach($this->data as $k => $item)
		{
			$this->data[$k][2] = Doctrine_Query::create()
								->from($item[1])
								->where("DATE(created_at) <= ?", date("Y-m-d"))
								->count();

			$this->data[$k][3] = Doctrine_Query::create()
								->from($item[1])
								->where("DATE(created_at) <= ?", date("Y-m-d", strtotime("-1 month")))
								->count();

			$this->data[$k][4] = Doctrine_Query::create()
								->from($item[1])
								->where("DATE(created_at) <= ?", date("Y-m-d", strtotime("-2 month")))
								->count();
		}
	}

	public function executeSegments(sfWebRequest $request)
	{
		$seg = Doctrine_Query::create()->from("Segment")->orderBy("created_at DESC");
		
		if($sr = $request->getParameter("search"))
			$seg->where("nom LIKE ? OR localite LIKE ?", array("%".$sr."%","%".$sr."%"));
		
		list($this->pager, $this->total) = RRR::pager($seg, "Segment", 20);
	}
	
	public function executeMailings(sfWebRequest $request)
	{
		$seg = Doctrine_Query::create()->from("Mailing")->orderBy("created_at DESC");
		
		if($sr = $request->getParameter("search"))
			$seg->where("sujet LIKE ?", array("%".$sr."%"));
		
		list($this->pager, $this->total) = RRR::pager($seg, "Mailing", 20);
	}
	
	public function executeTendances()
	{
		
	}
	
	public function executeEdit()
	{
		
	}
}