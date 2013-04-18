<?php

/**
   wTerritoires <http://www.wterritoires.fr/>
   Copyright (C) 2010 Simon Lamellière <opensource@worketer.fr>

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as
   published by the Free Software Foundation, either version 3 of the
   License, or (at your option) any later version.
**/

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
sfContext::createInstance($configuration);


// initialize database manager
$databaseManager = new sfDatabaseManager($configuration);
$databaseManager->loadConfiguration();


$Profils = Doctrine_Query::create()->from("Profil p")->where("TRIM(p.presentation) = '' OR p.presentation IS NULL")->andWhere("p.relance_count < 3")->execute();
$i = 0;

$content = file_get_contents(dirname(__FILE__) . "/profil_vides.txt");

foreach($Profils as $profil)
{
	if(!count($profil->getProfilMetier()) && !count($profil->getProfilFiliere()) && !count($profil->getProfilCompetence()) && !count($profil->getProfilTheme()))
	{
		$message = Swift_Message::newInstance();
		$mailBody = sprintf($content, $profil->getPrenom(), $profil->getLogin(),
			$message->embed(Swift_Image::fromPath(dirname(__FILE__) . "/Image_3.png")));

		RRR::complexMail($profil->getPrenom() . " : complétez votre profil sur le Réseau Rural de Picardie", $profil->getEmail(), nl2br($mailBody), $message, true);

		$profil->setRelanceCount($profil->getRelanceCount() + 1);
		$profil->save();

		$i++;
		echo ".";
	}
}

echo $i;
?>