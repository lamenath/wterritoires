<?php

/**
	wTerritoires <http://www.wterritoires.fr/>
	Copyright (C) 2013 Simon Lamellière <opensource@worketer.fr>

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU Affero General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU Affero General Public License for more details.

	You should have received a copy of the GNU Affero General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
**/

class ProjetFrontendForm extends BaseProjetForm
{
	public $editable = false;
	public $oldphoto;
	public $use = array("nom", "photo", "commune_id", "action", "lecons", "avancement", "date_debut", "date_echeance", "url", "resultats", "strategie", 'besoins', 'objectifs_qualitatif', 'objectifs_quantitatif');
	public $valids = array();

	public function configure()
	{
		unset($this["id"]);

		$this->oldphoto = $this->getObject()->get("photo");

		// Form Use & Valid
		$this->useFields($this->use);
		$this->setValidators(array(
								'commune_id' => new sfValidatorInteger(array("required" => true)),
								'nom' => new sfValidatorString(array('min_length' => 5, 'max_length' => 80)),
								'objectifs_qualitatif' => new sfValidatorString(array("required" => false, 'max_length' => 560)),
								'lecons' => new sfValidatorString(array("required" => false, 'max_length' => 540)),
								'objectifs_quantitatif' => new sfValidatorString(array("required" => false, 'max_length' => 560)),
								'date_debut' => new sfValidatorDate(array("required" => false)),
								'date_echeance' => new sfValidatorDate(array("required" => false)),
								'avancement' => new sfValidatorInteger(array("min" => 0, "max" => 100, "required" => false)),
								'strategie' => new sfValidatorString(array("required" => false, 'max_length' => 560)),
								'resultats' => new sfValidatorString(array("required" => false, 'max_length' => 560)),
								'besoins' => new sfValidatorString(array("required" => false, 'max_length' => 560)),
								'url' => new sfValidatorUrl(array("required" => false)),
								'action' => new sfValidatorChoice(array("choices" => array("regional", "territorial", "local", "ultralocal")))
						) );

		$this->widgetSchema['photo'] = new sfWidgetFormInputFile(array(
		  'label' => 'Fichier image',
		));

		$this->validatorSchema['photo'] = new sfValidatorFile(array(
		  'required'   => false,
		  'path'       => sfConfig::get('sf_upload_dir') . "/projet/",
		  'mime_types' => 'web_images',
		));
		
		if(! $this->getObject()->isNew() )
		{
			$this->widgetSchema['type'] = new sfWidgetFormChoice(array('choices' => array('public' => 'Projet (public)', 'group' => 'Groupe de Travail (privé - sur invitation)')));
			$this->validatorSchema['type'] = new sfValidatorChoice(array("required" => true, "choices" => array("public", "group")));
		
			$this->use[] = "type";
			$this->useFields($this->use);
		}

		$this->widgetSchema['action'] = new sfWidgetFormChoice(array('choices' => array('regional' => 'Régionale', 'territorial' => 'Territoriale', 'local' => 'Locale', 'ultralocal' => 'Ultra-Locale')));

		$this->widgetSchema['photo'] = new sfWidgetFormInputFileEditable(array(
	      'label'     => 'Photo',
	      'file_src'  => '/uploads/projet/'.$this->getObject()->getPhoto(),
	      'is_image'  => true,
	      'edit_mode' => !$this->isNew(),
	      'template'  => '<div>%input%<br /><br />%delete% ou supprimer image actuelle</div>',
		));

		$dateWidget = new sfWidgetFormI18nDate(array('format' => '%day%/%month%/%year%', 'month_format' => 'short_name', 'culture' => 'fr'));
  		$this->widgetSchema['date_debut'] = new sfWidgetFormJQueryDate(array('image'=>'/images/calendar.png', 'culture'=> 'fr', 'date_widget' => $dateWidget));

  		$dateWidget2 = new sfWidgetFormI18nDate(array( 'format' => '%day%/%month%/%year%', 'month_format' => 'short_name', 'culture' => 'fr'));
  		$this->widgetSchema['date_echeance'] = new sfWidgetFormJQueryDate(array('image'=>'/images/calendar.png', 'culture'=> 'fr', 'date_widget' => $dateWidget2));

		$this->validatorSchema['photo_delete'] = new sfValidatorPass();

		$relations = array(
									"filiere_list" => array(
														"max" => 20,
														"min" => 1,
														"required" => false,
														"label" => "Filières associées",
														"input" => array( "display" => "Filiere"),
														),
									"theme_list" => array(
														"max" => 20,
														"min" => 1,
														"required" => false,
														"label" => "Thèmes associées",
														"input" => array( "display" => "Theme"),
														),
									"competence_list" => array(
														"max" => 20,
														"min" => 1,
														"required" => false,
														"label" => "Compétences recherchées",
														"input" => array( "display" => "Competence"),
														),
									"metier_list" => array(
														"max" => 20,
														"min" => 1,
														"required" => false,
														"label" => "Métiers recherchés",
														"input" => array( "display" => "Metier"),
														)
		);

		// Commune
		$this->widgetSchema["commune_id"] = new rrWidgetRelations(
			array('label' => "Commune"),
			array("simple" => true, "config" => array("display" => "Commune"), "max" => 1)
		);

		// Relations
		foreach($relations as $cname => $config)
		{
			$this->widgetSchema[$cname] = new rrWidgetRelations(
					array('label' => $config["label"]),
					array("config" => $config["input"], "max" => $config["max"])
			);

			$this->validatorSchema[$cname] = new rrValidatorRelations($config);
		}

		// Slider
		$this->widgetSchema["avancement"] = new rrWidgetSlider();

		// Labels
		$this->widgetSchema->setLabels(array(
					'nom'    => 'Nom du projet',
					'action'    => 'Portée du projet',
					'lecons'   => 'Leçons',
					'date_debut'   => 'Date de début',
					'date_echeance' => "Date d'échéance",
					'resultats' => "Résultats",
					'photo' => "Image du projet",
					'strategie' => "Stratégie"
		));
	}

	public function getModelName()
	{
		return 'Projet';
	}

	protected function doSave($con = null)
	{
		$isnew = $this->getObject()->isNew();

		parent::doSave();
		$fileName = $this->getObject()->get("photo");

		if($isnew)
		{
			// Set creator
			$this->getObject()->setCreateurId(sfContext::getInstance()->getUser()->getId());
			$this->getObject()->save();

			// Add creator into
			$invite = new ProfilProjet();
			$invite->setProfilId( sfContext::getInstance()->getUser()->getId() );
			$invite->setProjetId( $this->getObject()->get("id") );
			$invite->setRole("referent");
			$invite->setDate(new Doctrine_Expression("NOW()"));
			$invite->save();
		}
		if( $this->oldphoto != $fileName )
			RRR::genericCrop($fileName, "projet");
	}
}
