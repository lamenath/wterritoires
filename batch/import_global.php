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

$data = file("../data/fixtures/import.csv");

//CP ville insee oay
//02300	Abbecourt	02001	9	Chaunois

/*Doctrine_Query::create()
	->delete('Commune c')
	->execute();
*
*/


$structure = Doctrine_Query::create()
								->from('Structure')
								->execute();

foreach($structure as $structure)
{
	if(!count($structure->getProfilStructure()))
	{
		$pro = new ProfilStructure();
		$pro->setProfilId(15);
		$pro->setStructureId($structure->getId());
		$pro->save();
	}
}



// import des contacts

foreach($data as $line)
{
	$donnees = explode("\t", $line);

	$structure = Doctrine_Query::create()
								->from('Structure s')
								->where('s.nom = ?', $donnees[0])
								->fetchOne();

	switch($donnees[8])
	{
		case "Monsieur":
			$donnees[8]="m";
		break;
		case "Madame":
			$donnees[8]="mme";
		break;
		default:
			$donnees[8]="melle";
		break;
	}

	if($structure)
	{
		if(trim($donnees[10]) == "" && trim($donnees[9]) == "") continue;

		echo ".";

		$contact = new StructureContact();
		$contact->setStructureId($structure->getId());
		$contact->setCivilite($donnees[8]);
		$contact->setPrenom(ucfirst(trim($donnees[9])));
		$contact->setNom(ucfirst(trim($donnees[10])));
		$contact->setFonction(ucfirst(trim($donnees[11])));
		$contact->setMail(trim($donnees[12]));
		$contact->save();
	}
}





/*
$exist=0;
$not=0;

foreach($data as $line)
{
	$donnees = explode("\t", $line);

	$pays = Doctrine_Query::create()
	->from('Structure s')
	->where('s.nom = ?', trim($donnees[0]))
	->fetchOne();

	if($pays)
	{
		echo "XXX";
		continue;
	}

	$commune = Doctrine_Query::create()
	->from('Commune p')
	->where('p.code_postal = ?', trim($donnees[4]))
	->orWhere('p.code_insee = ?', trim($donnees[5]))
	->limit(1)
	->execute();

	if(isset($commune[0]))
	{
		$commune = $commune[0];
		$structure = new Structure();
		$structure->setNom(trim($donnees[0]));
		$structure->setAdresse(trim($donnees[1]));
		$structure->setAdresse2(trim($donnees[2]));
		$structure->setVille($commune->getNom());
		$structure->setCodePostal($commune->getCodePostal());
		$structure->setCodeInsee($commune->getCodeInsee());
		$structure->setTel(trim($donnees[6]));
		$structure->setMail(trim($donnees[7]));
		$structure->save();
	}
	else
	{
		$structure = new Structure();
		$structure->setNom(trim($donnees[0]));
		$structure->setAdresse(trim($donnees[1]));
		$structure->setAdresse2(trim($donnees[2]));
		$structure->setVille(trim($donnees[3]));
		$structure->setCodePostal(trim($donnees[4]));
		$structure->setCodeInsee(trim($donnees[5]));
		$structure->setTel(trim($donnees[6]));
		$structure->setMail(trim($donnees[7]));
		$structure->save();
	}

	echo ".";
}

echo $exist . " existe --" . $not . "existe pas";
*/



?>