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
class ProfilFrontendPrivacyForm extends BaseProfilForm
{
  public function configure()
  {
  	unset($this["id"]);
  	
  	$this->useFields(array("privacy_type"));
  	
  	$this->setWidget( 'privacy_type', new sfWidgetFormChoice(array('expanded' => true, 'choices' => array(  'public' => 'Tout le monde',
  							'private' => 'Les membres inscrits', 
  							'friends' => 'Mes contacts directs'))) );
  	
	$this->setValidators(array(
		"privacy_type" => new sfValidatorChoice(array("choices" => array("public", "private", "friends")))
	));
  }
}
