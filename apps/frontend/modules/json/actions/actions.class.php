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

class jsonActions extends sfActionsJson
{
	public $admitted = array("theme", "filiere", "metier", "competence");

	public function executeFiliere(sfWebRequest $request)
	{
		if(!$request->isMethod("post"))
		{
			$query = Doctrine_Query::create()
				->from("Filiere")
				->where("nom LIKE ?", "%".$request->getParameter("term")."%");

			$this->renderJson($query, $request, false);
		}
	}

	public function executeCm(sfWebRequest $request)
	{
		if(!$this->getUser()->getObject()->getIsAdmin())
			die('Ooops');

		$counts = Doctrine_Query::create()
								->from("Profil p")
								->leftJoin("p.ProfilFiliere f")
								->whereIn("f.filiere_id", $request->getParameter("filter"))
								->count();

		$this->setJsonContents(array("label" => $counts . " personnes"));
	}

	public function executeTendance(sfWebRequest $request)
	{
		//
		$table = ucfirst($request->getParameter("type"));
		$table_m = mb_strtolower($request->getParameter("type"), "UTF-8");

		if(!in_array($table_m, $this->admitted))
			$this->redirect404();

		if(!in_array($request->getParameter("sortorder"), array("", "desc", "asc", "DESC", "ASC")))
			exit;

		if(!in_array($request->getParameter("sortname"), array("nom", "user", "structure", "project", "event", "ressource")))
			exit;

		// Query
		$result = Doctrine_Query::create()
			->select("f.id, f.slug, f.nom, (SELECT Count(*) FROM Projet".$table." A WHERE A.".$table_m."_id=f.id) as project, (SELECT Count(*) FROM Profil".$table." B WHERE B.".$table_m."_id=f.id) as user, (SELECT Count(*) FROM Structure".$table." C WHERE C.".$table_m."_id=f.id) as structure, (SELECT Count(*) FROM Event".$table." D WHERE D.".$table_m."_id=f.id) as event" . ($table == "Filiere" || $table == "Theme" ? ", (SELECT Count(*) FROM Ressource".$table." E WHERE E.".$table_m."_id=f.id) as ressource" : ", \"NC\" AS ressource"))
			->from($table." f");

		if($n = $request->getParameter("sortname"))
		{
			$result->orderBy($n . " " . $request->getParameter("sortorder"));
		}

		// Execute query
		$result = $result->useResultCache(true, 6000)->execute(array(), Doctrine::HYDRATE_ARRAY);

		foreach($result as &$r)
		{
			$slug = $r["slug"];
			unset($r["slug"]);
			$r["id"] = $r["id"];
			$r["cell"] = $r;
			$r["cell"]["nom"] = "<a target='_blank' href='".$this->getController()->genUrl("@directory_act?proute=map&type=".$table_m."&slug=".$slug)."'>".$r["cell"]["nom"] . "</a>";
		}

		if($request->getParameter("format") == "csv")
		{
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: private");
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=export-".$table_m.".csv");
			header("Accept-Ranges: bytes");
			
			echo RRR::to_csv($result); 
			exit;
		}


		$result = array("page" => 1, "total" => 10, "rows" => $result);

		$this->setJsonContents($result, true);
	}

	public function executeFeed(sfWebRequest $request)
	{
		$result = array();
		$latitude = $request->getParameter("lat");
		$longitude = $request->getParameter("lng");

		// Profils proches
		if($term = $request->getParameter("keyword"))
		{
			$this->profil_proches = Doctrine_Query::create()
			->select("p.*")
			->from("Profil p")
			->leftJoin("p.Filiere f")
			->leftJoin("p.Theme t")
			->leftJoin("p.Competence c")
			->leftJoin("p.Metier m")
			->where("500 > (6366*acos(cos(radians(?))*cos(radians(`latitude`))*cos(radians(`longitude`) -radians(?))+sin(radians(?))*sin(radians(`latitude`))))", array($latitude, $longitude, $latitude))
			->andWhere("f.nom LIKE ? OR t.nom LIKE ? OR c.nom LIKE ? OR m.nom LIKE ?", array("%".$term."%","%".$term."%","%".$term."%","%".$term."%"))
			->limit(40)
			->execute(array(), "profile_light");
		}
		else
		{
			$this->profil_proches = Doctrine_Query::create()
			->from("Profil p")
			->where("100 > (6366*acos(cos(radians(?))*cos(radians(`latitude`))*cos(radians(`longitude`) -radians(?))+sin(radians(?))*sin(radians(`latitude`))))", array($latitude, $longitude, $latitude))
			->limit(100)
			->useResultCache(true, 5000)
			->execute(array(), "profile_light");
		}

		foreach($this->profil_proches as $p)
		{
			$result[] = array("id" => md5("project_".$p["id"]), "type" => "user", "url" => $p["url"], "city" => $p["ville"], "title" => $p["full_name"], "picture" => $p["photo_mini"], "bio" => $p["presentation"], "lat" =>  $p["latitude"], "lon" => $p["longitude"]);
		}

		// Projets proches
		if($term = $request->getParameter("keyword"))
		{
			$this->projects = Doctrine_Query::create()
			->select("p.*, commune.*")
			->from("Projet p")
			->leftJoin("p.Filiere f")
			->leftJoin("p.Theme t")
			->leftJoin("p.Competence c")
			->leftJoin("p.Metier m")
			->leftJoin("p.Commune commune")
			->where("500 > (6366*acos(cos(radians(?))*cos(radians(`latitude`))*cos(radians(`longitude`) -radians(?))+sin(radians(?))*sin(radians(`latitude`))))", array($latitude, $longitude, $latitude))
			->andWhere("f.nom LIKE ? OR t.nom LIKE ? OR c.nom LIKE ? OR m.nom LIKE ?", array("%".$term."%","%".$term."%","%".$term."%","%".$term."%"))
			->limit(40)
			->execute(array(), "project_light");
		}
		else
		{
			$this->projects = Doctrine_Query::create()
			->from("Projet p")
			->leftJoin("p.Commune commune")
			->where("100 > (6366*acos(cos(radians(?))*cos(radians(`latitude`))*cos(radians(`longitude`) -radians(?))+sin(radians(?))*sin(radians(`latitude`))))", array($latitude, $longitude, $latitude))
			->useResultCache(true, 5000)
			->limit(100)
			->execute(array(), "project_light");
		}

		foreach($this->projects as $p)
		{
			$result[] = array("id" => md5("project_".$p["id"]), "type" => "project", "url" => $p["url"], "city" => $p["Commune"]["nom"], "title" => $p["nom"], "picture" => $p["photo_mini"], "bio" => $p["objectifs_qualitatif"], "lat" =>  $p["Commune"]["latitude"], "lon" => $p["Commune"]["longitude"]);
		}

		// Structures proches
		if($term = $request->getParameter("keyword"))
		{
			$this->events = Doctrine_Query::create()
			->select("p.*")
			->from("Structure p")
			->leftJoin("p.Filiere f")
			->leftJoin("p.Theme t")
			->leftJoin("p.Competence c")
			->leftJoin("p.Metier m")
			->where("500 > (6366*acos(cos(radians(?))*cos(radians(`latitude`))*cos(radians(`longitude`) -radians(?))+sin(radians(?))*sin(radians(`latitude`))))", array($latitude, $longitude, $latitude))
			->andWhere("f.nom LIKE ? OR t.nom LIKE ? OR c.nom LIKE ? OR m.nom LIKE ?", array("%".$term."%","%".$term."%","%".$term."%","%".$term."%"))
			->limit(40)
			->execute(array(), "structure");
			foreach($this->events as $p)
			{
				$result[] = array("id" => md5("structure_".$p["id"]), "type" => "structure", "url" => $p["url"], "city" => $p["ville"], "title" => $p["nom"], "picture" => $p["photo_mini"], "bio" => $p["presentation"], "lat" =>  $p["latitude"], "lon" => $p["longitude"]);
			}
		}

		$this->setJsonContents($result, true);
	}

	public function executeWish_confirm(sfWebRequest $request)
	{
		$this->wish = Doctrine_Query::create()
					->from('WishInvitation w')
					->leftJoin("w.Profil ppn")
					->where("w.projet_id IN (SELECT p1.projet_id FROM ProfilProjet p1 LEFT JOIN p1.Projet p2 ON p1.projet_id = p2.id WHERE p1.profil_id=? AND p1.role='referent')", $this->getUser()->getId())
					->andWhere("w.id=?", $request->getParameter("wid"))
					->andWhere("w.hidden = 0")
					->fetchOne();

		if(!$this->wish)
		{
			$this->setJsonContents(array("message" => sfContext::getInstance()->getI18n()->__("Vous n'avez pas accès à cela !"), "method" => "display", "status" => 200));
		}
		else
		{
			// Go !
			//$this->wish->setHidden(1);
			$this->wish->save();

			if($request->getParameter("choice") == "1")
			{
				$this->setJsonContents(array("message" => sfContext::getInstance()->getI18n()->__("La demande a été ignorée !"), "method" => "remove", "id" => "wish_" . $request->getParameter("wid"), "status" => 200));
			}
			else
			{
				// On Rajoute la personne s'il le faut
				if(!$this->getUser()->isInProjet($this->wish->getProjetId(), $this->wish->getProfilId()))
				{
					$relation = new ProfilProjet();
					$relation->setProfilId( $this->wish->getProfilId() );
					$relation->setProjetId( $this->wish->getProjetId() );
					$relation->setRole( "contributeur" );
					$relation->setDate( new Doctrine_Expression("NOW()"));
					$relation->save();

					// Send Notification
					$gurl = sfContext::getInstance()->getController()->genUrl("@project?slug=".$this->wish->getProjet()->getSlug(), true);
					rMail::create($this->wish->getProfilId(), "", "wisha", array("gurl" => $gurl, "gname" => $this->wish->getProjet()->getNom()), true)
					->send();
				}

				$this->setJsonContents(array("message" => sfContext::getInstance()->getI18n()->__("La demande a été acceptée !"), "method" => "remove", "id" => "wish_" . $request->getParameter("wid"), "status" => 200));
			}
		}
	}

	public function executeAdmin_project(sfWebRequest $request)
	{
		ProjectACL::init($request->getParameter("pid"), "admin", true);

		Doctrine_Query::create()
		->delete("ProfilProjet p")
		->where("p.profil_id=?", $request->getParameter("uid"))
		->andWhere("p.projet_id=?", $request->getParameter("pid"))
		->execute();

		// Remove story (preDelete listener doesnt work)
		Story::erase(
						"Projet",
		$request->getParameter("pid"),
		$request->getParameter("uid"),
						"contribute"
						);

						if($request->getParameter("direction") == "kick")
						{

						}
						else
						{
							$pp = new ProfilProjet();
							$pp->setProfilId($request->getParameter("uid"));
							$pp->setProjetId($request->getParameter("pid"));

							if($request->getParameter("direction") == "referent")
							$pp->setRole("referent");
							if($request->getParameter("direction") == "notreferent")
							$pp->setRole("contributeur");

							$pp->setDate(date("Y-m-d H:i:s"));
							$pp->save();
						}

						$this->setJsonContents(parent::$SUCCESS_RELOAD);
	}

	public function executeAdmin_structure(sfWebRequest $request)
	{
		StructureACL::init($request->getParameter("pid"), "admin", true);

		Doctrine_Query::create()
					->delete("ProfilStructure p")
					->where("p.profil_id=?", $request->getParameter("uid"))
					->andWhere("p.structure_id=?", $request->getParameter("pid"))
					->execute();

		if($request->getParameter("direction") == "kick")
		{

		}
		else
		{
			$pp = new ProfilStructure();
			$pp->setProfilId($request->getParameter("uid"));
			$pp->setStructureId($request->getParameter("pid"));

			if($request->getParameter("direction") == "referent")
			$pp->setRole("admin");
			if($request->getParameter("direction") == "notreferent")
			$pp->setRole("member");

			$pp->save();
		}

		$this->setJsonContents(parent::$SUCCESS_RELOAD);
	}

	public function executeJoin_event(sfWebRequest $request)
	{
		EventACL::init($request->getParameter("eid"), "read", true);

		$test = Doctrine_Query::create()
		->from("EventInvite e")
		->where("event_id=?", $request->getParameter("eid"))
		->andWhere("profil_id=?", $this->getUser()->getId())
		->fetchOne();

		if(!$test)
		{
			if(Doctrine::getTable("Event")->find($request->getParameter("eid"))->getVisibilite() == "private")
			{
				$this->setJsonContents(parent::$ERROR_RELOAD);
				return false;
			}

			$test = new EventInvite();
			$test->setProfilId($this->getUser()->getId());
			$test->setEventId($request->getParameter("eid"));
		}

		if($request->getParameter("direction") == "join")
		$test->setEtat("yes");
		else
		$test->setEtat("no");

		$test->save();

		// If invitation exists, we hide it
		$test2 = Doctrine_Query::create()
		->from("Invitation e")
		->where("event_id=?", $request->getParameter("eid"))
		->andWhere("profil_id=?", $this->getUser()->getId())
		->fetchOne();

		if($test2)
		{
			$test2->setHidden(1);
			$test2->save();
		}

		$this->setJsonContents(parent::$SUCCESS_RELOAD);
	}

	public function executeAdd_contact(sfWebRequest $request)
	{
		$s = false;
		$relation = $this->getUser()->isFriendWith($request->getParameter("uid"));

		switch($request->getParameter("direction"))
		{
			case "add":

				if(!$relation)
				{
					// Create new friend request
					$contact = new ProfilProfil();
					$contact->setContactId($request->getParameter("uid"));
					$contact->setProfilId($this->getUser()->getId());
					$contact->setIsActivated(0);
					$contact->save();

					// Send Mail to Invited
					rMail::create($request->getParameter("uid"), null, "frequest", array("direction" => "notify"))->send();

					$s=true;
				}

				break;
			case "remove":

				if($relation && $relation->get("is_activated") != -1)
				{
					// Create new friend request
					Doctrine_Query::create()
					->delete("ProfilProfil")
					->where("(contact_id=?", $request->getParameter("uid"))
					->andWhere("profil_id=?)", $this->getUser()->getId())
					->orWhere("(contact_id=?", $this->getUser()->getId())
					->andWhere("profil_id=?)", $request->getParameter("uid"))
					->execute();

					// Remove associated stories
					Story::erase("Profil", $request->getParameter("uid"), $this->getUser()->getId(), "friends");
					Story::erase("Profil", $this->getUser()->getId(), $request->getParameter("uid"), "friends");

					$s=true;

					// Display
					if($request->getParameter("rmv") == 1)
					{
						$this->setJsonContents(array("message" => sfContext::getInstance()->getI18n()->__("Le contact a bien été supprimé !"), "method" => "remove", "id" => "contact_" . $request->getParameter("uid"), "status" => 200));
						return false;
					}
				}

				break;
			case "confirm":

				$relation = $this->getUser()->hasPendingRequest($request->getParameter("uid"));
				$activation = ($request->getParameter("frequest_choice") != -1 ? 1 : -1);

				if($relation !== false)
				{
					// Confirm my relation
					$relation->setIsActivated($activation);
					$relation->save();

					// Create new friend request
					$contact = new ProfilProfil();
					$contact->setContactId($request->getParameter("uid"));
					$contact->setProfilId($this->getUser()->getId());
					$contact->set("is_activated", $activation);
					$contact->save();
					$contact->postUpdate("");

					// Send Mail to inviter
					rMail::create($request->getParameter("uid"), null, "frequest", array("direction" => "accept"))->send();

					$s=true;
				}

				break;
		}

		if($s === true)
		$this->setJsonContents(parent::$SUCCESS_RELOAD);
		else
		$this->setJsonContents(parent::$$ERROR_RELOAD);
	}

	public function executeJoin_project(sfWebRequest $request)
	{
		ProjectACL::init($request->getParameter("pid"), "read", true);

		if($request->getParameter("pid") && $request->getParameter("role") && !$this->getUser()->isInProjet($request->getParameter("pid")) && $request->getParameter('type') == "join" && trim($request->getParameter('role')) != "referent")
		{
			$pp = new ProfilProjet();
			$pp->setProfilId($this->getUser()->getId());
			$pp->setProjetId($request->getParameter("pid"));
			$pp->setRole($request->getParameter('role'));
			$pp->setDate(date("Y-m-d H:i:s"));
			$pp->save();

			// If invitation exists, we hide it
			$test2 = Doctrine_Query::create()
			->from("Invitation e")
			->where("projet_id=?", $request->getParameter("pid"))
			->andWhere("profil_id=?", $this->getUser()->getId())
			->fetchOne();

			if($test2)
			{
				$test2->setHidden(1);
				$test2->save();
			}

			$this->setJsonContents(parent::$SUCCESS_RELOAD);
		}
		elseif($request->getParameter("pid") && $this->getUser()->isInProjet($request->getParameter("pid")) && $request->getParameter('type') == "part")
		{
			Doctrine_Query::create()
			->delete("ProfilProjet p")
			->where("p.profil_id=?", $this->getUser()->getId())
			->andWhere("p.projet_id=?", $request->getParameter("pid"))
			->execute();

			// Remove story (preDelete listener doesnt work)
			Story::erase(
							"Projet",
			$request->getParameter("pid"),
			sfContext::getInstance()->getUser()->getId(),
							"contribute"
							);

							$this->setJsonContents(parent::$SUCCESS_RELOAD);
		}
		else
		{
			$this->setJsonContents(parent::$SUCCESS_RELOAD);
		}
	}

	public function executeCommune(sfWebRequest $request)
	{
		$query = Doctrine_Query::create()->from("Commune")
		->where("nom like ?", "%" . $request->getParameter("term") . "%")
		->orWhere("code_postal like ?", "%" . $request->getParameter("term") . "%")
		->orWhere("REPLACE(nom, '-', ' ') like ?", "%" . $request->getParameter("term") . "%")
		->orWhere("REPLACE(nom, '-', ' ') like ?", "%" . preg_replace("/st /ui", "saint ", $request->getParameter("term")) . "%")
		->orWhere("REPLACE(nom, '-', ' ') like ?", "%" . preg_replace("/ st /ui", " saint ", $request->getParameter("term")). "%")
		->orWhere("REPLACE(nom, '-', ' ') like ?", "%" . preg_replace("/ saint /ui", " st ", $request->getParameter("term")) . "%");

		$this->renderJson($query,$request, false);
	}

	public function executeCompetence(sfWebRequest $request)
	{
		if($request->isMethod("post"))
		{
			$f = new Competence();
			$f->setNom( trim($request->getParameter("term")) );
			$f->save();

			$this->renderCreated($f->getId(), $f->getNom());
		}
		else
		{
			$query = Doctrine_Query::create()
			->from("Competence")
			->where("nom LIKE ?", "%".$request->getParameter("term")."%");

			$this->renderJson($query,$request);
		}
	}

	public function executeStructure(sfWebRequest $request)
	{
		if($request->isMethod("post"))
		{
			$f = new Structure();
			$f->setNom( trim($request->getParameter("term")) );
			$f->setCreateurId( $this->getUser()->getId() );
			$f->save();

			$this->renderCreated($f->getId(), $f->getNom());
		}
		else
		{
			$query = Doctrine_Query::create()
			->from("Structure")
			->where("nom LIKE ?", "%".$request->getParameter("term")."%");

			$this->renderJson($query,$request);
		}
	}

	public function executeProfil(sfWebRequest $request)
	{
		if($request->getParameter("eid"))
		{
			EventACL::init($request->getParameter("eid"), "admin", true);

			$query = Doctrine_Query::create()
			->from("EventInvite e")
			->leftJoin("e.Profil p")
			->where("e.event_id=?", $request->getParameter("eid"))
			->andWhere("(p.nom LIKE ?", "%".$request->getParameter("term")."%")
			->orWhere("p.prenom LIKE ?", "%".$request->getParameter("term")."%")
			->orWhere("CONCAT(TRIM(p.prenom), \" \", TRIM(p.nom)) LIKE ?", "%".$request->getParameter("term")."%")
			->orWhere("CONCAT(TRIM(p.nom), \" \", TRIM(p.prenom)) LIKE ?)", "%".$request->getParameter("term")."%");

			$this->renderJson($query,$request, false, "Profil");
		}
	}

	public function executeProjet(sfWebRequest $request)
	{
		$query = Doctrine_Query::create()
		->from("Projet")
		->where("nom LIKE ?", "%".$request->getParameter("term")."%");

		$this->renderJson($query,$request, false);
	}

	public function executeMetier(sfWebRequest $request)
	{
		if($request->isMethod("post"))
		{
			$f = new Metier();
			$f->setNom( trim($request->getParameter("term")) );
			$f->save();

			$this->renderCreated($f->getId(), $f->getNom());
		}
		else
		{
			$query = Doctrine_Query::create()
			->from("Metier")
			->where("nom LIKE ?", "%".$request->getParameter("term")."%");

			$this->renderJson($query,$request);
		}
	}

	public function executeSegment(sfWebRequest $request)
	{
		$query = Doctrine_Query::create()
		->from("Segment")
		->where("nom LIKE ?", "%".$request->getParameter("term")."%");

		$this->renderJson($query,$request);
	}

	public function executeTheme(sfWebRequest $request)
	{
		if($request->isMethod("post"))
		{
			$f = new Theme();
			$f->setNom( trim($request->getParameter("term")) );
			$f->save();

			$this->renderCreated($f->getId(), $f->getNom());
		}
		else
		{
			$query = Doctrine_Query::create()
			->from("Theme")
			->where("nom LIKE ?", "%".$request->getParameter("term")."%");

			$this->renderJson($query,$request);
		}
	}

	/* 
	 * Common Json Funcs 
	 */
	public function renderCreated($id, $name)
	{
		$this->setJsonContents(array("id" => $id, "label" => $name, "value" => $name));
	}

	public function renderJson($results, $request, $suggest=true, $class=false)
	{
		$results = $results->limit(10)->execute(array(), Doctrine::HYDRATE_ARRAY);
		$data = array();

		foreach($results as $line)
		{
			if($class !== false)
			$line = $line[$class];

			$data[] = array("id" => $line["id"], "label" => (isset($line["prenom"]) ? $line["prenom"] . " " : "") . $line["nom"], "value" => $line["nom"]);
		}

		if($suggest === true)
			$data[] = array("id" => "create-it", "label" => "Ajouter <b>\"" . $request->getParameter("term") . "\"</b>", "value" => $request->getParameter("term"));

		$this->setJsonContents($data);
	}
}
