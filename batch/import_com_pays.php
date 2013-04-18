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

$data = file("FR.txt");
$i=0;

foreach($data as $t)
{
	$donnees = explode("\t", $t);

	$exists = Doctrine_Query::create()
		->from('Commune p')
		->where('p.code_insee = ?', trim($donnees[13]))
		->fetchOne();

	if(!$exists)
	{
		$commune = new Commune();
		$commune->setNom($donnees[1]);
		$commune->setCodePostal($donnees[11]);
		$commune->setCodeInsee($donnees[13]);
		$commune->setLatitude($donnees[4]);
		$commune->setLongitude($donnees[5]);
		$commune->save();
	}

	echo '.';

}

//CP ville insee oay
//02300	Abbecourt	02001	9	Chaunois


exit;

Doctrine_Query::create()
	->delete('Commune c')
	->execute();

foreach($data as $line)
{
	$donnees = explode("\t", $line);
	echo ".";

	$pays = Doctrine_Query::create()
	->from('Pays p')
	->where('p.nom = ?', trim($donnees[4]))
	->fetchOne();

	if($pays)
	{
		$commune = new Commune();
		$commune->setPaysId($pays->getId());
		$commune->setNom($donnees[1]);
		$commune->setCodePostal($donnees[0]);
		$commune->setCodeInsee($donnees[2]);
		$commune->refreshGeocodes();
		$commune->save();
	}
}


	/*

Doctrine_Query::create()
	->delete('Pays p')
	->execute();

foreach($data as $line)
{
	$donnees = explode("\t", $line);
	echo ".";

	$test = Doctrine_Query::create()
	->from('Pays p')
	->where('p.nom = ?', trim($donnees[4]))
	->fetchOne();

	if(!$test)
	{
		$pays = new Pays();
		$pays->setNom(trim($donnees[4]));
		$pays->save();
	}
}

*/

?>