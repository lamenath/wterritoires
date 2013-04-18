<?php

/**
   wTerritoires <http://www.wterritoires.fr/>
   Copyright (C) 2010 Simon Lamellière <opensource@worketer.fr>

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

class inboxActions extends sfActionsJson
{
	public $bypass = array("index", "read");

	public function executeRead(sfWebRequest $request)
	{
		$this->message = Doctrine_Query::create()
				->from('Messagerie m')
				->innerJoin("m.Profil p")
				->innerJoin("m.Sender")
				->where("((m.sender_id = ?", $this->getUser()->getId())
				->andWhere("m.is_deleted_sender = ?)", 0)
				->orWhere("(m.profil_id = ?", $this->getUser()->getId())
				->andWhere("m.is_deleted_receiver = ?))", 0)
				->andWhere("m.id=?", $request->getParameter("id"))
				->fetchOne(array(), "profile_light");
				
		if(!$this->message)
			die('Error');
		
		// Set As Read
		if($this->message["extraData"]["profil_id"] == $this->getUser()->getId())
		{
			$msg = Doctrine::getTable("Messagerie")->find($request->getParameter("id"));
			$msg->setSeenAt(new Doctrine_Expression("NOW()"));
			$msg->save();
		}
	}

	public function executeIndex(sfWebRequest $request)
	{
		$this->message = array();

		switch($request->getParameter("proute"))
		{
			case "in":
				$this->proute = "in";
				$messages = Doctrine_Query::create()
											->from('Messagerie m')
											->innerJoin("m.Sender p")
											->where("m.profil_id = ?", $this->getUser()->getId())
											->andWhere("m.is_deleted_receiver = 0")
											->orderBy("m.created_at DESC");
				break;
			case "out":
				$this->proute = "in";
				$messages = Doctrine_Query::create()
											->from('Messagerie m')
											->innerJoin("m.Profil p")
											->where("m.sender_id = ?", $this->getUser()->getId())
											->andWhere("m.is_deleted_sender = 0")
											->orderBy("m.created_at DESC");
				break;
			default:
				exit;
				$this->proute = "index";
				break;
		}

		if($s = $request->getParameter("search"))
		{
			$messages->andWhere("(m.sujet LIKE ? OR m.message LIKE ? OR CONCAT(TRIM(p.prenom), ' ', TRIM(p.nom)) LIKE ? OR CONCAT(TRIM(p.nom), ' ', TRIM(p.prenom)) LIKE ?)", array("%".$s."%","%".$s."%","%".$s."%", "%".$s."%"));
		}
		
		list($this->pager, $this->total) = RRR::pager($messages, "Messagerie", 7);
	}

	public function executeSend(sfWebRequest $request)
	{
		$this->profil = Doctrine_Query::create()
					->from('Profil p')
					->where('p.id = ?', $request->getParameter("did"))
					->fetchOne(array(), "profile_light");

		if(!$this->profil)
		{
			exit;
		}
		
		// Init form
		$this->form = new InboxForm();
		
		if($request->isMethod("POST"))
		{
			$this->form->bind(
				$request->getParameter($this->form->getName()),
				$request->getFiles($this->form->getName())
			);

			if($this->form->isValid())
			{
				$this->form->getObject()->setSenderId($this->getUser()->getId());
				$this->form->getObject()->setProfilId($request->getParameter("did"));
				$this->form->getObject()->setIsSent(1);
				$this->form->save();
				$contents = array("status" => 200, "method" => "display", "errors" => array(), "message" => sfContext::getInstance()->getI18n()->__("Votre message a bien été transmis!"));
			}
			else
			{
				$contents = array("errors" => sfActionsJson::getSfErrors($this->form), "status" => 500);
			}

			$this->setJsonContents($contents);
		}
		else
		{
			if($mid = $request->getParameter("mid"))
			{
				$this->message = Doctrine_Query::create()
					->from('Messagerie m')
					->where("((m.sender_id = ?", $this->getUser()->getId())
					->andWhere("m.is_deleted_sender = ?)", 0)
					->orWhere("(m.profil_id = ?", $this->getUser()->getId())
					->andWhere("m.is_deleted_receiver = ?))", 0)
					->andWhere("m.id=?", $mid)
					->fetchOne(array(), Doctrine::HYDRATE_ARRAY);
					
				if(!$this->message)
					die('Error');

				$this->form->getWidget("sujet")->setAttribute("value", "RE: " . $this->message["sujet"]);
			}
			
			$this->isJsonable(false);
		}
	}

	public function executeRemove(sfWebRequest $request)
	{
		$message = Doctrine::getTable('Messagerie')->find($request->getParameter('mid'));
		
		if(!$message) 
			$this->setJsonContents(sfActionsJson::$ERROR_RELOAD);

		if($request->isMethod("post"))
		{
			if($message->getProfilId() == $this->getUser()->getId())
			{
				$message->setIsDeletedReceiver(1);
				$message->save();
			}
	
			if($message->getSenderId() == $this->getUser()->getId())
			{
				$message->setIsDeletedSender(1);
				$message->save();
				
				$this->redirect("inbox/sent");
			}
			
			$this->setJsonContents(array("message" => sfContext::getInstance()->getI18n()->__("Le message a bien été supprimé"), "status" => 200, "method" => "remove", "id" => "inbox-".$request->getParameter("mid")));
		}
		else
		{
			$this->isJsonable(false);
		}
	}

}
