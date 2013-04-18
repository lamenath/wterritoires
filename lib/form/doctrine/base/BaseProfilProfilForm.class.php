<?php

/**
 * ProfilProfil form base class.
 *
 * @method ProfilProfil getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProfilProfilForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'profil_id'    => new sfWidgetFormInputHidden(),
      'contact_id'   => new sfWidgetFormInputHidden(),
      'story_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story'), 'add_empty' => true)),
      'is_activated' => new sfWidgetFormInputText(),
      'date'         => new sfWidgetFormDateTime(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'profil_id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('profil_id')), 'empty_value' => $this->getObject()->get('profil_id'), 'required' => false)),
      'contact_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('contact_id')), 'empty_value' => $this->getObject()->get('contact_id'), 'required' => false)),
      'story_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Story'), 'required' => false)),
      'is_activated' => new sfValidatorInteger(array('required' => false)),
      'date'         => new sfValidatorDateTime(array('required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('profil_profil[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProfilProfil';
  }

}
