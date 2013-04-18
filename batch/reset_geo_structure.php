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

// nom	Adresse 1	Adresse 2	Ville	CP	Code INSEE	N° téléphone	mail générique	Civilité Contact	Prénom	Nom	Fonction	Mail

// initialize database manager
$databaseManager = new sfDatabaseManager($configuration);
$databaseManager->loadConfiguration();


$structure = Doctrine_Query::create()
								->from('Profil c')
								->where('c.latitude = ?', "0.0000000000")
								->execute();


echo count($structure);

foreach($structure as $com)
{
	$com->refreshGeocodes();
	$com->save();
	echo ".";
}


$structure = Doctrine_Query::create()
								->from('Structure s')
								->where('s.latitude = ?', "0.0000000000")
								->execute();


echo count($structure);

foreach($structure as $com)
{
	$com->refreshGeocodes();
	$com->save();
	echo ".";
}


?>