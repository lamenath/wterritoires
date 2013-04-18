<?php

	// CREATE TABLE stats (id BIGINT AUTO_INCREMENT, type VARCHAR(255), total BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX type_idx (type), INDEX created_at_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;

	require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

	$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
	sfContext::createInstance($configuration);

	// initialize database manager
	$databaseManager = new sfDatabaseManager($configuration);
	$databaseManager->loadConfiguration();

	// Create stats for today
	// Delete today's entries (security)
	Doctrine_Query::create()
					->delete("Stats")
					->where("created_at >= ?", date("Y-m-d 00:00:00"))
					->execute();

	// New stats
	$stat = new Stats();
	$stat->setType("profile");
	$stat->setTotal(Doctrine_Query::create()->from("Profil")->count());
	$stat->save();

	// New stats
	$stat = new Stats();
	$stat->setType("event");
	$stat->setTotal(Doctrine_Query::create()->from("Event")->count());
	$stat->save();

	// New stats
	$stat = new Stats();
	$stat->setType("project");
	$stat->setTotal(Doctrine_Query::create()->from("Projet")->count());
	$stat->save();


	echo "ok";

?>