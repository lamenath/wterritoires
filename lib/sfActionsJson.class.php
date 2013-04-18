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

class sfActionsJson extends sfActions
{
	private $jsonable = true;
	private $contents = array();
	static $SUCCESS_RELOAD = array("status" => 200, "errors" => array(), "method" => "refresh");
	static $ERROR_RELOAD = array("status" => 500, "message" => "Impossible d'effectuer cette opération", "errors" => array(), "method" => "display");
	static $login_disabled = array("json/tendance", "json/feed", "structure/index", "event/index", "profile/index", "project/all", "project/index", "project/list");

	public function preExecute()
	{
		$uri = sfContext::getInstance()->getRequest()->getParameter("module") ."/" . sfContext::getInstance()->getRequest()->getParameter("action");

		if(!in_array($uri, self::$login_disabled))
			$this->getUser()->requireLogin("subscribe/index", (isset($this->redirected) ? $this->redirected : false));

		if(isset($this->bypass) && in_array( sfContext::getInstance()->getRequest()->getParameter("action"), $this->bypass))
			return false;

		parent::preExecute();
	}

	public function postExecute()
	{
		if(isset($this->bypass) && in_array( sfContext::getInstance()->getRequest()->getParameter("action"), $this->bypass))
			return false;

		if($this->jsonable === true)
		{
			sfContext::getInstance()->getController()->setRenderMode(sfView::RENDER_NONE);
			// (Firefox bug, so disable it).... sfContext::getInstance()->getResponse()->setHttpHeader('Content-Type', 'application/json');
			sfContext::getInstance()->getResponse()->sendHttpHeaders();
			sfContext::getInstance()->getResponse()->setContent( json_encode($this->contents) );
		}
	}

	public function isJsonable($result)
	{
		$this->jsonable = (bool) $result;
		return $this;
	}

	public function setJsonContents($contents, $force = false)
	{
		$this->forced_array = $force;
		$this->contents = (array) $contents;
	}

	static function getSfErrors($form)
	{
		$errors = array("global" => array(), "local" => array());

		if($form->hasGlobalErrors())
		{
			foreach($form->getGlobalErrors() as $e => $name)
			{
				$errors["global"][] = (string) $name;
			}
		}

		if($form->hasErrors())
		{
			foreach($form as $widget)
			{
				if($widget->hasError())
				{
					$errors["local"][$widget->renderId()]
						= $errors["local"][$widget->getName()]
							= (string) $widget->getError();
				}
			}
		}

		return $errors;
	}
}

?>