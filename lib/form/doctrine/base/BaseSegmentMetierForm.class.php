<?php

/**
 * SegmentMetier form base class.
 *
 * @method SegmentMetier getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSegmentMetierForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'segment_id' => new sfWidgetFormInputHidden(),
      'metier_id'  => new sfWidgetFormInputHidden(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'segment_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('segment_id')), 'empty_value' => $this->getObject()->get('segment_id'), 'required' => false)),
      'metier_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('metier_id')), 'empty_value' => $this->getObject()->get('metier_id'), 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('segment_metier[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SegmentMetier';
  }

}
