<?php

/**
 * HomeNews form.
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class HomeNewsForm extends BaseHomeNewsForm
{
	public $oldphoto;

	public function configure()
	{
		$this->oldphoto = $this->getObject()->get("photo");
		$this->useFields(array( "titre_lien", "titre", "text", "photo"));

		$this->widgetSchema->setLabels(array(
							'titre'    => 'Titre',
							'text'    => 'Texte',
							"titre_lien" => "Titre du lien carousel",
							'photo'    => 'Illustration (216 × 260 pixels)'
		));

		$this->validatorSchema['photo'] = new sfValidatorFile(array(
				  'required'   => false,
				  'path'       => sfConfig::get('sf_upload_dir') . "/home/",
				  'mime_types' => 'web_images',
		));

		$this->validatorSchema['photo_delete'] = new sfValidatorPass();

		$this->widgetSchema['photo'] = new sfWidgetFormInputFileEditable(array(
			      'label'     => 'Photo',
			      'file_src'  => '/uploads/home/'.$this->getObject()->getPhoto(),
			      'is_image'  => true,
			      'edit_mode' => !$this->isNew(),
			      'template'  => '<div>%file%<br />%input%<br /><br />%delete% ou supprimer image actuelle</div>',
		));

		$this->validatorSchema['photo_delete'] = new sfValidatorPass();

	}

	protected function doSave($con = null)
	{
		$isnew = $this->getObject()->isNew();
		$directory = "home";

		parent::doSave();
		$fileName = $this->getObject()->get("photo");

		if( $this->oldphoto != $fileName )
		{
			// Create the thumbnail
			$thumbnail = new sfThumbnail(216, 260,  false, false, 80, "sfImageMagickAdapter", array('convert' => '/usr/local/bin/convert', 'method' => 'shave_all'));
			$thumbnail->loadFile(sfConfig::get('sf_upload_dir').'/'.$directory.'/' . $fileName);
			$thumbnail->save(sfConfig::get('sf_upload_dir').'/'.$directory.'/'.$fileName);
		}
	}
}
