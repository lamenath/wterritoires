<?php

/**
	wTerritoires <http://www.wterritoires.fr/>
	Copyright (C) 2011 Simon Lamellière <opensource@worketer.fr>

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

class EventFrontendForm extends BaseEventForm
{
	public $editable = false;
	public $use = array("titre", "description", "photo", "contacts", "lieu", "adresse", "ville", "start_at", "end_at", "visibilite");
	public $valids = array();
	public $oldphoto;

	public function configure()
	{
		unset($this["id"]);

		$this->oldphoto = $this->getObject()->get("photo");

		// Form Use & Valid
		$this->useFields($this->use);
		$this->setValidators(array(
								'titre' => new sfValidatorString(array("required" => true, 'min_length' => 5, 'max_length' => 80)),
								'description' => new sfValidatorString(array("required" => true,  'min_length' => 5, 'max_length' => 560)),
								'contacts' => new sfValidatorString(array("required" => false,  'min_length' => 5, 'max_length' => 560)),
								'lieu' => new sfValidatorString(array("required" => true,  'min_length' => 3, 'max_length' => 560)),
								'adresse' => new sfValidatorString(array("required" => true,  'min_length' => 5, 'max_length' => 560)),
								'ville' => new sfValidatorString(array("required" => true,  'min_length' => 5, 'max_length' => 560)),
								'start_at' => new sfValidatorDateTime(array("required" => true)),
								'end_at' => new sfValidatorDateTime(array("required" => false)),
								'visibilite' => new sfValidatorChoice(array('choices' => array(0 => 'public', 1 => 'private'), 'required' => true))
						) );

		// Choix des administrateurs (se fait parmi les gens faisant partie du projet)
		if(!$this->getObject()->isNew())
		{
			$this->widgetSchema["admin_list"] = new rrWidgetRelations(
				array('label' => "Administrateurs de l'événement"),
				array("eid" => $this->getObject()->getId(), "config" => array("display" => "Profil"), "max" => 10)
			);

			$this->validatorSchema["admin_list"] = new rrValidatorRelations(array(
												"max" => 10,
												"min" => 1,
												"required" => false
												));
		}

		$this->widgetSchema['photo'] = new sfWidgetFormInputFile(array(
		  'label' => 'Fichier image',
		));

		$this->widgetSchema['visibilite'] = new sfWidgetFormChoice(array('choices' => array('public' => 'Publique', 'private' => 'Privé')));

		$this->validatorSchema['photo'] = new sfValidatorFile(array(
		  'required'   => false,
		  'path'       => sfConfig::get('sf_upload_dir') . "/event/",
		  'mime_types' => 'web_images',
		));

		$this->widgetSchema['photo'] = new sfWidgetFormInputFileEditable(array(
	      'label'     => 'Photo',
	      'file_src'  => '/uploads/event/'.$this->getObject()->getPhoto(),
	      'is_image'  => true,
	      'edit_mode' => !$this->isNew(),
	      'template'  => '<div>%input%<br />%delete% ou supprimer image actuelle</div>',
		));

  		$this->widgetSchema['start_at'] = new sfWidgetFormJQueryDate(array('image'=>'/images/calendar.png', 'culture'=> 'fr', 'date_widget' => $this->widgetSchema['start_at']));
  		$this->widgetSchema['end_at'] = new sfWidgetFormJQueryDate(array('image'=>'/images/calendar.png', 'culture'=> 'fr', 'date_widget' => $this->widgetSchema['end_at']));

		$this->validatorSchema['photo_delete'] = new sfValidatorPass();

		$relations = array(
							"competence_list" => array(
												"max" => 10,
												"min" => 1,
												"required" => false,
												"label" => "Compétences associées",
												"input" => array( "display" => "Competence"),
												),
							"metier_list" => array(
												"max" => 10,
												"min" => 1,
												"required" => false,
												"label" => "Métiers associées",
												"input" => array( "display" => "Metier"),
												),
							"filiere_list" => array(
												"max" => 10,
												"min" => 1,
												"required" => false,
												"label" => "Filières associées",
												"input" => array( "display" => "Filiere"),
												),
							"theme_list" => array(
												"max" => 10,
												"min" => 1,
												"required" => false,
												"label" => "Thèmes associées",
												"input" => array( "display" => "Theme"),
												)
		);

		foreach($relations as $cname => $config)
		{
			$this->widgetSchema[$cname] = new rrWidgetRelations(
					array('label' => $config["label"]),
					array("config" => $config["input"], "max" => $config["max"])
			);

			$this->validatorSchema[$cname] = new rrValidatorRelations($config);
		}

		// Set Labels
		$this->widgetSchema->setLabels(array(
					'visibilite'    => 'Visibilité de l\'événement',
					'start_at'    => 'Date et heure de début',
					'end_at'    => 'Date et heure de fin'
		));

	}

	protected function doSave($con = null)
	{
		$isnew = $this->getObject()->isNew();

		parent::doSave();
		$fileName = $this->getObject()->get("photo");

		if($isnew)
		{
			// Continue
			$this->getObject()->setCreateurId(sfContext::getInstance()->getUser()->getId());
			$this->getObject()->save();

			// Add creator into
			$invite = new EventInvite();
			$invite->setProfilId( sfContext::getInstance()->getUser()->getId() );
			$invite->setEventId( $this->getObject()->get("id") );
			$invite->setEtat("yes");
			$invite->save();
		}

		if( $this->oldphoto != $fileName )
			RRR::genericCrop($fileName, "event");
	}
}
