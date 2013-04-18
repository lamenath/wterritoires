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

class ideasActions extends sfActionsJson
{
	public function executeRemove(sfWebRequest $request)
	{
		// Continue
		if($request->getParameter("iid"))
		{
			IdeaACL::init($request->getParameter("iid"), "admin", true);

			if(($request->isMethod("PUT") || $request->isMethod("POST")))
			{
				$idea = Doctrine::getTable("ProjetIdee")->find($request->getParameter("iid"));

				if($idea)
				{
					$idea->delete();

					//
					Story::erase(
									"ProjetIdee",
									$request->getParameter("iid"),
									sfContext::getInstance()->getUser()->getId(),
									"idea"
					);

					$contents = array("errors" => array(), "method" => "remove", "id" => md5($request->getParameter("iid")), "message" => sfContext::getInstance()->getI18n()->__("La discussion a bien été supprimée"), "status" => 200);
				}
				else
				{
					$contents = array("errors" => array(), "message" => sfContext::getInstance()->getI18n()->__("La discussion n'a pas pu être supprimée"), "status" => 200);
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
		if($request->getParameter("iid"))
		{
			// ACL
			IdeaACL::init($request->getParameter("iid"), "publish", true);

			$idea = Doctrine::getTable("ProjetIdee")->find($request->getParameter("iid"));
			$this->form = new ProjetIdeeFrontendForm($idea);
		}
		else
		{
			// ACL
			ACLRules::auto("publish", true);

			$this->form = new ProjetIdeeFrontendForm();
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

					$this->form->getObject()->setProfilId($this->getUser()->getId());
				}

				$this->form->save();

				$item = Doctrine_Query::create()->from("ProjetIdee r")->leftJoin("r.Profil p")->where("id=?", $this->form->getObject()->getId())->fetchOne(array(), "idea");
				$contents = array("errors" => array(), "id" => md5($this->form->getObject()->getId()), "message" => ($isnew ? sfContext::getInstance()->getI18n()->__("La discussion a bien été ajoutée") : sfContext::getInstance()->getI18n()->__("La discussion a bien été modifiée")), "status" => 200, "view" => base64_encode($this->getPartial("render", array("identifier" => "edit-pass", "id" => $this->form->getObject()->getId(), "item" => $item))), "method" => ($isnew ? "prepend" : "replace"));
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
