<?php

/**
 * ProfilProjet form base class.
 *
 * @method ProfilProjet getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProfilProjetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'profil_id'  => new sfWidgetFormInputHidden(),
      'projet_id'  => new sfWidgetFormInputHidden(),
      'role'       => new sfWidgetFormChoice(array('choices' => array('referent' => 'referent', 'contributeur' => 'contributeur', 'observateur' => 'observateur'))),
      'date'       => new sfWidgetFormDateTime(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'profil_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('profil_id')), 'empty_value' => $this->getObject()->get('profil_id'), 'required' => false)),
      'projet_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('projet_id')), 'empty_value' => $this->getObject()->get('projet_id'), 'required' => false)),
      'role'       => new sfValidatorChoice(array('choices' => array(0 => 'referent', 1 => 'contributeur', 2 => 'observateur'), 'required' => false)),
      'date'       => new sfValidatorDateTime(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('profil_projet[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProfilProjet';
  }

}
