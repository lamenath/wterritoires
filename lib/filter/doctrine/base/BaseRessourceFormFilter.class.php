<?php

/**
 * Ressource filter form base class.
 *
 * @package    rrr
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseRessourceFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'createur_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'add_empty' => true)),
      'story_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story'), 'add_empty' => true)),
      'projet_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Projet'), 'add_empty' => true)),
      'event_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Event'), 'add_empty' => true)),
      'nom'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'resume'       => new sfWidgetFormFilterInput(),
      'fichier'      => new sfWidgetFormFilterInput(),
      'video'        => new sfWidgetFormFilterInput(),
      'source'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'slug'         => new sfWidgetFormFilterInput(),
      'filiere_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Filiere')),
      'theme_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Theme')),
    ));

    $this->setValidators(array(
      'createur_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Profil'), 'column' => 'id')),
      'story_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Story'), 'column' => 'id')),
      'projet_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Projet'), 'column' => 'id')),
      'event_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Event'), 'column' => 'id')),
      'nom'          => new sfValidatorPass(array('required' => false)),
      'resume'       => new sfValidatorPass(array('required' => false)),
      'fichier'      => new sfValidatorPass(array('required' => false)),
      'video'        => new sfValidatorPass(array('required' => false)),
      'source'       => new sfValidatorPass(array('required' => false)),
      'date'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'         => new sfValidatorPass(array('required' => false)),
      'filiere_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Filiere', 'required' => false)),
      'theme_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Theme', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ressource_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
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
      ->leftJoin($query->getRootAlias().'.RessourceFiliere RessourceFiliere')
      ->andWhereIn('RessourceFiliere.filiere_id', $values)
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
      ->leftJoin($query->getRootAlias().'.RessourceTheme RessourceTheme')
      ->andWhereIn('RessourceTheme.theme_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Ressource';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'createur_id'  => 'ForeignKey',
      'story_id'     => 'ForeignKey',
      'projet_id'    => 'ForeignKey',
      'event_id'     => 'ForeignKey',
      'nom'          => 'Text',
      'resume'       => 'Text',
      'fichier'      => 'Text',
      'video'        => 'Text',
      'source'       => 'Text',
      'date'         => 'Date',
      'created_at'   => 'Date',
      'updated_at'   => 'Date',
      'slug'         => 'Text',
      'filiere_list' => 'ManyKey',
      'theme_list'   => 'ManyKey',
    );
  }
}
