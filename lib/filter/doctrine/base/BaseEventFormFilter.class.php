<?php

/**
 * Event filter form base class.
 *
 * @package    rrr
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEventFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'createur_id'     => new sfWidgetFormFilterInput(),
      'story_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story'), 'add_empty' => true)),
      'titre'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'     => new sfWidgetFormFilterInput(),
      'photo'           => new sfWidgetFormFilterInput(),
      'contacts'        => new sfWidgetFormFilterInput(),
      'lieu'            => new sfWidgetFormFilterInput(),
      'adresse'         => new sfWidgetFormFilterInput(),
      'ville'           => new sfWidgetFormFilterInput(),
      'start_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'end_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'visibilite'      => new sfWidgetFormChoice(array('choices' => array('' => '', 'public' => 'public', 'private' => 'private'))),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'slug'            => new sfWidgetFormFilterInput(),
      'latitude'        => new sfWidgetFormFilterInput(),
      'longitude'       => new sfWidgetFormFilterInput(),
      'structure_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Structure')),
      'invite_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Profil')),
      'admin_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Profil')),
      'metier_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Metier')),
      'filiere_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Filiere')),
      'theme_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Theme')),
      'competence_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Competence')),
    ));

    $this->setValidators(array(
      'createur_id'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'story_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Story'), 'column' => 'id')),
      'titre'           => new sfValidatorPass(array('required' => false)),
      'description'     => new sfValidatorPass(array('required' => false)),
      'photo'           => new sfValidatorPass(array('required' => false)),
      'contacts'        => new sfValidatorPass(array('required' => false)),
      'lieu'            => new sfValidatorPass(array('required' => false)),
      'adresse'         => new sfValidatorPass(array('required' => false)),
      'ville'           => new sfValidatorPass(array('required' => false)),
      'start_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'end_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'visibilite'      => new sfValidatorChoice(array('required' => false, 'choices' => array('public' => 'public', 'private' => 'private'))),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'            => new sfValidatorPass(array('required' => false)),
      'latitude'        => new sfValidatorPass(array('required' => false)),
      'longitude'       => new sfValidatorPass(array('required' => false)),
      'structure_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Structure', 'required' => false)),
      'invite_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Profil', 'required' => false)),
      'admin_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Profil', 'required' => false)),
      'metier_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Metier', 'required' => false)),
      'filiere_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Filiere', 'required' => false)),
      'theme_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Theme', 'required' => false)),
      'competence_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Competence', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('event_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
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
      ->leftJoin($query->getRootAlias().'.EventStructure EventStructure')
      ->andWhereIn('EventStructure.structure_id', $values)
    ;
  }

  public function addInviteListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('EventInvite.profil_id', $values)
    ;
  }

  public function addAdminListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.EventAdmin EventAdmin')
      ->andWhereIn('EventAdmin.profil_id', $values)
    ;
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
      ->leftJoin($query->getRootAlias().'.EventMetier EventMetier')
      ->andWhereIn('EventMetier.metier_id', $values)
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
      ->leftJoin($query->getRootAlias().'.EventFiliere EventFiliere')
      ->andWhereIn('EventFiliere.filiere_id', $values)
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
      ->leftJoin($query->getRootAlias().'.EventTheme EventTheme')
      ->andWhereIn('EventTheme.theme_id', $values)
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
      ->leftJoin($query->getRootAlias().'.EventCompetence EventCompetence')
      ->andWhereIn('EventCompetence.competence_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Event';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'createur_id'     => 'Number',
      'story_id'        => 'ForeignKey',
      'titre'           => 'Text',
      'description'     => 'Text',
      'photo'           => 'Text',
      'contacts'        => 'Text',
      'lieu'            => 'Text',
      'adresse'         => 'Text',
      'ville'           => 'Text',
      'start_at'        => 'Date',
      'end_at'          => 'Date',
      'visibilite'      => 'Enum',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'slug'            => 'Text',
      'latitude'        => 'Text',
      'longitude'       => 'Text',
      'structure_list'  => 'ManyKey',
      'invite_list'     => 'ManyKey',
      'admin_list'      => 'ManyKey',
      'metier_list'     => 'ManyKey',
      'filiere_list'    => 'ManyKey',
      'theme_list'      => 'ManyKey',
      'competence_list' => 'ManyKey',
    );
  }
}
