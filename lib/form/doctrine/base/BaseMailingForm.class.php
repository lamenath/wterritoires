<?php

/**
 * Mailing form base class.
 *
 * @method Mailing getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMailingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'sujet'        => new sfWidgetFormInputText(),
      'message'      => new sfWidgetFormTextarea(),
      'is_sent'      => new sfWidgetFormInputCheckbox(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
      'filiere_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Filiere')),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'sujet'        => new sfValidatorString(array('max_length' => 255)),
      'message'      => new sfValidatorString(),
      'is_sent'      => new sfValidatorBoolean(array('required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
      'filiere_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Filiere', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mailing[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Mailing';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['filiere_list']))
    {
      $this->setDefault('filiere_list', $this->object->Filiere->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveFiliereList($con);

    parent::doSave($con);
  }

  public function saveFiliereList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['filiere_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Filiere->getPrimaryKeys();
    $values = $this->getValue('filiere_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Filiere', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Filiere', array_values($link));
    }
  }

}
