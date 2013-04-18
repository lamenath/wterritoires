<?php

/**
 * AnnonceCompetence form base class.
 *
 * @method AnnonceCompetence getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAnnonceCompetenceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'annonce_id'    => new sfWidgetFormInputHidden(),
      'competence_id' => new sfWidgetFormInputHidden(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'annonce_id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('annonce_id')), 'empty_value' => $this->getObject()->get('annonce_id'), 'required' => false)),
      'competence_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('competence_id')), 'empty_value' => $this->getObject()->get('competence_id'), 'required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('annonce_competence[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AnnonceCompetence';
  }

}