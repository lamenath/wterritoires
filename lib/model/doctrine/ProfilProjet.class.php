<?php

class ProfilProjet extends BaseProfilProjet
{
	public function postSave($event)
	{
		if(  sfContext::getInstance()->getConfiguration()->getApplication() != "backend")
		{
			Story::publish(
					"default",
					"Projet",
					$this->get("projet_id"),
					$this->get("profil_id"),
					"contribute",
					"",
					array("role" => $this->get("role")),
					array(),
					true
			);
			
			// A t il été nommé ?
			// Si oui on notifie l'utilisateur
			if($this->get("role") == "referent" && $this->get("profil_id") != sfContext::getInstance()->getUser()->getId())
			{
				$project = Doctrine_Query::create()->from("Projet")->where("id=?", $this->get("projet_id"))->fetchOne(array(), "project_light");
	
				rMail::create($this->get("profil_id"), "", "upgrade", array("url" => $project["url"], "name" => $project["nom"], "inviter" => sfContext::getInstance()->getUser()->getObject()->__toString()), true)
						->send();
			}
		}
	}

	public function postDelete($values)
	{
		// Listener pas appelé.. Ne fonctionne pas... vive symfony !
		Story::erase(
				"Projet",
				$this->get("projet_id"),
				sfContext::getInstance()->getUser()->getId(),
				"contribute"
		);
	}
}
