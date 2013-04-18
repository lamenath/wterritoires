<?php

class ProfilProfil extends BaseProfilProfil
{
	public function postInsert($event)
	{
		// send mail
	}

	public function postUpdate($event)
	{
		if($this->get("is_activated") == 1)
		{
			// We create a story
			Story::publish(
							"default",
							"Profil",
							$this->get("contact_id"),
							$this->get("profil_id"),
							"friends",
							"",
							array(),
							array(),
							true
			);
		}
	}
}
