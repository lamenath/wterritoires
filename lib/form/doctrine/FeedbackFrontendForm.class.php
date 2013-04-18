<?php

/**
 * Feedback form.
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FeedbackFrontendForm extends BaseFeedbackForm
{
  public function configure()
  {
  	unset($this["id"]);
  	
  	$this->useFields(array('message', 'status', 'titre'));
  	
	$this->setValidators(array(
		"titre" => new sfValidatorString(),
		'message' => new sfValidatorString(array('min_length' => 10, 'max_length' => 700)),
		'status' => new sfValidatorChoice(array("required" => false, "choices" => array("test" => "new", "prod", "acknowledged")))
	));
  }
  
  public function ignoreStatus()
  {
  	unset($this["status"]);
  }
  
}
