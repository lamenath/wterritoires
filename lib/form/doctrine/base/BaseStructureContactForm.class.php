<?php

/**
 * StructureContact form base class.
 *
 * @method StructureContact getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStructureContactForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'structure_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Structure'), 'add_empty' => true)),
      'profil_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'add_empty' => true)),
      'civilite'     => new sfWidgetFormChoice(array('choices' => array('m' => 'm', 'melle' => 'melle', 'mme' => 'mme'))),
      'nom'          => new sfWidgetFormInputText(),
      'prenom'       => new sfWidgetFormInputText(),
      'fonction'     => new sfWidgetFormInputText(),
      'mail'         => new sfWidgetFormInputText(),
      'phone'        => new sfWidgetFormInputText(),
      'requalif'     => new sfWidgetFormInputCheckbox(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'structure_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Structure'), 'required' => false)),
      'profil_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'required' => false)),
      'civilite'     => new sfValidatorChoice(array('choices' => array(0 => 'm', 1 => 'melle', 2 => 'mme'), 'required' => false)),
      'nom'          => new sfValidatorString(array('max_length' => 255)),
      'prenom'       => new sfValidatorString(array('max_length' => 255)),
      'fonction'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mail'         => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'phone'        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'requalif'     => new sfValidatorBoolean(array('required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('structure_contact[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StructureContact';
  }

}
