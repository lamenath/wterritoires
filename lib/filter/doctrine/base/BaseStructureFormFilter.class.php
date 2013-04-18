<?php

/**
 * Structure filter form base class.
 *
 * @package    rrr
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseStructureFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'createur_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'add_empty' => true)),
      'nom'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'adresse'         => new sfWidgetFormFilterInput(),
      'adresse2'        => new sfWidgetFormFilterInput(),
      'ville'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'code_postal'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'code_insee'      => new sfWidgetFormFilterInput(),
      'tel'             => new sfWidgetFormFilterInput(),
      'mail'            => new sfWidgetFormFilterInput(),
      'photo'           => new sfWidgetFormFilterInput(),
      'photo_crop'      => new sfWidgetFormFilterInput(),
      'presentation'    => new sfWidgetFormFilterInput(),
      'missions'        => new sfWidgetFormFilterInput(),
      'but'             => new sfWidgetFormFilterInput(),
      'strategie'       => new sfWidgetFormFilterInput(),
      'url'             => new sfWidgetFormFilterInput(),
      'slug'            => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'latitude'        => new sfWidgetFormFilterInput(),
      'longitude'       => new sfWidgetFormFilterInput(),
      'metier_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Metier')),
      'theme_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Theme')),
      'competence_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Competence')),
      'filiere_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Filiere')),
      'event_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Event')),
      'projet_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Projet')),
    ));

    $this->setValidators(array(
      'createur_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Profil'), 'column' => 'id')),
      'nom'             => new sfValidatorPass(array('required' => false)),
      'adresse'         => new sfValidatorPass(array('required' => false)),
      'adresse2'        => new sfValidatorPass(array('required' => false)),
      'ville'           => new sfValidatorPass(array('required' => false)),
      'code_postal'     => new sfValidatorPass(array('required' => false)),
      'code_insee'      => new sfValidatorPass(array('required' => false)),
      'tel'             => new sfValidatorPass(array('required' => false)),
      'mail'            => new sfValidatorPass(array('required' => false)),
      'photo'           => new sfValidatorPass(array('required' => false)),
      'photo_crop'      => new sfValidatorPass(array('required' => false)),
      'presentation'    => new sfValidatorPass(array('required' => false)),
      'missions'        => new sfValidatorPass(array('required' => false)),
      'but'             => new sfValidatorPass(array('required' => false)),
      'strategie'       => new sfValidatorPass(array('required' => false)),
      'url'             => new sfValidatorPass(array('required' => false)),
      'slug'            => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'latitude'        => new sfValidatorPass(array('required' => false)),
      'longitude'       => new sfValidatorPass(array('required' => false)),
      'metier_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Metier', 'required' => false)),
      'theme_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Theme', 'required' => false)),
      'competence_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Competence', 'required' => false)),
      'filiere_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Filiere', 'required' => false)),
      'event_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Event', 'required' => false)),
      'projet_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Projet', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('structure_filters[%s]');

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
      ->leftJoin($query->getRootAlias().'.StructureMetier StructureMetier')
      ->andWhereIn('StructureMetier.metier_id', $values)
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
      ->leftJoin($query->getRootAlias().'.StructureTheme StructureTheme')
      ->andWhereIn('StructureTheme.theme_id', $values)
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
      ->leftJoin($query->getRootAlias().'.StructureCompetence StructureCompetence')
      ->andWhereIn('StructureCompetence.competence_id', $values)
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
      ->leftJoin($query->getRootAlias().'.StructureFiliere StructureFiliere')
      ->andWhereIn('StructureFiliere.filiere_id', $values)
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
      ->leftJoin($query->getRootAlias().'.EventStructure EventStructure')
      ->andWhereIn('EventStructure.event_id', $values)
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
      ->leftJoin($query->getRootAlias().'.ProjetStructure ProjetStructure')
      ->andWhereIn('ProjetStructure.projet_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Structure';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'createur_id'     => 'ForeignKey',
      'nom'             => 'Text',
      'adresse'         => 'Text',
      'adresse2'        => 'Text',
      'ville'           => 'Text',
      'code_postal'     => 'Text',
      'code_insee'      => 'Text',
      'tel'             => 'Text',
      'mail'            => 'Text',
      'photo'           => 'Text',
      'photo_crop'      => 'Text',
      'presentation'    => 'Text',
      'missions'        => 'Text',
      'but'             => 'Text',
      'strategie'       => 'Text',
      'url'             => 'Text',
      'slug'            => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'latitude'        => 'Text',
      'longitude'       => 'Text',
      'metier_list'     => 'ManyKey',
      'theme_list'      => 'ManyKey',
      'competence_list' => 'ManyKey',
      'filiere_list'    => 'ManyKey',
      'event_list'      => 'ManyKey',
      'projet_list'     => 'ManyKey',
    );
  }
}
