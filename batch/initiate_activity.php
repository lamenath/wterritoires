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

	// Flush all
	Doctrine_Query::create()
					->delete("Story")
					->where("object_model = ?", "ProjetIdee")
					->orWhere("object_model = ?", "Ressource")
					->orWhere("object_model = ?", "Projet")
					->execute();

	// Regen Ideas
	$ideas = Doctrine_Query::create()
								->from("Ressource")
								->execute();

	foreach($ideas as $idea)
	{
		sfContext::getInstance()->getUser()->setAttribute("id", $idea->getCreateurId());
		Story::$created_at = $idea->getCreatedAt();
		$idea->postInsert();
		echo "r";

		Story::$relation_model = null;
		Story::$relation_id = null;
	}

	// Regen Ressources
	$ideas = Doctrine_Query::create()
								->from("ProjetIdee")
								->execute();

	foreach($ideas as $idea)
	{
		sfContext::getInstance()->getUser()->setAttribute("id", $idea->getProfilId());
		Story::$created_at = $idea->getCreatedAt();
		$idea->postInsert();
		echo "i";

		Story::$relation_model = null;
		Story::$relation_id = null;
	}

	// Regen Joins
	$ideas = Doctrine_Query::create()
							->from("ProfilProjet")
							->execute();

	foreach($ideas as $idea)
	{
		sfContext::getInstance()->getUser()->setAttribute("id", $idea->getProfilId());
		Story::$created_at = $idea->getCreatedAt();
		$idea->postSave("");
		echo "pp";

		Story::$relation_model = null;
		Story::$relation_id = null;
	}

?>