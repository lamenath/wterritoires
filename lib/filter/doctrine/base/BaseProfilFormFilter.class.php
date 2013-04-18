<?php

/**
 * Profil filter form base class.
 *
 * @package    rrr
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProfilFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom'                       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'prenom'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'adresse'                   => new sfWidgetFormFilterInput(),
      'ville'                     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'code_postal'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'                     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'presentation'              => new sfWidgetFormFilterInput(),
      'login'                     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'password'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'photo'                     => new sfWidgetFormFilterInput(),
      'photo_crop'                => new sfWidgetFormFilterInput(),
      'privacy_type'              => new sfWidgetFormChoice(array('choices' => array('' => '', 'private' => 'private', 'public' => 'public', 'friends' => 'friends'))),
      'notify_comment'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'notify_new_item'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'relance_count'             => new sfWidgetFormFilterInput(),
      'is_activated'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_public'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_admin'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'last_login'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'slug'                      => new sfWidgetFormFilterInput(),
      'latitude'                  => new sfWidgetFormFilterInput(),
      'longitude'                 => new sfWidgetFormFilterInput(),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
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
      'nom'                       => new sfValidatorPass(array('required' => false)),
      'prenom'                    => new sfValidatorPass(array('required' => false)),
      'adresse'                   => new sfValidatorPass(array('required' => false)),
      'ville'                     => new sfValidatorPass(array('required' => false)),
      'code_postal'               => new sfValidatorPass(array('required' => false)),
      'email'                     => new sfValidatorPass(array('required' => false)),
      'presentation'              => new sfValidatorPass(array('required' => false)),
      'login'                     => new sfValidatorPass(array('required' => false)),
      'password'                  => new sfValidatorPass(array('required' => false)),
      'photo'                     => new sfValidatorPass(array('required' => false)),
      'photo_crop'                => new sfValidatorPass(array('required' => false)),
      'privacy_type'              => new sfValidatorChoice(array('required' => false, 'choices' => array('private' => 'private', 'public' => 'public', 'friends' => 'friends'))),
      'notify_comment'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'notify_new_item'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'relance_count'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_activated'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_public'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_admin'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'last_login'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'                      => new sfValidatorPass(array('required' => false)),
      'latitude'                  => new sfValidatorPass(array('required' => false)),
      'longitude'                 => new sfValidatorPass(array('required' => false)),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
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

    $this->widgetSchema->setNameFormat('profil_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addMetierListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.ProfilMetier ProfilMetier')
      ->andWhereIn('ProfilMetier.metier_id', $values)
    ;
  }

  public function addProjetListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.ProfilProjet ProfilProjet')
      ->andWhereIn('ProfilProjet.projet_id', $values)
    ;
  }

  public function addThemeListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.ProfilTheme ProfilTheme')
      ->andWhereIn('ProfilTheme.theme_id', $values)
    ;
  }

  public function addCompetenceListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.ProfilCompetence ProfilCompetence')
      ->andWhereIn('ProfilCompetence.competence_id', $values)
    ;
  }

  public function addCompetenceRechercheListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.ProfilCompetenceRecherche ProfilCompetenceRecherche')
      ->andWhereIn('ProfilCompetenceRecherche.competence_id', $values)
    ;
  }

  public function addFiliereListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.ProfilFiliere ProfilFiliere')
      ->andWhereIn('ProfilFiliere.filiere_id', $values)
    ;
  }

  public function addExpertiseListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.ProfilExpertise ProfilExpertise')
      ->andWhereIn('ProfilExpertise.expertise_id', $values)
    ;
  }

  public function addStructureListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.ProfilStructure ProfilStructure')
      ->andWhereIn('ProfilStructure.structure_id', $values)
    ;
  }

  public function addEventListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.EventInvite EventInvite')
      ->andWhereIn('EventInvite.event_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Profil';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'nom'                       => 'Text',
      'prenom'                    => 'Text',
      'adresse'                   => 'Text',
      'ville'                     => 'Text',
      'code_postal'               => 'Text',
      'email'                     => 'Text',
      'presentation'              => 'Text',
      'login'                     => 'Text',
      'password'                  => 'Text',
      'photo'                     => 'Text',
      'photo_crop'                => 'Text',
      'privacy_type'              => 'Enum',
      'notify_comment'            => 'Boolean',
      'notify_new_item'           => 'Boolean',
      'relance_count'             => 'Number',
      'is_activated'              => 'Boolean',
      'is_public'                 => 'Boolean',
      'is_admin'                  => 'Boolean',
      'last_login'                => 'Date',
      'slug'                      => 'Text',
      'latitude'                  => 'Text',
      'longitude'                 => 'Text',
      'created_at'                => 'Date',
      'updated_at'                => 'Date',
      'metier_list'               => 'ManyKey',
      'projet_list'               => 'ManyKey',
      'theme_list'                => 'ManyKey',
      'competence_list'           => 'ManyKey',
      'competence_recherche_list' => 'ManyKey',
      'filiere_list'              => 'ManyKey',
      'expertise_list'            => 'ManyKey',
      'structure_list'            => 'ManyKey',
      'event_list'                => 'ManyKey',
    );
  }
}
