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

class profileActions extends sfActionsJson
{
	public $bypass = array("index");
	
	public function executeIndex(sfWebRequest $request)
	{
		$this->user = Doctrine_Query::create()
										->from("Profil p")
										->where("p.slug=?", $request->getParameter("slug"))
										->leftJoin("p.Filiere f")
										->leftJoin("p.Theme t")
										->leftJoin("p.Structure s")
										->fetchOne(array(), "profile");

		if(!$this->user)
		{
			$this->redirect404();
		}
		else
		{
			$this->getResponse()->addMeta("description",$this->user["presentation"]);
			$this->getResponse()->setTitle( $this->user["full_name"] . " | " . sfConfig::get("app_title_page"));
		}
	}

	public function executeMembers(sfWebRequest $request)
	{
		$profiles = Doctrine_Query::create()
											->from("Profil r")
											->leftJoin("r.Theme th")
											->leftJoin("r.Filiere fi")
											->leftJoin("r.Competence c")
											->leftJoin("r.Metier m");

		if($term = $request->getParameter("search"))
		{
			$profiles->andWhere("(r.presentation LIKE ? OR r.ville LIKE ? OR m.nom LIKE ? OR th.nom LIKE ? OR fi.nom LIKE ? OR c.nom LIKE ? OR CONCAT(TRIM(r.nom), ' ', TRIM(r.prenom)) LIKE ? OR CONCAT(TRIM(r.prenom), ' ', TRIM(r.nom)) LIKE ?)", array("%".$term."%","%".$term."%","%".$term."%","%".$term."%","%".$term."%","%".$term."%","%".$term."%","%".$term."%"));
		}

		RRR::pager($profiles, "Profil", 10);
	}

	public function executeEdit(sfWebRequest $request)
	{
		$profile = Doctrine::getTable("Profil")->find($this->getUser()->getId());

		switch($request->getParameter("proute"))
		{
			case "general":
				$url = $this->getController()->genUrl("@profileedit?proute=relations&account_created=true");
				$this->form = new ProfilFrontendIdentifiedForm($profile);
			break;
			case "privacy":
				$url = $this->getController()->genUrl("@public_profile?slug=".$this->getUser()->getObject()->getSlug());
				$this->form = new ProfilFrontendPrivacyIdentifiedForm($profile);
				RRR::$hod = sfContext::getInstance()->getI18n()->__("Dernière étape, gérez vos paramètres de confidentialité et vos notifications e-mail");
			break;
			case "relations":
				$url = $this->getController()->genUrl("@profileedit?proute=structures&account_created=true");
				$this->form = new ProfilFrontendRelationsIdentifiedForm($profile);
				RRR::$hod = sfContext::getInstance()->getI18n()->__("Renseignez maintenant vos intérêts. Ils permettront de faciliter vos connexions avec les acteurs et projets du territoire.");
			break;
			case "structures":
				$url = $this->getController()->genUrl("@profileedit?proute=privacy&account_created=true");
				$this->form = new ProfilFrontendStructuresIdentifiedForm($profile);
				RRR::$hod = sfContext::getInstance()->getI18n()->__("Renseignez les structures (association, institution, collectivité, entreprise) pour lesquelles vous travaillez. Vous aurez ensuite la possibilité d'éditer les fiches de vos structures");
			break;
			default:
				die('Not a valid action');
			break;
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

				if($request->getParameter("scenario") && isset($url))
				{
					$contents = array("test" => $request->getUri(), "url" => $url, "errors" => array(), "status" => 200, "method" => "goto", "message" => sfContext::getInstance()->getI18N()->__("Votre profil a bien été mis à jour !"));
				}
				else
				{
					$contents = array("errors" => array(), "status" => 200, "method" => "display", "message" => sfContext::getInstance()->getI18N()->__("Votre profil a bien été mis à jour !"), "url" => $request->getUri());
				}
			}
			else
			{
				$contents = array("errors" => sfActionsJson::getSfErrors($this->form), "status" => 500, "method" => "display");
			}

			$this->setJsonContents($contents);
		}
		else
		{
			$this->isJsonable(false);
		}
	}
}
