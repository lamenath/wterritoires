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

class searchActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		switch($request->getParameter("proute"))
		{
			case "project":
				
				sfContext::getInstance()->getController()->getAction("project", "list")->execute($request);
				
				$this->moduleRoute = "project";
				$this->proute = "listlight";
				break;
			case "members":
				
				sfContext::getInstance()->getController()->getAction("profile", "members")->execute($request);
				
				$this->moduleRoute = "profile";
				$this->proute = "members";
				break;
				
			case "structures":
				
				sfContext::getInstance()->getController()->getAction("profile", "members")->execute($request);
				
				$this->moduleRoute = "structure";
				$this->proute = "index";
				break;
				
			case "ressources":
				
				sfContext::getInstance()->getController()->getAction("ressource", "list")->execute($request);
				
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
