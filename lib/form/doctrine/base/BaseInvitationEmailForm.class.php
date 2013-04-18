<?php

/**
 * InvitationEmail form base class.
 *
 * @method InvitationEmail getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseInvitationEmailForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'email'       => new sfWidgetFormInputText(),
      'projet_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Projet'), 'add_empty' => true)),
      'event_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Event'), 'add_empty' => true)),
      'inviteur_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inviteur'), 'add_empty' => true)),
      'date'        => new sfWidgetFormDateTime(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'email'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'projet_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Projet'), 'required' => false)),
      'event_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Event'), 'required' => false)),
      'inviteur_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inviteur'), 'required' => false)),
      'date'        => new sfValidatorDateTime(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('invitation_email[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'InvitationEmail';
  }

}
