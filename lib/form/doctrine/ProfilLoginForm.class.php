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
class ProfilLoginForm extends BaseProfilForm
{
  public function configure()
  {
  	unset($this["id"]);
  	
  	$this->useFields(array("password", "login"));
  	
  	$this->widgetSchema['password'] = new sfWidgetFormInput(array(
	  "type" => "password"
	));
	
	$this->setValidators(array(
		'password' => new sfValidatorString(array('min_length' => 6, 'max_length' => 20)),
		'login' => new sfValidatorAnd(array(new sfValidatorString(array('min_length' => 3, 'max_length' => 15)), new sfValidatorRegex(array('pattern' => '#^[\w\#\/]+$#ui'))) ),
	));
  }
}
