<?php

/**
 * Profil form.
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProfilForm extends BaseProfilForm
{
	public $oldphoto;
	
	public function configure()
	{
		parent::configure();
		unset($this["id"], $this["created_at"], $this["updated_at"], $this["email"], $this["login"], $this["latitude"], $this["longitude"]);
		
		$this->oldphoto = $this->getObject()->get("photo");
		
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
			'file_src'  => '/uploads/profil/'.($this->getObject()->getPhoto()?"normal_".$this->getObject()->getPhoto():"default.png"),
			'is_image'  => true,
			'edit_mode' => !$this->isNew(),
			'template'  => '<div>%file%<br />%input%<br /><br />%delete% ou supprimer image actuelle</div>',
		));

		$this->validatorSchema['photo_delete'] = new sfValidatorPass();

		$this->widgetSchema['created_at'] = new sfWidgetFormJQueryDate(array('image'=>'/images/calendar.png'));

		$relations = array(
								"metier_list" => array(
													"max" => 10,
													"min" => 1,
													"required" => false,
													"label" => "Mes métiers",
													"input" => array( "display" => "Metier"),
		),
								"structure_list" => array(
													"max" => 10,
													"min" => 1,
													"required" => false,
													"label" => "Mes structures",
													"input" => array( "display" => "Structure"),
		),
								"projet_list" => array(
													"max" => 100,
													"min" => 1,
													"required" => false,
													"label" => "Mes projets",
													"input" => array( "display" => "Projet"),
		),
								"competence_list" => array(
													"max" => 10,
													"min" => 1,
													"required" => false,
													"label" => "Vos compétences",
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
			RRR::genericCrop($fileName, "profil");
	}
}
