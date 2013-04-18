<?php

/**
 * ProfilContact form base class.
 *
 * @method ProfilContact getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseProfilContactForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'profil_id'    => new sfWidgetFormInputHidden(),
      'contact_id'   => new sfWidgetFormInputHidden(),
      'is_activated' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'profil_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'profil_id', 'required' => false)),
      'contact_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'contact_id', 'required' => false)),
      'is_activated' => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('profil_contact[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProfilContact';
  }

}
