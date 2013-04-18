<?php

/**
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

class referentielActions extends sfActions
{
	public $admitted = array("theme", "filiere", "metier", "competence");

	public function preExecute()
	{
		if($this->getRequest()->getParameter("action") == "index" && !in_array($this->getRequest()->getParameter("type"), $this->admitted))
			$this->redirect404();
	}

	public function executeHome(sfWebRequest $request)
	{

	}

	public function executeIndex(sfWebRequest $request)
	{
		// Format names
		$this->modelt = $nameMini = mb_strtolower($request->getParameter("type"), "UTF-8");
		$this->model = $nameModel = ucfirst($nameMini);

		// Query
		$this->item = Doctrine_Query::create()
										->from($nameModel)
										->where("slug=?", $request->getParameter("slug"))
										->fetchOne();

		// Wikidescription
		if(!$this->item->get("description"))
		{
			$wikipedia = RRR::wikipedia($this->item["nom"], $this->getUser()->getCulture());

			if(is_array($wikipedia))
			{
				$this->item->setDescription($wikipedia[1] . " (source: Wikipedia)");
				$this->item->save();
			}
		}

		// Redirect 404
		if(!$this->item)
			$this->redirect404();

		// Search Param
		$request->setParameter("search", $this->item->getNom());
		$this->getResponse()->setTitle($this->item->getNom() . " - " . sfConfig::get("app_title_page"));

		// Switch contents
		switch($request->getParameter("proute"))
		{
			case "map":

				$this->proute = "map";

			break;

			case "user":

				$this->moduleRoute = "profile";
				$this->proute = "members";

				sfContext::getInstance()->getController()->getAction("profile", "members")->execute($request);

			break;

			case "structure":

				sfContext::getInstance()->getController()->getAction("profile", "members")->execute($request);

				$this->moduleRoute = "structure";
				$this->proute = "index";

			break;

			case "project":

				sfContext::getInstance()->getController()->getAction("project", "list")->execute($request);

				$this->moduleRoute = "project";
				$this->proute = "listlight";
				break;
				
			case "ressources":

				sfContext::getInstance()->getController()->getAction("project", "list")->execute($request);

				$this->moduleRoute = "ressource";
				$this->proute = "index";
				break;
				
			case "event":

				sfContext::getInstance()->getController()->getAction("event", "all")->execute($request);

				$this->moduleRoute = "event";
				$this->proute = "list";
				break;
		}
	}
}
