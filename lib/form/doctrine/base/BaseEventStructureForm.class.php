<?php

/**
 * EventStructure form base class.
 *
 * @method EventStructure getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEventStructureForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'event_id'     => new sfWidgetFormInputHidden(),
      'structure_id' => new sfWidgetFormInputHidden(),
      'type'         => new sfWidgetFormChoice(array('choices' => array('referent' => 'referent', 'partenaire' => 'partenaire'))),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'event_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('event_id')), 'empty_value' => $this->getObject()->get('event_id'), 'required' => false)),
      'structure_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('structure_id')), 'empty_value' => $this->getObject()->get('structure_id'), 'required' => false)),
      'type'         => new sfValidatorChoice(array('choices' => array(0 => 'referent', 1 => 'partenaire'), 'required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('event_structure[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EventStructure';
  }

}
