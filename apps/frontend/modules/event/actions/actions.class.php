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

class eventActions extends sfActionsJson
{
	public $bypass = array("all", "index");

	public function executeRemove(sfWebRequest $request)
	{
		if($request->getParameter("id"))
		{
			EventACL::init($request->getParameter("id"), "admin", true);
			$event = Doctrine::getTable("Event")->find($request->getParameter("id"));
			$event->delete();
			$this->redirect("/events/mine?removed=true");
		}
	}

	public function executeEdit(sfWebRequest $request)
	{
		if($request->getParameter("id"))
		{
			// ACL
			EventACL::init($request->getParameter("id"), "write", true);
			$this->acl = ACLRules::$saved_acl;

			$project = Doctrine::getTable("Event")->find($request->getParameter("id"));
			$this->form = new EventFrontendForm($project);
		}
		else
		{
			$this->form = new EventFrontendForm();
		}

		if(($request->isMethod("PUT") || $request->isMethod("POST")) && $this->form->isCSRFProtected())
		{
			$this->form->bind(
				$request->getParameter($this->form->getName()),
				$request->getFiles($this->form->getName())
			);

			if($this->form->isValid())
			{
				$this->form->save();

				$contents = array("errors" => array(), "status" => 200, "method" => "goto", "url" => $this->getController()->genUrl("@event?edit=1&slug=".$this->form->getObject()->getSlug()));
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

	public function executeAll(sfWebRequest $request)
	{
		$events = Doctrine_Query::create()
											->from("Event p")
											->leftJoin("p.Competence co")
											->leftJoin("p.Filiere fi")
											->leftJoin("p.Theme th")
											->leftJoin("p.Metier me")
											->orderBy("p.created_at DESC");

		switch($request->getParameter("proute"))
		{
			case "all":
				$this->moduleRoute = "event";
				$this->proute = "list";
				$events = $events->where("p.visibilite=?", "public");
				break;
			case "mine":
				$this->moduleRoute = "event";
				$this->proute = "list";
				$events = Doctrine_Query::create()
											->from("EventInvite r")
											->leftJoin("r.Event p")
											->leftJoin("p.Competence c")
											->where("r.profil_id=?", $this->getUser()->getId())
											->orderBy("r.created_at DESC");
				break;
			default:
				$this->proute = "list";
			break;
		}

		// Search
		if($term = $request->getParameter("search"))
		{
			$events->andWhere("(p.titre LIKE ? OR p.ville LIKE ? OR th.nom LIKE ? OR fi.nom LIKE ? OR me.nom LIKE ? OR co.nom LIKE ?)", array("%".$term."%","%".$term."%","%".$term."%","%".$term."%","%".$term."%","%".$term."%"));
		}

		list($this->pager, $this->total) = RRR::pager($events, "Event", 10);
	}

	public function executeIndex(sfWebRequest $request)
	{
		$this->event = Doctrine_Query::create()
										->from("Event p")
										->leftJoin("p.Filiere f")
										->leftJoin("p.Theme t")
										->where("p.slug=?", $request->getParameter("slug"))
										->fetchOne(array(), "event");

		if(!$this->event)
		{
			$this->redirect404();
		}
		else
		{
			$this->getResponse()->addMeta("description",$this->event["description"]);
			$this->getResponse()->setTitle( $this->event["titre"] . " | " . sfConfig::get("app_title_page"));
		}

		switch($request->getParameter("proute"))
		{
			case "ressources":
				$this->moduleRoute = "ressource";
				$this->proute = "index";
				break;

			case "presentation":
				$this->proute = "presentation";
				break;
			case "ideas":
				$this->moduleRoute = "ideas";
				$this->proute = "index";
				break;
			case "guests":
				$this->proute = "guests";
			break;
			default:
				$this->moduleRoute = "story";
				$this->proute = "extract";
			break;
		}
	}
}
