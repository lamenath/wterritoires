<?php

/**
 * Commune form base class.
 *
 * @method Commune getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCommuneForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'pays_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Pays'), 'add_empty' => true)),
      'nom'         => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormTextarea(),
      'photo'       => new sfWidgetFormInputText(),
      'code_postal' => new sfWidgetFormInputText(),
      'code_insee'  => new sfWidgetFormInputText(),
      'slug'        => new sfWidgetFormInputText(),
      'latitude'    => new sfWidgetFormInputText(),
      'longitude'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'pays_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Pays'), 'required' => false)),
      'nom'         => new sfValidatorString(array('max_length' => 255)),
      'description' => new sfValidatorString(array('required' => false)),
      'photo'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'code_postal' => new sfValidatorString(array('max_length' => 10)),
      'code_insee'  => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'slug'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'latitude'    => new sfValidatorPass(array('required' => false)),
      'longitude'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Commune', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('commune[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Commune';
  }

}
