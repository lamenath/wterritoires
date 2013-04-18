<?php

/**
 * Structure form.
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class StructureFrontendForm extends BaseStructureForm
{
  public function configure()
  {
		unset($this["id"]);

		// Form Use & Valid
		$this->useFields(array("nom", "tel", "mail", "url", "adresse", "adresse2", "code_postal",  "ville", "photo", "presentation", "missions", "but", "strategie"));
		
		$this->setValidators(array(
								'nom' => new sfValidatorString(array('min_length' => 2, 'max_length' => 80)),
								'tel' => new sfValidatorString(array('min_length' => 10, 'max_length' => 10, "required" => false)), 
								'mail' => new sfValidatorEmail(array("required" => false)), 
								'adresse' => new sfValidatorString(array("required" => false)), 
								'adresse2' => new sfValidatorString(array("required" => false)), 
								"code_postal" => new sfValidatorAnd(array(
												new sfValidatorString(array('min_length' => 5, 'max_length' => 5)), 
												new sfValidatorRegex(array('pattern' => '#^[0-9]{5}$#ui'))
											) 
										),
								'presentation' => new sfValidatorString(array("required" => false)), 
								'missions' => new sfValidatorString(array("required" => false)), 
								'but' => new sfValidatorString(array("required" => false)), 
								'strategie' => new sfValidatorString(array("required" => false)), 
								'url' => new sfValidatorUrl(array("required" => false)),
								'ville' => new sfValidatorString(array("required" => true, 'min_length' => 1))
						) );

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
		
		// Relations
		foreach($relations as $cname => $config)
		{
			$this->widgetSchema[$cname] = new rrWidgetRelations(
					array('label' => $config["label"]),
					array("config" => $config["input"], "max" => $config["max"])
			);

			$this->validatorSchema[$cname] = new rrValidatorRelations($config);
		}
		
		$this->widgetSchema['photo'] = new sfWidgetFormInputFile(array(
		  'label' => 'Fichier image',
		));

		$this->validatorSchema['photo'] = new sfValidatorFile(array(
		  'required'   => false,
		  'path'       => sfConfig::get('sf_upload_dir') . "/structure/",
		  'mime_types' => 'web_images',
		));

		$this->widgetSchema['photo'] = new sfWidgetFormInputFileEditable(array(
	      'label'     => 'Photo',
	      'file_src'  => '/uploads/structure/'.$this->getObject()->getPhoto(),
	      'is_image'  => true,
	      'edit_mode' => !$this->isNew(),
	      'template'  => '<div>%input%<br /><br />%delete% ou supprimer image actuelle</div>',
		));

		// Labels
		$this->widgetSchema->setLabels(array(
					'url'    => 'Url site web',
					'tel' => "Numéro de téléphone",
					'mail' => "Email de contact",
					'adresse'   => 'Adresse',
					'adresse2'   => 'Adresse (suite)',
					'code_postal' => "Code Postal",
					'missions' => "Missions",
					'photo' => "Logo de la structure",
					'strategie' => "Stratégie"
		));
		
		$this->validatorSchema['photo_delete'] = new sfValidatorPass();
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
			$invite = new ProfilStructure();
			$invite->setProfilId( sfContext::getInstance()->getUser()->getId() );
			$invite->setStructureId( $this->getObject()->get("id") );
			$invite->setRole("admin");
			$invite->save();
		}
		if( $this->oldphoto != $fileName )
			RRR::genericCrop($fileName, "structure");
	}
}
