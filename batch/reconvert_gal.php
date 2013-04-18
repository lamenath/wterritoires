<?php

	/**
	   wTerritoires <http://www.wterritoires.fr/>
	   Copyright (C) 2011 Simon Lamellière <opensource@worketer.fr>

	   This program is free software: you can redistribute it and/or modify
	   it under the terms of the GNU Affero General Public License as
	   published by the Free Software Foundation, either version 3 of the
	   License, or (at your option) any later version.
	**/

	require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

	$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
	sfContext::createInstance($configuration);
	sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');

	// initialize database manager
	$databaseManager = new sfDatabaseManager($configuration);
	$databaseManager->loadConfiguration();

	// Find people
	$contacts = Doctrine_Query::create()
								->from("PhotoProjet")
								->where("fichier != ''")
								->andWhere("fichier IS NOT NULL")
								->execute();

	foreach($contacts as $contact)
	{
		$fileName =  $contact->getFichier();

		//if(file_exists(sfConfig::get('sf_upload_dir').'/structure/max_'.$fileName))
		//	continue;

		try {
			// Create the thumbnail
			RRR::genericCropGal($fileName, "galerie");
			
		}
		catch(Exception $e)
		{

		}

		echo ".";
	}

?>