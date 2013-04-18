<?php

/**
 * Projet form base class.
 *
 * @method Projet getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProjetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'createur_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'add_empty' => true)),
      'story_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story'), 'add_empty' => true)),
      'commune_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Commune'), 'add_empty' => true)),
      'type'                      => new sfWidgetFormChoice(array('choices' => array('public' => 'public', 'group' => 'group'))),
      'nom'                       => new sfWidgetFormInputText(),
      'action'                    => new sfWidgetFormChoice(array('choices' => array('regional' => 'regional', 'territorial' => 'territorial', 'local' => 'local', 'ultralocal' => 'ultralocal'))),
      'url'                       => new sfWidgetFormInputText(),
      'photo'                     => new sfWidgetFormInputText(),
      'photo_crop'                => new sfWidgetFormInputText(),
      'objectifs_qualitatif'      => new sfWidgetFormTextarea(),
      'objectifs_quantitatif'     => new sfWidgetFormTextarea(),
      'strategie'                 => new sfWidgetFormTextarea(),
      'resultats'                 => new sfWidgetFormTextarea(),
      'besoins'                   => new sfWidgetFormTextarea(),
      'lecons'                    => new sfWidgetFormTextarea(),
      'avancement'                => new sfWidgetFormInputText(),
      'date_debut'                => new sfWidgetFormDateTime(),
      'date_echeance'             => new sfWidgetFormDateTime(),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
      'slug'                      => new sfWidgetFormInputText(),
      'metier_list'               => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Metier')),
      'structure_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Structure')),
      'structure_partenaire_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Structure')),
      'filiere_list'              => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Filiere')),
      'theme_list'                => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Theme')),
      'competence_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Competence')),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'createur_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'required' => false)),
      'story_id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Story'), 'required' => false)),
      'commune_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Commune'), 'required' => false)),
      'type'                      => new sfValidatorChoice(array('choices' => array(0 => 'public', 1 => 'group'), 'required' => false)),
      'nom'                       => new sfValidatorString(array('max_length' => 255)),
      'action'                    => new sfValidatorChoice(array('choices' => array(0 => 'regional', 1 => 'territorial', 2 => 'local', 3 => 'ultralocal'), 'required' => false)),
      'url'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'photo'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'photo_crop'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'objectifs_qualitatif'      => new sfValidatorString(array('required' => false)),
      'objectifs_quantitatif'     => new sfValidatorString(array('required' => false)),
      'strategie'                 => new sfValidatorString(array('required' => false)),
      'resultats'                 => new sfValidatorString(array('required' => false)),
      'besoins'                   => new sfValidatorString(array('required' => false)),
      'lecons'                    => new sfValidatorString(array('required' => false)),
      'avancement'                => new sfValidatorInteger(array('required' => false)),
      'date_debut'                => new sfValidatorDateTime(array('required' => false)),
      'date_echeance'             => new sfValidatorDateTime(array('required' => false)),
      'created_at'                => new sfValidatorDateTime(),
      'updated_at'                => new sfValidatorDateTime(),
      'slug'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'metier_list'               => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Metier', 'required' => false)),
      'structure_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Structure', 'required' => false)),
      'structure_partenaire_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Structure', 'required' => false)),
      'filiere_list'              => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Filiere', 'required' => false)),
      'theme_list'                => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Theme', 'required' => false)),
      'competence_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Competence', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'Projet', 'column' => array('nom'))),
        new sfValidatorDoctrineUnique(array('model' => 'Projet', 'column' => array('slug'))),
      ))
    );

    $this->widgetSchema->setNameFormat('projet[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Projet';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['metier_list']))
    {
      $this->setDefault('metier_list', $this->object->Metier->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['structure_list']))
    {
      $this->setDefault('structure_list', $this->object->Structure->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['structure_partenaire_list']))
    {
      $this->setDefault('structure_partenaire_list', $this->object->StructurePartenaire->getPrimaryKeys());
    }

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

  }

  protected function doSave($con = null)
  {
    $this->saveMetierList($con);
    $this->saveStructureList($con);
    $this->saveStructurePartenaireList($con);
    $this->saveFiliereList($con);
    $this->saveThemeList($con);
    $this->saveCompetenceList($con);

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

  public function saveStructurePartenaireList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['structure_partenaire_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->StructurePartenaire->getPrimaryKeys();
    $values = $this->getValue('structure_partenaire_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('StructurePartenaire', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('StructurePartenaire', array_values($link));
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

}
