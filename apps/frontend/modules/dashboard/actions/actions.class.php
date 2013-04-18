<?php

class dashboardActions extends sfActionsJson
{
	public $bypass = array("index");

	public function preExecute()
	{
		if(!$this->getUser()->isAuthenticated() || $this->getUser()->getObject()->getIsAdmin() != 1)
			$this->redirect404();
	}

	public function executeIndex(sfWebRequest $request)
	{
		switch($request->getParameter("proute"))
		{
			case "segments":
				$this->proute = "segments";
				break;
			case "mailings":
				$this->proute = "mailings";
				break;
			case "tendances":
				$this->proute = "tendances";
			break;
			case "variations":
				$this->proute = "variations";
			break;
			default:
				$this->proute = "mailings";
				//$this->moduleRoute = "story";
			break;
		}
	}
	
	public function executeSend(sfWebRequest $request)
	{
		$obj = Doctrine::getTable("Mailing")->find($request->getParameter("id"));
		
		if(!$obj)
		{
			$this->setJsonContents(array("errors" => array(), "message" => sfContext::getInstance()->getI18n()->__("Ce message n'existe pas !"), "status" => 500, "method" => "display"));
			return false;
		}
		
		// Prepare
		$message = $obj->getMessage();
		$sub = $obj->getSujet();
		
		// Some tests
		if($request->getParameter("case") == "test")
		{
			rMail::create($this->getUser()->getId(), "[TEST] " . $sub, "raw", array("html" => $message), true, $this->getUser()->getObject()->getEmail())
				->send();
			
			$this->setJsonContents(array("errors" => array(), "message" => sfContext::getInstance()->getI18n()->__("OK! Vous recevrez un email dans moins d'une minute, sur  %mail", array("%mail" =>  $this->getUser()->getObject()->getEmail())), "status" => 200, "method" => "display"));

			return false;
		}
		if($obj->getIsSent() == true)
		{
			$this->setJsonContents(array("errors" => array(), "message" => sfContext::getInstance()->getI18n()->__("Ce message a déjà été envoyé, il ne peut être envoyé plusieurs fois."), "status" => 500, "method" => "display"));
			return false;
		}
		
		// Send Full Mailing
		if($obj->getFiliere()->count())
		{
			$fils = array();
			foreach($obj->getFiliere() as $f)
			{
				$fils[] = $f->getId();	
			}
			
			$base = Doctrine_Query::create()->select("p.id")->from("Profil p")->leftJoin("p.ProfilFiliere f")->whereIn("f.filiere_id", $fils)->execute(array(), Doctrine::HYDRATE_ARRAY);
		}
		else
		{
			$base = Doctrine_Query::create()->select("id")->from("Profil")->execute(array(), Doctrine::HYDRATE_ARRAY);
		}
		
		foreach($base as $c)
		{
			rMail::create($c["id"], $sub, "raw", array("html" => $message))
				->send();
		}
		
		// Set as sent (protection)
		$obj->setIsSent(true);
		$obj->save();
		
		$this->setJsonContents(array("errors" => array(), "message" => sfContext::getInstance()->getI18n()->__("Votre message a bien été transmis à %count destinataires", array("%count" => count($base))), "status" => 200, "method" => "display"));
	}
	
	public function executeRemove(sfWebRequest $request)
	{
		if($request->getParameter("id"))
		{
			$obj = Doctrine::getTable("Segment")->find($request->getParameter("id"));
			$obj->delete();
		}
		
		$this->redirect("dashboard/segments?page=".$request->getParameter("page"));
	}
	
	public function executeRemove_mailing(sfWebRequest $request)
	{
		if($request->getParameter("id"))
		{
			$obj = Doctrine::getTable("Mailing")->find($request->getParameter("id"));
			$obj->delete();
		}
		
		$this->redirect("dashboard/mailings?page=".$request->getParameter("page"));
	}
	
	public function executeEdit(sfWebRequest $request)
	{
		if($request->getParameter("id"))
		{
			$obj = Doctrine::getTable("Segment")->find($request->getParameter("id"));
			$this->form = new SegmentForm($obj);
		}
		else
		{
			$this->form = new SegmentForm();
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

				$contents = array("errors" => array(), "status" => 200, "method" => "goto", "url" => $this->getController()->genUrl("dashboard/segments"));
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
	
	public function executeMailing(sfWebRequest $request)
	{
		if($request->getParameter("id"))
		{
			$obj = Doctrine::getTable("Mailing")->find($request->getParameter("id"));
			$this->form = new MailingForm($obj);
		}
		else
		{
			$this->form = new MailingForm();
			
			if(!($request->isMethod("PUT") && $request->isMethod("POST")))
			{
				$this->form->getWidget("message")->setDefault("Bonjour {full_name},<br><br>Votre texte ici...");
			}
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

				$contents = array("errors" => array(), "status" => 200, "method" => "goto", "url" => $this->getController()->genUrl("dashboard/mailings"));
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
