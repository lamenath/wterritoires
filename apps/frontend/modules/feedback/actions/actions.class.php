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

class feedbackActions extends sfActions
{
	public function preExecute()
	{
		$this->getUser()->requireLogin();
	}

	public function executeIndex(sfWebRequest $request)
	{
		$this->feedbacks = Doctrine_Query::create()
											->from('Feedback f')
											->orderBy("f.created_at DESC");

	    // Quelle est le numéro de page à afficher
	    $numPage = $request->getParameter('page', $request->getParameter("page"));
	    $nbPosts = sfConfig::get('app_posts_number_per_page', 6);

	    $this->pager = new sfDoctrinePager('Feedback', $nbPosts);

	    $this->pager->setQuery($this->feedbacks);
	    $this->pager->setPage($numPage);
	    $this->pager->init();
	}

	public function executeDelete(sfWebRequest $request)
	{
		$feedback = Doctrine::getTable('Feedback')->find($request->getParameter('id'));
		if(!$feedback) $this->redirect("feedback/index");

		// Vérifier qu'il en est bien le propriétaire
		if($this->getUser()->isAdmin() || $feedback->getProfilId() == $this->getUser()->getId())
		{
			// Supprimer les commentaires associés
			$feedback->flushComments();

			// Supprimer l'entrée
			$feedback->delete();

			$this->redirect("feedback/index");
		}
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->executeNew($request);
		$this->setTemplate('new');
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->editable = false;

		if($request->getParameter("id"))
		{
			$feedback = Doctrine::getTable('Feedback')->find($request->getParameter('id'));
			if(!$feedback) $this->redirect("feedback/index");
			$this->editable = $request->getParameter('id');

			// Vérifier qu'il en est bien le propriétaire
			if($feedback->getProfilId() != $this->getUser()->getId())
			{
				if(!$this->getUser()->isAdmin()) $this->redirect("feedback/index");
			}
			$this->form = new FeedbackFrontendForm($feedback);
			$oldStatus = $this->form->getObject()->getStatus();
			$oldStatusReadable = $this->form->getObject()->__getStatus();
		}
		else
		{
			$this->form = new FeedbackFrontendForm();
		}

		// Status for admin
		if(!$this->getUser()->isAdmin())
		{
			$this->form->ignoreStatus();
		}

		if($request->isMethod("POST") && $this->form->isCSRFProtected())
		{
			sfContext::getInstance()->getConfiguration()->loadHelpers('Url');

			$this->form->bind(
				$request->getParameter($this->form->getName()),
				$request->getFiles($this->form->getName())
			);

			$is_new = $this->form->getObject()->isNew();

			if($this->form->isValid())
			{
				// Enregistrmenet du nouveau feedback
				$feedback = $this->form->save();

				// Set createur
				if($is_new)
				{
					$feedback->setProfilId($this->getUser()->getId());
					$feedback->setCreatedAt(date("Y-m-d H:i:s"));
					$feedback->save();
				}
				else
				{
					if($oldStatus != $feedback->getStatus() && $this->form->getObject()->getProfil()->getNotifyNewItem() == 1)
					{
						// Envoi du changement de status
						$mailBody = $this->getPartial('notify',
							array(
								'names' => $feedback->getProfil()->getPrenom(),
								'title' => $feedback->getTitre(),
								"stat1" => $oldStatusReadable,
								"stat2" => $feedback->__getStatus(),
								'urlx' => url_for("feedback/index") . "#feedback_line_" .$feedback->getId(),
								"person" => $this->getUser()->getObject()->__toString(),
							)
						);

						RRR::sendMailHybrid($mailBody, $this->getUser()->getObject()->__toString() . __(" a changé le statut de votre suggestion '%title'", array("%title" => $feedback->getTitre())), $feedback->getProfil()->getEmail());
					}
				}

				// Redirect
				$this->redirect("feedback/index");
			}
		}
	}
}
