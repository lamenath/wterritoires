<?php

/**
 * Theme form base class.
 *
 * @method Theme getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseThemeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'nom'            => new sfWidgetFormInputText(),
      'description'    => new sfWidgetFormTextarea(),
      'is_activated'   => new sfWidgetFormInputCheckbox(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'slug'           => new sfWidgetFormInputText(),
      'profil_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Profil')),
      'ressource_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Ressource')),
      'event_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Event')),
      'structure_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Structure')),
      'projet_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Projet')),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nom'            => new sfValidatorString(array('max_length' => 255)),
      'description'    => new sfValidatorString(array('required' => false)),
      'is_activated'   => new sfValidatorBoolean(array('required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
      'slug'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'profil_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Profil', 'required' => false)),
      'ressource_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Ressource', 'required' => false)),
      'event_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Event', 'required' => false)),
      'structure_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Structure', 'required' => false)),
      'projet_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Projet', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'Theme', 'column' => array('nom'))),
        new sfValidatorDoctrineUnique(array('model' => 'Theme', 'column' => array('slug'))),
      ))
    );

    $this->widgetSchema->setNameFormat('theme[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Theme';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['profil_list']))
    {
      $this->setDefault('profil_list', $this->object->Profil->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['ressource_list']))
    {
      $this->setDefault('ressource_list', $this->object->Ressource->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['event_list']))
    {
      $this->setDefault('event_list', $this->object->Event->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['structure_list']))
    {
      $this->setDefault('structure_list', $this->object->Structure->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['projet_list']))
    {
      $this->setDefault('projet_list', $this->object->Projet->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveProfilList($con);
    $this->saveRessourceList($con);
    $this->saveEventList($con);
    $this->saveStructureList($con);
    $this->saveProjetList($con);

    parent::doSave($con);
  }

  public function saveProfilList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['profil_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Profil->getPrimaryKeys();
    $values = $this->getValue('profil_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Profil', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Profil', array_values($link));
    }
  }

  public function saveRessourceList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['ressource_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Ressource->getPrimaryKeys();
    $values = $this->getValue('ressource_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Ressource', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Ressource', array_values($link));
    }
  }

  public function saveEventList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['event_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Event->getPrimaryKeys();
    $values = $this->getValue('event_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Event', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Event', array_values($link));
    }
  }

  public function saveStructureList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['structure_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Structure->getPrimaryKeys();
    $values = $this->getValue('structure_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Structure', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Structure', array_values($link));
    }
  }

  public function saveProjetList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['projet_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Projet->getPrimaryKeys();
    $values = $this->getValue('projet_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Projet', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Projet', array_values($link));
    }
  }

}
