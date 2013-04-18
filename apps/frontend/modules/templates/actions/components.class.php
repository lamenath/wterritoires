<?php

/***
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

class templatesComponents extends sfComponents
{
	public function executeForm()
	{

	}

	public function executeMenu()
	{
		$target = dirname(__FILE__) ."/../../" . $this->module . "/config/menu.yml";
		$this->tree = array();
		$this->sfRoute = false;

		if(file_exists($target))
		{
			try
			{
				$yaml = new sfYamlParser();
				$value = $yaml->parse(file_get_contents($target));

				if(isset($value["menus"][$this->load]))
				{
					$this->pla = $value["menus"][$this->load];
					$this->mini = (isset($value["menus"][$this->load]["use_display"]) && $value["menus"][$this->load]["use_display"] == "mini" ? true : false);
					$this->tree = $value["menus"][$this->load]["tree"];
					$this->use_proute = isset($value["menus"][$this->load]["use_proute"]);

					// Enable sfRoute
					foreach($this->tree as $act => $item)
					{
						if(isset($value["menus"][$this->load]["use_proute"]) && $value["menus"][$this->load]["use_proute"] === true)
							$params = array("action" => "index", "proute" => $act);
						else
							$params = array("action" => $act);

						if(preg_match_all("/(\{\%(.*?)\})/ui", $item, $matches))
						{
							foreach($matches[0] as $k => $ix)
							{
								if(isset($this->object[$matches[2][$k]]))
									$item = preg_replace("~". $ix . "~", $this->object[$matches[2][$k]], $item);
							}
						}

						$this->tree[$act] = array("title" => $item, "url" => "");

						// Ok...
						foreach($value["menus"][$this->load]["sf_route"]["params"] as $param => $replace)
						{
							$params[$param] = sfContext::getInstance()->getRequest()->getParameter($replace);
						}

						$this->tree[$act]["debug"] = $value["menus"][$this->load]["sf_route"]["name"] . "?=" . http_build_query($params);
						$this->tree[$act]["url"] = sfContext::getInstance()->getController()->genUrl($this->tree[$act]["debug"]);
						
						if(isset($this->pla["transport_search"]))
						{
							$this->tree[$act]["url"] = sfContext::getInstance()->getController()->genUrl($this->tree[$act]["debug"]) . "?search=".sfContext::getInstance()->getRequest()->getParameter("search");
						}
					}
				}
				else
				{
					error_log("[menu][sfYamlParser] Node '" . $this->load . "' doesn't exists (in " .  $target . ")");
				}
			}
			catch(Exception $e)
			{
				error_log("[menu][sfYamlParser] " . $e->getMessage());
			}
		}
		else
		{
			error_log("Unable to load menu.yml for action '" . $this->module. "' at " . $target);
		}
	}
}