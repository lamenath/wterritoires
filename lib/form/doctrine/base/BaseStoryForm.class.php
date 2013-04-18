<?php

/**
 * Story form base class.
 *
 * @method Story getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStoryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'profil_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'add_empty' => false)),
      'object_id'      => new sfWidgetFormInputText(),
      'object_model'   => new sfWidgetFormInputText(),
      'relation_id'    => new sfWidgetFormInputText(),
      'relation_model' => new sfWidgetFormInputText(),
      'story_i18n'     => new sfWidgetFormInputText(),
      'type'           => new sfWidgetFormInputText(),
      'url'            => new sfWidgetFormInputText(),
      'params'         => new sfWidgetFormTextarea(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'buddies_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Profil')),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'profil_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'))),
      'object_id'      => new sfValidatorInteger(array('required' => false)),
      'object_model'   => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'relation_id'    => new sfValidatorInteger(array('required' => false)),
      'relation_model' => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'story_i18n'     => new sfValidatorString(array('max_length' => 255)),
      'type'           => new sfValidatorString(array('max_length' => 25)),
      'url'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'params'         => new sfValidatorString(array('required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
      'buddies_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Profil', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('story[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Story';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['buddies_list']))
    {
      $this->setDefault('buddies_list', $this->object->Buddies->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveBuddiesList($con);

    parent::doSave($con);
  }

  public function saveBuddiesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['buddies_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Buddies->getPrimaryKeys();
    $values = $this->getValue('buddies_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Buddies', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Buddies', array_values($link));
    }
  }

}
