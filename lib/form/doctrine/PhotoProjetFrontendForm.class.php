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
class PhotoProjetFrontendForm extends BasePhotoProjetForm
{
	public $oldphoto;
	
	public function edition()
	{
		$this->validatorSchema['fichier'] = new sfValidatorFile(array(
			'required'   => false,
			'path'       => sfConfig::get('sf_upload_dir') . "/galerie/",
			'mime_types' => 'web_images'
		));
	}
	
	public function configure()
	{
		unset($this["id"]);
		$this->oldphoto = $this->getObject()->get("fichier");
		 
		$this->useFields(array('fichier', 'nom'));
		
		$this->setValidators(array(
			'nom' => new sfValidatorString(array('min_length' => 5, 'max_length' => 50)),
		));
		
		$this->widgetSchema['fichier'] = new sfWidgetFormInputFile(array(
		  'label' => 'Fichier image',
		));

		$this->validatorSchema['fichier'] = new sfValidatorFile(array(
		  'required'   => true,
		  'path'       => sfConfig::get('sf_upload_dir') . "/galerie/",
		  'mime_types' => 'web_images'
		));

		$this->widgetSchema['fichier'] = new sfWidgetFormInputFileEditable(array(
	      'label'     => 'Photo',
	      'file_src'  => '/uploads/galerie/'.$this->getObject()->getFichier(),
	      'is_image'  => true,
	      'edit_mode' => !$this->isNew(),
	      'template'  => '<div>%input%<br /><br />%delete% ou supprimer image actuelle</div>',
		));

		$this->validatorSchema['fichier_delete'] = new sfValidatorPass();
	}
	
	protected function doSave($con = null)
	{
		$isnew = $this->getObject()->isNew();

		parent::doSave();
		$fileName = $this->getObject()->get("fichier");

		if($isnew)
		{
			// Set creator
			$this->getObject()->setCreateurId(sfContext::getInstance()->getUser()->getId());
			$this->getObject()->save();
		}
		
		if( $this->oldphoto != $fileName )
			RRR::genericCropGal($fileName, "galerie");
	}
}
