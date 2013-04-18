<?php

/**
 * RessourceTheme form base class.
 *
 * @method RessourceTheme getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRessourceThemeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'ressource_id' => new sfWidgetFormInputHidden(),
      'theme_id'     => new sfWidgetFormInputHidden(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'ressource_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('ressource_id')), 'empty_value' => $this->getObject()->get('ressource_id'), 'required' => false)),
      'theme_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('theme_id')), 'empty_value' => $this->getObject()->get('theme_id'), 'required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('ressource_theme[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RessourceTheme';
  }

}
