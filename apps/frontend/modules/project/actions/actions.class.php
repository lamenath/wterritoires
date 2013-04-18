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

class projectActions extends sfActionsJson
{
	public $bypass = array("index", "add_photo", "all", "list", "mine", "suggestions");

	public function executeRemove(sfWebRequest $request)
	{
		if($request->getParameter("id"))
		{
			ProjectACL::init($request->getParameter("id"), "admin", true);
			$project = Doctrine::getTable("Projet")->find($request->getParameter("id"));
			$project->delete();
			$this->redirect("/projects/mine?removed=true");
		}
	}

	public function executeEdit(sfWebRequest $request)
	{
		if(!$request->hasParameter("type"))
			$request->setParameter("type", "public");

		if($request->getParameter("id"))
		{
			ProjectACL::init($request->getParameter("id"), "write", true);
			$this->acl = ACLRules::$saved_acl;
			$project = Doctrine::getTable("Projet")->find($request->getParameter("id"));
			$this->form = new ProjetFrontendForm($project);
		}
		else
		{
			$this->form = new ProjetFrontendForm();
		}

		if(($request->isMethod("PUT") || $request->isMethod("POST")) && $this->form->isCSRFProtected())
		{
			$this->form->bind(
				$request->getParameter($this->form->getName()),
				$request->getFiles($this->form->getName())
			);

			if($this->form->isValid())
			{
				if($this->form->isNew())
				{
					if($request->getParameter("type") == "public")
						$this->form->getObject()->setType("public");
					else
						$this->form->getObject()->setType("group");
				}

				$this->form->save();

				$contents = array("errors" => array(), "status" => 200, "method" => "goto", "url" => $this->getController()->genUrl("@project?edit=1&slug=".$this->form->getObject()->getSlug()));
			}
			else
			{
				$contents = array("p"=>$request->getParameter("type"),"errors" => sfActionsJson::getSfErrors($this->form), "status" => 500, "method" => "display");
			}

			$this->setJsonContents($contents);
		}
		else
		{
			$this->isJsonable(false);
		}
	}

	/* Project Profile */
	public function executeIndex(sfWebRequest $request)
	{
		$this->project = Doctrine_Query::create()
										->from("Projet p")
										->leftJoin("p.Commune c")
										->leftJoin("c.Pays x")
										->leftJoin("p.Profil u")
										->leftJoin("p.Competence")
										->leftJoin("p.Filiere")
										->leftJoin("p.Theme t")
										->where("p.slug=?", $request->getParameter("slug"))
										->fetchOne(array(), "project");

		if(!$this->project)
			$this->redirect404();
		else
			$this->getResponse()->setTitle( $this->project["nom"] . " | " . sfConfig::get("app_title_page"));

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
			case "members":
				$this->proute = "members";
			break;
			default:
				$this->proute = "extract";
				$this->moduleRoute = "story";
			break;
		}
	}

	public function executeAll(sfWebRequest $request)
	{
		$this->projects = Doctrine_Query::create()
										->from("Projet p")
										->leftJoin("p.Commune c")
										->leftJoin("c.Pays x")
										->leftJoin("p.Profil u")
										->leftJoin("p.Competence cp")
										->leftJoin("p.Filiere fi")
										->limit(12)
										->offset(0)
										->orderBy("p.created_at DESC")
										->useResultCache(true, 1000)
										->execute(array(), "project");
	}

	public function executeMine(sfWebRequest $request)
	{
		$projects = Doctrine_Query::create()
											->from("ProfilProjet r")
											->leftJoin("r.Projet p")
											->leftJoin("p.Commune c")
											->leftJoin("c.Pays x")
											->leftJoin("p.Profil u")
											->leftJoin("p.Competence co")
											->where("r.profil_id=?", $this->getUser()->getId())
											->orderBy("r.created_at DESC");

		if($term = $request->getParameter("search"))
		{
			$projects->leftJoin("p.Filiere fi")->leftJoin("p.Theme th");
			$projects->andWhere("(CONCAT(th.nom) LIKE ? OR CONCAT(fi.nom) LIKE ? OR CONCAT(x.nom) LIKE ? OR CONCAT(c.nom) LIKE ? OR CONCAT(p.nom) LIKE ? OR CONCAT(co.nom) LIKE ?)", array("%".$term."%","%".$term."%","%".$term."%","%".$term."%","%".$term."%","%".$term."%"));
		}

		list($this->pager, $this->total) = RRR::pager($projects, "Projet", 10);
		$this->setTemplate("list");
	}

	public function executeSuggestions(sfWebRequest $request)
	{
		$this->projects = Doctrine_Query::create()
										->from("Projet p")
										->leftJoin("p.Filiere f")
										->leftJoin("p.Competence c")
										->leftJoin("p.Theme t")
										->leftJoin("p.Commune com")
										->leftJoin("com.Pays x")
										->where("c.id IN (SELECT r3.competence_id FROM ProfilCompetence r3 WHERE r3.profil_id = ?) OR f.id IN (SELECT r2.filiere_id FROM ProfilFiliere r2 WHERE r2.profil_id = ?)", array($this->getUser()->getId(), $this->getUser()->getId()))
										->andWhere("p.id NOT IN (SELECT r4.projet_id FROM ProfilProjet r4 WHERE r4.profil_id = ?)", $this->getUser()->getId())
										->limit(12)
										->orderBy("RAND()")
										->useResultCache(true, 1000)
										->execute(array(), "project");

		if(!$this->projects)
		{
			$this->projects = Doctrine_Query::create()
										->from("Projet p")
										->leftJoin("p.Filiere f")
										->leftJoin("p.Competence c")
										->leftJoin("p.Theme t")
										->leftJoin("p.Commune com")
										->leftJoin("com.Pays x")
										->where("p.id NOT IN (SELECT r4.projet_id FROM ProfilProjet r4 WHERE r4.profil_id = ?)", $this->getUser()->getId())
										->limit(12)
										->orderBy("RAND()")
										->useResultCache(true, 1000)
										->execute(array(), "project");
		}

		$this->setTemplate("all");
	}

	public function executeList(sfWebRequest $request)
	{
		$projects = Doctrine_Query::create()
											->select("((SELECT Count(*) FROM ProfilProjet A1 WHERE p.id=A1.projet_id)+(SELECT Count(*) FROM Ressource A2 WHERE p.id=A2.projet_id)) as Influence, p.*, x.*, co.*, c.*")
											->from("Projet p")
											->leftJoin("p.Commune c")
											->leftJoin("c.Pays x")
											->leftJoin("p.Competence co")
											->useResultCache(true, 6000)
											->orderBy("p.created_at DESC");

		if($term = $request->getParameter("search"))
		{
			$projects->leftJoin("p.Filiere fi")->leftJoin("p.Theme th")->leftJoin("p.Metier m");
			$projects->andWhere("(th.nom LIKE ? OR m.nom LIKE ? OR fi.nom LIKE ? OR x.nom LIKE ? OR c.nom LIKE ? OR p.nom LIKE ? OR co.nom LIKE ?)", array("%".$term."%","%".$term."%","%".$term."%","%".$term."%","%".$term."%","%".$term."%","%".$term."%"));
		}

		if($request->getParameter("activity"))
			$projects->orderBy("Influence DESC");

		list($this->pager, $this->total) = RRR::pager($projects, "Projet", 10);
	}
}
