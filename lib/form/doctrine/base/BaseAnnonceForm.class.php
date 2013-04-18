<?php

/**
 * Annonce form base class.
 *
 * @method Annonce getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAnnonceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'createur_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'add_empty' => true)),
      'story_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story'), 'add_empty' => true)),
      'projet_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Projet'), 'add_empty' => true)),
      'categorie_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AnnonceCategorie'), 'add_empty' => true)),
      'structure_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Structure'), 'add_empty' => true)),
      'type'            => new sfWidgetFormChoice(array('choices' => array('offre' => 'offre', 'demande' => 'demande'))),
      'titre'           => new sfWidgetFormInputText(),
      'description'     => new sfWidgetFormTextarea(),
      'ville'           => new sfWidgetFormInputText(),
      'photo'           => new sfWidgetFormInputText(),
      'slug'            => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'filiere_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Filiere')),
      'theme_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Theme')),
      'competence_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Competence')),
      'metier_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Metier')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'createur_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'required' => false)),
      'story_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Story'), 'required' => false)),
      'projet_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Projet'), 'required' => false)),
      'categorie_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AnnonceCategorie'), 'required' => false)),
      'structure_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Structure'), 'required' => false)),
      'type'            => new sfValidatorChoice(array('choices' => array(0 => 'offre', 1 => 'demande'), 'required' => false)),
      'titre'           => new sfValidatorString(array('max_length' => 255)),
      'description'     => new sfValidatorString(array('required' => false)),
      'ville'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'photo'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slug'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
      'filiere_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Filiere', 'required' => false)),
      'theme_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Theme', 'required' => false)),
      'competence_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Competence', 'required' => false)),
      'metier_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Metier', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Annonce', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('annonce[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Annonce';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['filiere_list']))
    {
      $this->setDefault('filiere_list', $this->object->Filiere->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['theme_list']))
    {
      $this->setDefault('theme_list', $this->object->Theme->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['competence_list']))
    {
      $this->setDefault('competence_list', $this->object->Competence->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['metier_list']))
    {
      $this->setDefault('metier_list', $this->object->Metier->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveFiliereList($con);
    $this->saveThemeList($con);
    $this->saveCompetenceList($con);
    $this->saveMetierList($con);

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

}
