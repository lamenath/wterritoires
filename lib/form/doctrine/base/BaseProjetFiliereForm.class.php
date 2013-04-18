<?php

/**
 * ProjetFiliere form base class.
 *
 * @method ProjetFiliere getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProjetFiliereForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'projet_id'  => new sfWidgetFormInputHidden(),
      'filiere_id' => new sfWidgetFormInputHidden(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'projet_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('projet_id')), 'empty_value' => $this->getObject()->get('projet_id'), 'required' => false)),
      'filiere_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('filiere_id')), 'empty_value' => $this->getObject()->get('filiere_id'), 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('projet_filiere[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProjetFiliere';
  }

}
