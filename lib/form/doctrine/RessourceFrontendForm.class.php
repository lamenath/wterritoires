<?php

/**
	wTerritoires <http://www.wterritoires.fr/>
	Copyright (C) 2010 Simon Lamellière <opensource@worketer.fr>

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

class RessourceFrontendForm extends BaseRessourceForm
{
	public function edition()
	{
		$this->validatorSchema['fichier'] = new sfValidatorFile(array(
			'required'   => false,
			'path'       => sfConfig::get('sf_upload_dir') . "/ressource/",
			'mime_types' => array("application/pdf", "application/vnd",
							"application/vnd.ms-powerpoint", "application/vnd.ms-excel", "application/excel", "application/msword",
							"application/x-excel", "application/x-msexcel",
							"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
							"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
							"application/vnd.oasis.opendocument.text",
							"application/vnd.oasis.opendocument.spreadsheet",
							"application/vnd.oasis.opendocument.presentation",
							"application/vnd.oasis.opendocument.graphics")
		));
	}

	public function configure()
	{
		unset($this["id"]);

		$relations = array(
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

		$this->useFields(array('fichier', 'nom', 'resume', 'video', 'source'));

		$this->setValidators(array(
			'nom' => new sfValidatorString(array('min_length' => 5, 'max_length' => 50)),
			'source' => new sfValidatorString(array('required' => false)),
			'video' => new sfValidatorString(array('required' => false)),
			'resume' => new sfValidatorString(array('min_length' => 5, 'max_length' => 500, 'required' => false))
		));

		foreach($relations as $cname => $config)
		{
			$this->widgetSchema[$cname] = new rrWidgetRelations(
				array('label' => $config["label"]),
				array("config" => $config["input"], "max" => $config["max"])
			);

			$this->validatorSchema[$cname] = new rrValidatorRelations($config);
		}

		$this->widgetSchema['fichier'] = new sfWidgetFormInputFile(array(
			'label' => 'Fichier image',
		));

		$this->validatorSchema['fichier'] = new sfValidatorFile(array(
			'required'   => false,
			'path'       => sfConfig::get('sf_upload_dir') . "/ressource/",
			'mime_types' => array("application/pdf", "application/vnd",
							"application/vnd.ms-powerpoint", "application/vnd.ms-excel", "application/excel", "application/msword",
							"application/x-excel", "application/x-msexcel",
							"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
							"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
							"application/vnd.oasis.opendocument.text",
							"application/vnd.oasis.opendocument.spreadsheet",
							"application/vnd.oasis.opendocument.presentation",
							"application/vnd.oasis.opendocument.graphics")
		));

		$this->widgetSchema['fichier'] = new sfWidgetFormInputFileEditable(array(
			'file_src'  =>  sfConfig::get('sf_upload_dir') . '/ressource/'.$this->getObject()->getFichier(),
			'edit_mode' => !$this->isNew(),
			'template'  => '<div>%input%</div>',
		));

		$this->widgetSchema->setLabels(array(
							'nom'    => 'Titre du document',
							'source'   => 'Source du document',
							'fichier' => "Fichier à télécharger",
							'video' => "Identifiant Youtube",
							'resume' => "Résumé"
		));

		$this->validatorSchema['fichier_delete'] = new sfValidatorPass();
	}
}
