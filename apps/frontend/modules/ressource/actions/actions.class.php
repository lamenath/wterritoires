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

class ressourceActions extends sfActionsJson
{
	public function executeList(sfWebRequest $request)
	{
	}
	
	public function executeRemove(sfWebRequest $request)
	{
		// Continue
		if($request->getParameter("rid"))
		{
			RessourceACL::init($request->getParameter("rid"), "admin", true);

			if(($request->isMethod("PUT") || $request->isMethod("POST")))
			{
				$ressource = Doctrine::getTable("Ressource")->find($request->getParameter("rid"));

				if($ressource)
				{
					$ressource->delete();

					//
					Story::erase(
									"Ressource",
									$request->getParameter("rid"),
									sfContext::getInstance()->getUser()->getId(),
									"ressource"
					);

					$contents = array("errors" => array(), "method" => "remove", "id" => "ressource-" . $request->getParameter("rid"), "message" => sfContext::getInstance()->getI18n()->__("La ressource a bien été supprimée"), "status" => 200);
				}
				else
				{
					$contents = array("errors" => array(), "message" => sfContext::getInstance()->getI18n()->__("La ressource n'a pas pu être supprimée"), "status" => 200);
				}

				$this->setJsonContents($contents);
			}
			else
			{
				$this->isJsonable(false);
			}
		}
		else
		{
			exit;
		}
	}

	public function executeAdd(sfWebRequest $request)
	{
		// Continue
		if($request->getParameter("rid"))
		{
			RessourceACL::init($request->getParameter("rid"), "write", true);

			$ressource = Doctrine::getTable("Ressource")->find($request->getParameter("rid"));
			$this->form = new RessourceFrontendForm($ressource);
			$this->form->edition();
		}
		else
		{
			// ACL
			ACLRules::auto("publish", true);

			$this->form = new RessourceFrontendForm();
		}

		if(($request->isMethod("PUT") || $request->isMethod("POST")) && $this->form->isCSRFProtected())
		{
			$this->form->bind(
				$request->getParameter($this->form->getName()),
				$request->getFiles($this->form->getName())
			);

			if($this->form->isValid())
			{
				// Set ACL here (fin)
				if($isnew = $this->form->getObject()->isNew())
				{
					if($request->getParameter("pid"))
						$this->form->getObject()->setProjetId($request->getParameter("pid"));

					if($request->getParameter("gid"))
						$this->form->getObject()->setGroupeId($request->getParameter("gid"));

					if($request->getParameter("eid"))
						$this->form->getObject()->setEventId($request->getParameter("eid"));

					$this->form->getObject()->setCreateurId($this->getUser()->getId());
				}

				$this->form->save();

				$item = Doctrine_Query::create()->from("Ressource r")->leftJoin("r.Profil p")->leftJoin("r.Theme t")->where("id=?", $this->form->getObject()->getId())->fetchOne(array(), "profile_light");
				$contents = array("errors" => array(), "message" => $isnew ? sfContext::getInstance()->getI18n()->__("La ressource a bien été ajoutée") : sfContext::getInstance()->getI18n()->__("La ressource a bien été modifiée"), "status" => 200, "id" => "ressource-" . $item["extraData"]["id"], "view" => base64_encode($this->getPartial("render", array("identifier" => "edit-pass", "id" => "edit", "item" => $item))), "method" => ($isnew ? "prepend" : "replace"));
			}
			else
			{
				$contents = array("errors" => sfActionsJson::getSfErrors($this->form), "status" => 500);
			}

			$this->setJsonContents($contents);
		}
		else
		{
			$this->isJsonable(false);
		}
	}
}
