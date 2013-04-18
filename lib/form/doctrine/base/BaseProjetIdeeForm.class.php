<?php

/**
 * ProjetIdee form base class.
 *
 * @method ProjetIdee getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProjetIdeeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'profil_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'add_empty' => false)),
      'projet_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Projet'), 'add_empty' => true)),
      'event_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Event'), 'add_empty' => true)),
      'story_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story'), 'add_empty' => true)),
      'status'     => new sfWidgetFormChoice(array('choices' => array('new' => 'new', 'acknowledged' => 'acknowledged', 'prod' => 'prod'))),
      'titre'      => new sfWidgetFormInputText(),
      'message'    => new sfWidgetFormTextarea(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'profil_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'))),
      'projet_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Projet'), 'required' => false)),
      'event_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Event'), 'required' => false)),
      'story_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Story'), 'required' => false)),
      'status'     => new sfValidatorChoice(array('choices' => array(0 => 'new', 1 => 'acknowledged', 2 => 'prod'), 'required' => false)),
      'titre'      => new sfValidatorString(array('max_length' => 255)),
      'message'    => new sfValidatorString(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('projet_idee[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProjetIdee';
  }

}
