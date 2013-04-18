<?php

/**
 * ProfilCompetenceRecherche form base class.
 *
 * @method ProfilCompetenceRecherche getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProfilCompetenceRechercheForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'profil_id'     => new sfWidgetFormInputHidden(),
      'competence_id' => new sfWidgetFormInputHidden(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'profil_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('profil_id')), 'empty_value' => $this->getObject()->get('profil_id'), 'required' => false)),
      'competence_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('competence_id')), 'empty_value' => $this->getObject()->get('competence_id'), 'required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('profil_competence_recherche[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProfilCompetenceRecherche';
  }

}
