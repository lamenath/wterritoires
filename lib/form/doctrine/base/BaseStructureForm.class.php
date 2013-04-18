<?php

/**
 * Structure form base class.
 *
 * @method Structure getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStructureForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'createur_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'add_empty' => true)),
      'nom'             => new sfWidgetFormInputText(),
      'adresse'         => new sfWidgetFormInputText(),
      'adresse2'        => new sfWidgetFormInputText(),
      'ville'           => new sfWidgetFormInputText(),
      'code_postal'     => new sfWidgetFormInputText(),
      'code_insee'      => new sfWidgetFormInputText(),
      'tel'             => new sfWidgetFormInputText(),
      'mail'            => new sfWidgetFormInputText(),
      'photo'           => new sfWidgetFormInputText(),
      'photo_crop'      => new sfWidgetFormInputText(),
      'presentation'    => new sfWidgetFormTextarea(),
      'missions'        => new sfWidgetFormTextarea(),
      'but'             => new sfWidgetFormTextarea(),
      'strategie'       => new sfWidgetFormTextarea(),
      'url'             => new sfWidgetFormInputText(),
      'slug'            => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'latitude'        => new sfWidgetFormInputText(),
      'longitude'       => new sfWidgetFormInputText(),
      'metier_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Metier')),
      'theme_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Theme')),
      'competence_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Competence')),
      'filiere_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Filiere')),
      'event_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Event')),
      'projet_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Projet')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'createur_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'required' => false)),
      'nom'             => new sfValidatorString(array('max_length' => 255)),
      'adresse'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'adresse2'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ville'           => new sfValidatorString(array('max_length' => 255)),
      'code_postal'     => new sfValidatorString(array('max_length' => 10)),
      'code_insee'      => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'tel'             => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'mail'            => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'photo'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'photo_crop'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'presentation'    => new sfValidatorString(array('required' => false)),
      'missions'        => new sfValidatorString(array('required' => false)),
      'but'             => new sfValidatorString(array('required' => false)),
      'strategie'       => new sfValidatorString(array('required' => false)),
      'url'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slug'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
      'latitude'        => new sfValidatorPass(array('required' => false)),
      'longitude'       => new sfValidatorPass(array('required' => false)),
      'metier_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Metier', 'required' => false)),
      'theme_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Theme', 'required' => false)),
      'competence_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Competence', 'required' => false)),
      'filiere_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Filiere', 'required' => false)),
      'event_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Event', 'required' => false)),
      'projet_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Projet', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Structure', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('structure[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Structure';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['metier_list']))
    {
      $this->setDefault('metier_list', $this->object->Metier->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['theme_list']))
    {
      $this->setDefault('theme_list', $this->object->Theme->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['competence_list']))
    {
      $this->setDefault('competence_list', $this->object->Competence->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['filiere_list']))
    {
      $this->setDefault('filiere_list', $this->object->Filiere->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['event_list']))
    {
      $this->setDefault('event_list', $this->object->Event->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['projet_list']))
    {
      $this->setDefault('projet_list', $this->object->Projet->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveMetierList($con);
    $this->saveThemeList($con);
    $this->saveCompetenceList($con);
    $this->saveFiliereList($con);
    $this->saveEventList($con);
    $this->saveProjetList($con);

    parent::doSave($con);
  }

  public function saveMetierList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['metier_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Metier->getPrimaryKeys();
    $values = $this->getValue('metier_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Metier', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Metier', array_values($link));
    }
  }

  public function saveThemeList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['theme_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Theme->getPrimaryKeys();
    $values = $this->getValue('theme_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Theme', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Theme', array_values($link));
    }
  }

  public function saveCompetenceList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['competence_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Competence->getPrimaryKeys();
    $values = $this->getValue('competence_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Competence', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Competence', array_values($link));
    }
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
