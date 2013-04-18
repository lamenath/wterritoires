<?php

/**
 * structure actions.
 *
 * @package    rrr
 * @subpackage structure
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class structureActions extends sfActionsJson
{
	public $bypass = array("remove_contact", "index", "contacts", "members");
	
	public function executeIndex(sfWebRequest $request)
	{
		$this->structure = Doctrine_Query::create()
										->from("Structure p")
										->leftJoin("p.Profil u")
										->leftJoin("p.Competence")
										->leftJoin("p.Filiere")
										->leftJoin("p.Theme t")
										->leftJoin("p.Metier m")
										->leftJoin("p.ProfilStructure pp")
										->leftJoin("pp.Profil")
										->leftJoin("p.StructureContact sc")
										->where("p.slug=?", $request->getParameter("slug"))
										->fetchOne(array(), "structure");

		if(!$this->structure)
			$this->redirect404();
		else
			$this->getResponse()->setTitle( $this->structure["nom"] . " | " . sfConfig::get("app_title_page"));
	}
	
	public function executeContacts(sfWebRequest $request)
	{
		$this->executeIndex($request);
		
		// Members
		$members = Doctrine_Query::create()
								->from("StructureContact p")
								->leftJoin("p.Structure s")
								->where("p.structure_id=?", $this->structure["id"])
								->orderBy("p.created_at DESC");

		list($this->pager, $this->total) = RRR::pager($members, "StructureContact", 10);
	}
	
	public function executeMembers(sfWebRequest $request)
	{
		$this->executeIndex($request);
		
		// Members
		$members = Doctrine_Query::create()
								->from("ProfilStructure p")
								->leftJoin("p.Profil c")
								->where("p.structure_id=?", $this->structure["id"])
								->orderBy("p.created_at DESC");

		if($term = $request->getParameter("search"))
			$members->andWhere("(CONCAT(TRIM(c.nom), ' ', TRIM(c.prenom)) LIKE ? OR CONCAT(TRIM(c.prenom), ' ', TRIM(c.nom)) LIKE ?)", array("%".$term."%","%".$term."%"));

		list($this->pager, $this->total) = RRR::pager($members, "Profil", 10);
	}
	
	public function executeRemove(sfWebRequest $request)
	{
		if($request->getParameter("id"))
		{
			StructureACL::init($request->getParameter("id"), "admin", true);
			$st = Doctrine::getTable("Structure")->find($request->getParameter("id"));
			$st->delete();
			
			$this->redirect("/home/structures?removed=true");
		}
	}
	
	public function executeEdit(sfWebRequest $request)
	{
		if($request->getParameter("id"))
		{
			StructureACL::init($request->getParameter("id"), "write", true);
			$this->acl = ACLRules::$saved_acl;
			$structure = Doctrine::getTable("Structure")->find($request->getParameter("id"));
			$this->form = new StructureFrontendForm($structure);
		}
		else
		{
			$this->form = new StructureFrontendForm();
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

				$contents = array("errors" => array(), "status" => 200, "method" => "goto", "url" => $this->getController()->genUrl("@structure2?edit=1&slug=".$this->form->getObject()->getSlug()));
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

	public function executeRemove_contact(sfWebRequest $request)
	{
		if($request->getParameter("id"))
		{
			$st = Doctrine::getTable("StructureContact")->find($request->getParameter("id"));
			$slug = $st->getStructure()->getSlug();
			
			StructureACL::init(	$st->getStructureId() , "admin", true);
			
			$st->delete();
			
			$this->redirect("@structure2c?slug=".$slug);
		}
	}

	public function executeEdit_contact(sfWebRequest $request)
	{
		$struc = Doctrine::getTable("Structure")->findOneBySlug($request->getParameter("slug"));
		
		StructureACL::init($struc->getId(), "write", true);
		$this->acl = ACLRules::$saved_acl;
			
		if($request->getParameter("id"))
		{
			$structure = Doctrine::getTable("StructureContact")->find($request->getParameter("id"));
			$this->form = new StructureContactFormFrontend($structure);
		}
		else
		{
			$this->form = new StructureContactFormFrontend();
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
					$this->form->getObject()->setStructureId($struc->getId());
				}
				
				$this->form->save();
				
				$contents = array("errors" => array(), "status" => 200, "method" => "goto", "url" => $this->getController()->genUrl("@structure2c?edit=1&slug=".$request->getParameter("slug")));
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
