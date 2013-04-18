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

class ProfilFrontendIdentifiedForm extends BaseProfilForm
{
	public $oldphoto;

	public function configure()
	{
		unset($this["id"]);

		$this->useFields(array("nom", "prenom", "adresse", "ville", "code_postal", "presentation", "photo"));

		$this->oldphoto = $this->getObject()->get("photo");

		$this->setValidators(array(
			'nom' => new sfValidatorString(array('min_length' => 2, 'max_length' => 30)),
			'prenom' => new sfValidatorString(array('min_length' => 2, 'max_length' => 30)),
			'adresse' => new sfValidatorString(array('min_length' => 6, 'max_length' => 500)),
			'presentation' => new sfValidatorString(array('min_length' => 6, 'max_length' => 1000)),
			'code_postal' => new sfValidatorString(array('min_length' => 4, 'max_length' => 7)),
			'ville' => new sfValidatorString(array('min_length' => 1, 'max_length' => 100))
		));

		$this->widgetSchema->setLabels(array(
			'nom'    => 'Nom',
			'prenom'   => 'Prénom',
			'ville'   => 'Ville de résidence',
			'code_postal' => "Code Postal",
			'presentation' => "Presentation personnelle",
			'photo' => "Votre photo"
		));

		$this->widgetSchema['photo'] = new sfWidgetFormInputFile(array(
				  'label' => 'Fichier image',
		));

		$this->validatorSchema['photo'] = new sfValidatorFile(array(
				  'required'   => false,
				  'path'       => sfConfig::get('sf_upload_dir') . "/profil/",
				  'mime_types' => 'web_images',
		));

		$this->widgetSchema['photo'] = new sfWidgetFormInputFileEditable(array(
			      'label'     => 'Photo',
			      'file_src'  => '/uploads/profil/'.$this->getObject()->getPhoto(),
			      'is_image'  => true,
			      'edit_mode' => !$this->isNew(),
			      'template'  => '<div>%input%<br /><br />%delete% ou supprimer image actuelle</div>',
		));


		$this->validatorSchema['photo_delete'] = new sfValidatorPass();
	}

	protected function doSave($con = null)
	{
		parent::doSave();
		$fileName = $this->getObject()->get("photo");

		if( $this->oldphoto != $fileName )
			RRR::genericCrop($fileName, "profil");
	}
}

?>