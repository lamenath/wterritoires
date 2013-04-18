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

class ProjetForm extends BaseProjetForm
{
	public $oldphoto;

	public function configure()
	{
		parent::configure();
		
		unset($this["story_id"], $this["slug"], $this["photo_crop"], $this["createur_id"], $this["updated_at"], $this["created_at"]);
		
		$this->oldphoto = $this->getObject()->get("photo");
		
		$this->widgetSchema['photo'] = new sfWidgetFormInputFile(array(
			 'label' => 'Fichier image',
		));

		$this->validatorSchema['photo'] = new sfValidatorFile(array(
			  'required'   => false,
			  'path'       => sfConfig::get('sf_upload_dir') . "/projet/",
			  'mime_types' => 'web_images',
		));

		$this->widgetSchema['photo'] = new sfWidgetFormInputFileEditable(array(
		      'label'     => 'Photo',
		      'file_src'  => '/uploads/projet/'.($this->getObject()->getPhoto() ? 'normal_' . $this->getObject()->getPhoto() : "default.png"),
		      'is_image'  => true,
		      'edit_mode' => !$this->isNew(),
		      'template'  => '<div>%file%<br />%input%<br /><br />%delete% ou supprimer image actuelle</div>',
		));

		$this->widgetSchema['date_echeance'] = new sfWidgetFormJQueryDate(array('image'=>'/images/calendar.png'));
		$this->widgetSchema['date_debut'] = new sfWidgetFormJQueryDate(array('image'=>'/images/calendar.png'));
		
		$this->validatorSchema['photo_delete'] = new sfValidatorPass();

		$relations = array(
								"metier_list" => array(
													"max" => 10,
													"min" => 1,
													"required" => false,
													"label" => "Métiers",
													"input" => array( "display" => "Metier"),
		),
								"structure_list" => array(
													"max" => 10,
													"min" => 1,
													"required" => false,
													"label" => "Structures",
													"input" => array( "display" => "Structure"),
		),
								"structure_partenaire_list" => array(
													"max" => 10,
													"min" => 1,
													"required" => false,
													"label" => "Structures partenaire",
													"input" => array( "display" => "Structure"),
		),
								"competence_list" => array(
													"max" => 10,
													"min" => 1,
													"required" => false,
													"label" => "Compétences",
													"input" => array( "display" => "Competence"),
		),
								"filiere_list" => array(
													"max" => 10,
													"min" => 1,
													"required" => false,
													"label" => "Filières",
													"input" => array( "display" => "Filiere"),
		),
								"theme_list" => array(
													"max" => 10,
													"min" => 1,
													"required" => false,
													"label" => "Thèmes",
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
	}
	
	protected function doSave($con = null)
	{
		parent::doSave();
		$fileName = $this->getObject()->get("photo");

		if( $this->oldphoto != $fileName )
			RRR::genericCrop($fileName, "projet");
	}
}
