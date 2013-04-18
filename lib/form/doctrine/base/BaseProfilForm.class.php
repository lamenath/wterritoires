<?php

/**
 * Profil form base class.
 *
 * @method Profil getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProfilForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'nom'                       => new sfWidgetFormInputText(),
      'prenom'                    => new sfWidgetFormInputText(),
      'adresse'                   => new sfWidgetFormInputText(),
      'ville'                     => new sfWidgetFormInputText(),
      'code_postal'               => new sfWidgetFormInputText(),
      'email'                     => new sfWidgetFormInputText(),
      'presentation'              => new sfWidgetFormTextarea(),
      'login'                     => new sfWidgetFormInputText(),
      'password'                  => new sfWidgetFormInputText(),
      'photo'                     => new sfWidgetFormInputText(),
      'photo_crop'                => new sfWidgetFormInputText(),
      'privacy_type'              => new sfWidgetFormChoice(array('choices' => array('private' => 'private', 'public' => 'public', 'friends' => 'friends'))),
      'notify_comment'            => new sfWidgetFormInputCheckbox(),
      'notify_new_item'           => new sfWidgetFormInputCheckbox(),
      'relance_count'             => new sfWidgetFormInputText(),
      'is_activated'              => new sfWidgetFormInputCheckbox(),
      'is_public'                 => new sfWidgetFormInputCheckbox(),
      'is_admin'                  => new sfWidgetFormInputCheckbox(),
      'last_login'                => new sfWidgetFormDateTime(),
      'slug'                      => new sfWidgetFormInputText(),
      'latitude'                  => new sfWidgetFormInputText(),
      'longitude'                 => new sfWidgetFormInputText(),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
      'metier_list'               => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Metier')),
      'projet_list'               => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Projet')),
      'theme_list'                => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Theme')),
      'competence_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Competence')),
      'competence_recherche_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Competence')),
      'filiere_list'              => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Filiere')),
      'expertise_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Expertise')),
      'structure_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Structure')),
      'event_list'                => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Event')),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nom'                       => new sfValidatorString(array('max_length' => 255)),
      'prenom'                    => new sfValidatorString(array('max_length' => 255)),
      'adresse'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ville'                     => new sfValidatorString(array('max_length' => 255)),
      'code_postal'               => new sfValidatorString(array('max_length' => 10)),
      'email'                     => new sfValidatorString(array('max_length' => 255)),
      'presentation'              => new sfValidatorString(array('required' => false)),
      'login'                     => new sfValidatorString(array('max_length' => 25)),
      'password'                  => new sfValidatorString(array('max_length' => 100)),
      'photo'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'photo_crop'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'privacy_type'              => new sfValidatorChoice(array('choices' => array(0 => 'private', 1 => 'public', 2 => 'friends'), 'required' => false)),
      'notify_comment'            => new sfValidatorBoolean(array('required' => false)),
      'notify_new_item'           => new sfValidatorBoolean(array('required' => false)),
      'relance_count'             => new sfValidatorInteger(array('required' => false)),
      'is_activated'              => new sfValidatorBoolean(array('required' => false)),
      'is_public'                 => new sfValidatorBoolean(array('required' => false)),
      'is_admin'                  => new sfValidatorBoolean(array('required' => false)),
      'last_login'                => new sfValidatorDateTime(array('required' => false)),
      'slug'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'latitude'                  => new sfValidatorPass(array('required' => false)),
      'longitude'                 => new sfValidatorPass(array('required' => false)),
      'created_at'                => new sfValidatorDateTime(),
      'updated_at'                => new sfValidatorDateTime(),
      'metier_list'               => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Metier', 'required' => false)),
      'projet_list'               => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Projet', 'required' => false)),
      'theme_list'                => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Theme', 'required' => false)),
      'competence_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Competence', 'required' => false)),
      'competence_recherche_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Competence', 'required' => false)),
      'filiere_list'              => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Filiere', 'required' => false)),
      'expertise_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Expertise', 'required' => false)),
      'structure_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Structure', 'required' => false)),
      'event_list'                => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Event', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'Profil', 'column' => array('email'))),
        new sfValidatorDoctrineUnique(array('model' => 'Profil', 'column' => array('login'))),
        new sfValidatorDoctrineUnique(array('model' => 'Profil', 'column' => array('slug', 'login', 'email'))),
      ))
    );

    $this->widgetSchema->setNameFormat('profil[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Profil';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['metier_list']))
    {
      $this->setDefault('metier_list', $this->object->Metier->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['projet_list']))
    {
      $this->setDefault('projet_list', $this->object->Projet->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['theme_list']))
    {
      $this->setDefault('theme_list', $this->object->Theme->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['competence_list']))
    {
      $this->setDefault('competence_list', $this->object->Competence->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['competence_recherche_list']))
    {
      $this->setDefault('competence_recherche_list', $this->object->CompetenceRecherche->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['filiere_list']))
    {
      $this->setDefault('filiere_list', $this->object->Filiere->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['expertise_list']))
    {
      $this->setDefault('expertise_list', $this->object->Expertise->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['structure_list']))
    {
      $this->setDefault('structure_list', $this->object->Structure->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['event_list']))
    {
      $this->setDefault('event_list', $this->object->Event->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveMetierList($con);
    $this->saveProjetList($con);
    $this->saveThemeList($con);
    $this->saveCompetenceList($con);
    $this->saveCompetenceRechercheList($con);
    $this->saveFiliereList($con);
    $this->saveExpertiseList($con);
    $this->saveStructureList($con);
    $this->saveEventList($con);

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

  public function saveCompetenceRechercheList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['competence_recherche_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->CompetenceRecherche->getPrimaryKeys();
    $values = $this->getValue('competence_recherche_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('CompetenceRecherche', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('CompetenceRecherche', array_values($link));
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

  public function saveExpertiseList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['expertise_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Expertise->getPrimaryKeys();
    $values = $this->getValue('expertise_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Expertise', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Expertise', array_values($link));
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

}
