<?php

/**
 * Profil form.
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 * PART 1
 */
class ProfilFrontendImgForm extends BaseProfilForm
{
	public function configure()
	{
		unset($this["id"]);
		 
		$this->useFields(array('photo'));

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
}
