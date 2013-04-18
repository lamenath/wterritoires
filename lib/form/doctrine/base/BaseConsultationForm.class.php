<?php

/**
 * Consultation form base class.
 *
 * @method Consultation getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseConsultationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'doc_id'      => new sfWidgetFormInputText(),
      'type_id'     => new sfWidgetFormChoice(array('choices' => array('profil' => 'profil', 'projet' => 'projet'))),
      'ip_source'   => new sfWidgetFormInputText(),
      'visiteur_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'add_empty' => true)),
      'date'        => new sfWidgetFormDateTime(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'doc_id'      => new sfValidatorInteger(array('required' => false)),
      'type_id'     => new sfValidatorChoice(array('choices' => array(0 => 'profil', 1 => 'projet'), 'required' => false)),
      'ip_source'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'visiteur_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'required' => false)),
      'date'        => new sfValidatorDateTime(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('consultation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Consultation';
  }

}
