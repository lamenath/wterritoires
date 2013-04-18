<?php

/**
 * galerie actions.
 *
 * @package    rrr
 * @subpackage galerie
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class galerieActions extends sfActionsJson
{
	public $bypass = array("manager");
	
	public function executeFeed(sfWebRequest $request)
	{
		$feed = array();
		$this->getContext()->getConfiguration()->loadHelpers('Date'); 
		 
		if($request->getParameter("pid"))
		{
			ProjectACL::init($request->getParameter("pid"), "read", true);
			$this->acl = ACLRules::$saved_acl;
			
			// Fetch Photos
			$pics =  Doctrine_Query::create()
										->from("PhotoProjet p")
										->leftJoin("p.Profil")
										->where("p.projet_id=?", $request->getParameter("pid"))
										->orderBy("created_at DESC")
										->execute(array(), "profile_light");
										
			foreach($pics as $pic)
			{
				$feed[] = array("name" => $pic["extraData"]["nom"], "owner" => $pic["full_name"], "owner_url" => $pic["url"], "date" => format_date($pic["extraData"]["created_at"], "f"), "thumb" => "mini_" . $pic["extraData"]["fichier"], "min" => "std_" . $pic["extraData"]["fichier"], "max" => "max_" . $pic["extraData"]["fichier"]);
			} 
			
			$this->setJsonContents(	$feed );
		}
		else
		{
			exit;
		}
	}
	
	public function executeManager(sfWebRequest $request)
	{
		if(!($request->getParameter("pid") XOR $request->getParameter("eid")))
			exit;
		
		// Fetch Photos
		$pics =  Doctrine_Query::create()
									->from("PhotoProjet p")
									->leftJoin("p.Profil");

		if($request->getParameter("pid"))
			$pics->where("p.projet_id=?", $request->getParameter("pid"))->execute(array(), "profile_light");
			
		
	}
	
	public function executeAdd(sfWebRequest $request)
	{
		if(!($request->getParameter("pid") XOR $request->getParameter("eid") XOR $request->getParameter("gid")))
			exit;
		
		if($request->getParameter("pid"))
		{
			ProjectACL::init($request->getParameter("pid"), "write", true);
			$this->acl = ACLRules::$saved_acl;
			
			$this->form = new PhotoProjetFrontendForm();
		}
		elseif($request->getParameter("eid"))
		{
			EventACL::init($request->getParameter("eid"), "write", true);
			$this->acl = ACLRules::$saved_acl;
			
			$this->form = new PhotoProjetFrontendForm();
		}
		elseif($request->getParameter("gid"))
		{
			PhotoACL::init($request->getParameter("gid"), "write", true);
			$this->acl = ACLRules::$saved_acl;
			
			$photo = Doctrine::getTable("PhotoProjet")->find($request->getParameter("gid"));
			
			$this->form = new PhotoProjetFrontendForm($photo);
			$this->form->edition();
		}
		else
		{
			exit;
		}

		if(($request->isMethod("PUT") || $request->isMethod("POST")) && $this->form->isCSRFProtected())
		{
			$this->form->bind(
				$request->getParameter($this->form->getName()),
				$request->getFiles($this->form->getName())
			);

			if($this->form->isValid())
			{
				if($request->getParameter("pid") XOR $request->getParameter("eid") XOR $request->getParameter("gid"))
				{
					if($request->getParameter("pid"))
					{
						$id = $request->getParameter("pid");
						$this->form->getObject()->setProjetId($request->getParameter("pid"));
					}
					elseif($request->getParameter("eid"))
					{
						$id = $request->getParameter("eid");
						$this->form->getObject()->setEventId($request->getParameter("eid"));
					}
				}
				else
				{
					exit;
				}
				
				$this->form->save();
				
				$contents = array("errors" => array(), "aid" => $this->form->getObject()->getId(), "id" => $id, "status" => 200, "method" => "space", "imax" => "/uploads/galerie/max_" . $this->form->getObject()->getFichier(), "img" => "/uploads/galerie/mini_" . $this->form->getObject()->getFichier());
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
