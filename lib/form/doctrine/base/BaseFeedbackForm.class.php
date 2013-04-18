<?php

/**
 * Feedback form base class.
 *
 * @method Feedback getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFeedbackForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'profil_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'add_empty' => true)),
      'status'     => new sfWidgetFormChoice(array('choices' => array('new' => 'new', 'acknowledged' => 'acknowledged', 'prod' => 'prod'))),
      'titre'      => new sfWidgetFormInputText(),
      'message'    => new sfWidgetFormTextarea(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'profil_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'required' => false)),
      'status'     => new sfValidatorChoice(array('choices' => array(0 => 'new', 1 => 'acknowledged', 2 => 'prod'), 'required' => false)),
      'titre'      => new sfValidatorString(array('max_length' => 255)),
      'message'    => new sfValidatorString(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('feedback[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Feedback';
  }

}
