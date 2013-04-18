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

class defaultActions extends sfActionsJson
{
	public $rayon = 50;
	public $bypass = array("index", "error404");
	public $redirected = "welcome/index";

	public function executeIndex(sfWebRequest $request)
	{
		switch($request->getParameter("proute"))
		{
			case "index":
				$this->proute = "news";
				break;
			case "map":
				$this->proute = "map";
				break;
			case "structures":
				$this->proute = "index";
				$this->moduleRoute = "structure";
				break;
			case "invitations":
				$this->proute = "invitations";
				break;
			case "contacts":
				$this->proute = "contacts";
				break;
			default:
				$this->proute = "news";
				//$this->moduleRoute = "story";
			break;
		}
	}

	public function executeError404(sfWebRequest $request)
	{

	}
}
