<?php

	require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

	$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
	sfContext::createInstance($configuration);

	// initialize database manager
	$databaseManager = new sfDatabaseManager($configuration);
	$databaseManager->loadConfiguration();


	// Load CSV
	$test = file_get_contents(dirname(__FILE__)."/utf2.csv");
	$test = explode("\n", $test);

	// Table List
	$fTables = array("ProjetFiliere", "ProfilFiliere", "EventFiliere", "RessourceFiliere", "StructureFiliere");

	// Foreach
	foreach($test as $line)
	{
		$lin = explode(";", $line);
		$name = str_replace("\"", "", $lin[0]);
		$replac_name = str_replace("\"", "", $lin[1]);
		$replac_2 = str_replace("\"", "", $lin[2]);

		// Find Filiere
		$filiere = Doctrine_Query::create()
									->from("Filiere")
									->where("nom = ?", $name )
									->fetchOne();

		// Pas trouvé
		if(!$filiere)
		{
			echo "x";
			continue;
		}

		// Commentaire ?
		if($lin[3] == '"A supprimer"')
		{
			// Suppression totale de la filiere
			$filiere->delete();
			continue;
		}

		// Transfert demandé
		if($lin[3] != '')
		{
			// Transfert de la relation filière en thème
			foreach($fTables as $fT)
			{
				$item = strtolower(str_replace("Filiere", "", $fT));
				$newN = str_replace("Filiere", "Theme", $fT);
				$rel = Doctrine_Query::create()
									->from($fT)
									->where("filiere_id = ?", $filiere->getId())
									->execute();

				// 1er theme
				foreach($rel as $rela)
				{
					// Con
					$theme = create_or_fetch_th($filiere->getNom());
					create_rel_theme($newN, $theme, $item."_id", $rela->get($item."_id"));
				}
			}
		}

		// On supprime la filière théoriquement
		// $filiere->delete();

		// On change la filière vers 
		// Remplacement simple
		$new_filiere_1 = create_or_fetch($replac_name);

		// 2eme filiere ?
		if($replac_2)
			$new_filiere_2 = create_or_fetch($replac_2);
		else
			$new_filiere_2 = 0;

		// Go
		
		// Transfert de la relation filière en thème
		foreach($fTables as $fT)
		{
			$rel = Doctrine_Query::create()
								->from($fT)
								->where("filiere_id = ?", $filiere->getId())
								->execute();

			// 1er theme
			foreach($rel as $rela)
			{
				$item = strtolower(str_replace("Filiere", "", $fT));

				// Con
				create_rel_filiere($fT, $new_filiere_1, $item."_id", $rela->get($item."_id"));

				// Second
				if($new_filiere_2)
				{
					echo $rela->getFiliereId() . " " . $rela->getId() . " " . $fT . " " . $new_filiere_2 . " - " . $item."_id" . " - " . $rela->get($item."_id");
					create_rel_filiere($fT, $new_filiere_2, $item."_id", $rela->get($item."_id"));
				}

				// Remove this relation ?
				if($new_filiere_1 != $filiere->getId())
					$rela->delete();
			}
		}

		if($filiere)
			echo ".";
		else
			echo 'x';

		// Remove it
		if($name != $replac_name)
			$filiere->delete();
	}

	// Fonctions
	function create_or_fetch($fnam)
	{
		$filiere = Doctrine_Query::create()
									->from("Filiere")
									->where("nom = ?", $fnam )
									->fetchOne();

		if(!$filiere)
		{
			$filiere = new Filiere();
			$filiere->setNom($fnam);
			$filiere->save();
		}
		
		return (int) $filiere->getId();
	}

	function create_or_fetch_th($fnam)
	{
		$filiere = Doctrine_Query::create()
									->from("Theme")
									->where("nom = ?", $fnam )
									->fetchOne();

		if(!$filiere)
		{
			$filiere = new Theme();
			$filiere->setNom($fnam);
			$filiere->save();
		}
		
		return $filiere->getId();
	}

	function create_rel_filiere($newN, $theme, $item, $rela)
	{
		$test = Doctrine_Query::create()
								->from($newN)
								->where("filiere_id = ?" , $theme)
								->andWhere($item." = ?", $rela)
								->fetchOne();

		if(!$test)
		{	
			//
			$newx = new $newN();
			$newx->set("filiere_id", $theme);
			$newx->set($item, (int)$rela);
			$newx->save();
		}
	}

	function create_rel_theme($newN, $theme, $item, $rela)
	{
		$test = Doctrine_Query::create()
								->from($newN)
								->where("theme_id = ?" , $theme)
								->andWhere($item." = ?", $rela)
								->fetchOne();

		if(!$test)
		{	
			//
			$newx = new $newN();
			$newx->set("theme_id", $theme);
			$newx->set($item, (int)$rela);
			$newx->save();
		}
	}
?>