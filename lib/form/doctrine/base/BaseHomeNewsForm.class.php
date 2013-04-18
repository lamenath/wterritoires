<?php

/**
 * HomeNews form base class.
 *
 * @method HomeNews getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseHomeNewsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'photo'      => new sfWidgetFormInputText(),
      'titre'      => new sfWidgetFormInputText(),
      'text'       => new sfWidgetFormTextarea(),
      'titre_lien' => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'photo'      => new sfValidatorString(array('max_length' => 255)),
      'titre'      => new sfValidatorString(array('max_length' => 100)),
      'text'       => new sfValidatorString(),
      'titre_lien' => new sfValidatorString(array('max_length' => 20)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('home_news[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'HomeNews';
  }

}
