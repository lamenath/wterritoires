<?php

/**
 * StructureTheme form base class.
 *
 * @method StructureTheme getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStructureThemeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'structure_id' => new sfWidgetFormInputHidden(),
      'theme_id'     => new sfWidgetFormInputHidden(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'structure_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('structure_id')), 'empty_value' => $this->getObject()->get('structure_id'), 'required' => false)),
      'theme_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('theme_id')), 'empty_value' => $this->getObject()->get('theme_id'), 'required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('structure_theme[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StructureTheme';
  }

}
