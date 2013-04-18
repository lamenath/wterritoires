<?php

class ProfilProjetListener extends Doctrine_Record_Listener
{
	public function preDelete(Doctrine_Event $event)
	{
		error_log("bichon");

		Story::erase(
				"Projet",
				$this->get("projet_id"),
				"contribute",
				sfContext::getInstance()->getUser()->getId()
		);
	}
}

?>