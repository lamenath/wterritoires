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
								->from("Profil")
								->where("photo != ''")
								->andWhere("photo IS NOT NULL")
								->execute();

	foreach($contacts as $contact)
	{
		$fileName =  $contact->getPhoto();

		if(file_exists(sfConfig::get('sf_upload_dir').'/profil/max_'.$fileName))
			continue;

		try {
			// Create the thumbnail
			$thumbnail = new sfThumbnail(218, 140,  false, false, 80, "sfImageMagickAdapter", array('convert' => '/usr/local/bin/convert', 'method' => 'shave_all'));
			$thumbnail->loadFile(sfConfig::get('sf_upload_dir').'/profil/' . $fileName);
			$thumbnail->save(sfConfig::get('sf_upload_dir').'/profil/max_'.$fileName, 'image/png');

			// Create the thumbnail
			$thumbnail = new sfThumbnail(95, 60,  false, false, 80, "sfImageMagickAdapter", array('convert' => '/usr/local/bin/convert', 'method' => 'shave_all'));
			$thumbnail->loadFile(sfConfig::get('sf_upload_dir').'/profil/' . $fileName);
			$thumbnail->save(sfConfig::get('sf_upload_dir').'/profil/normal_'.$fileName, 'image/png');

			// Create the thumbnail
			$thumbnail = new sfThumbnail(60, 60, false, false, 80, "sfImageMagickAdapter", array('convert' => '/usr/local/bin/convert', 'method' => 'shave_all'));
			$thumbnail->loadFile(sfConfig::get('sf_upload_dir').'/profil/' . $fileName);
			$thumbnail->save(sfConfig::get('sf_upload_dir').'/profil/mini_'.$fileName, 'image/png');
		}
		catch(Exception $e)
		{

		}

		echo ".";
	}

?>