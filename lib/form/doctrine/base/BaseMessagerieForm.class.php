<?php

/**
 * Messagerie form base class.
 *
 * @method Messagerie getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMessagerieForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'profil_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'add_empty' => true)),
      'sender_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sender'), 'add_empty' => true)),
      'sujet'               => new sfWidgetFormInputText(),
      'message'             => new sfWidgetFormTextarea(),
      'seen_at'             => new sfWidgetFormDateTime(),
      'is_sent'             => new sfWidgetFormInputCheckbox(),
      'is_deleted_sender'   => new sfWidgetFormInputCheckbox(),
      'is_deleted_receiver' => new sfWidgetFormInputCheckbox(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'profil_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'required' => false)),
      'sender_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sender'), 'required' => false)),
      'sujet'               => new sfValidatorString(array('max_length' => 150)),
      'message'             => new sfValidatorString(array('required' => false)),
      'seen_at'             => new sfValidatorDateTime(array('required' => false)),
      'is_sent'             => new sfValidatorBoolean(array('required' => false)),
      'is_deleted_sender'   => new sfValidatorBoolean(array('required' => false)),
      'is_deleted_receiver' => new sfValidatorBoolean(array('required' => false)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('messagerie[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Messagerie';
  }

}
