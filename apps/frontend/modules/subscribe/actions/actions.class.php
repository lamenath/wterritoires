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

class subscribeActions extends sfActions
{
	public function executeCulture()
	{
		echo $this->getUser()->getCulture();
		exit;
	}
	
	public function executeIndex(sfWebRequest $request, $edit=false)
	{
		$form = $this->form = new ProfilFrontendForm();
		$this->getUser()->denyLoggedIn();
		
		// Set Label with link
		$this->form["is_activated"]->getWidget()->setLabel(sfContext::getInstance()->getI18n()->__("Acceptez-vous les <a target='_blank' href='%url'>conditions générales</a> ?", array("%url" => $this->getController()->genUrl("@cgu"))));
		
		if($request->isMethod("POST") && $this->form->isCSRFProtected())
		{
			$form->bind(
				$request->getParameter($form->getName()),
				$request->getFiles($form->getName())
			);

			if ($form->isValid())
			{
				// Enregistrmenet du nouveau profil
				$user = $form->save();
				$clear_pass = $user->getPassword();

				// Mise à jour des données essentielles
				$user->setPassword(md5($clear_pass));
				$user->setLogin(trim($user->getLogin()));
				$user->setCreatedAt(new Doctrine_Expression("NOW()"));
				$user->setIsAdmin(0);
				$user->save();

				// Connexion automatique & envoi de l'email de bienvenue
				$this->getUser()->createAuth($user);
				$this->getUser()->sendSubscribeMail($clear_pass);

				// Redirection STEP 2
				$this->redirect('profile/edit?proute=general&account_created=true');
			}
		}
	}
}
