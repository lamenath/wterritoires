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
class ProfilFrontendStep2ExtendForm extends BaseProfilForm
{
  public function configure()
  {
  	unset($this["id"]);
  	
  	$this->useFields(array('email', 'nom', 'prenom', 'ville', "presentation", "code_postal"));
  	
	$this->setValidators(array(
		'email'   => new sfValidatorEmail(),
		'nom' => new sfValidatorString(array('min_length' => 2, 'max_length' => 30)),
		'prenom' => new sfValidatorString(array('min_length' => 2, 'max_length' => 30)),
		"presentation" => new sfValidatorString(),
		"code_postal" => new sfValidatorAnd(array(
						new sfValidatorString(array('min_length' => 5, 'max_length' => 5)), 
						new sfValidatorRegex(array('pattern' => '#^[0-9]{5}$#ui'))
					) 
				),
		'ville' => new sfValidatorString(array('min_length' => 2, 'max_length' => 40))
	));
  }
}
