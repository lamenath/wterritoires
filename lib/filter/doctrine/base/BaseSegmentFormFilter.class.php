<?php

/**
 * Segment filter form base class.
 *
 * @package    rrr
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSegmentFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'localite'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'latitude'        => new sfWidgetFormFilterInput(),
      'longitude'       => new sfWidgetFormFilterInput(),
      'metier_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Metier')),
      'theme_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Theme')),
      'competence_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Competence')),
      'filiere_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Filiere')),
      'mailing_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Mailing')),
    ));

    $this->setValidators(array(
      'nom'             => new sfValidatorPass(array('required' => false)),
      'localite'        => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'latitude'        => new sfValidatorPass(array('required' => false)),
      'longitude'       => new sfValidatorPass(array('required' => false)),
      'metier_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Metier', 'required' => false)),
      'theme_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Theme', 'required' => false)),
      'competence_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Competence', 'required' => false)),
      'filiere_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Filiere', 'required' => false)),
      'mailing_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Mailing', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('segment_filters[%s]');

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
      ->leftJoin($query->getRootAlias().'.SegmentMetier SegmentMetier')
      ->andWhereIn('SegmentMetier.metier_id', $values)
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
      ->leftJoin($query->getRootAlias().'.SegmentTheme SegmentTheme')
      ->andWhereIn('SegmentTheme.theme_id', $values)
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
      ->leftJoin($query->getRootAlias().'.SegmentCompetence SegmentCompetence')
      ->andWhereIn('SegmentCompetence.competence_id', $values)
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
      ->leftJoin($query->getRootAlias().'.SegmentFiliere SegmentFiliere')
      ->andWhereIn('SegmentFiliere.filiere_id', $values)
    ;
  }

  public function addMailingListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.MailingSegment MailingSegment')
      ->andWhereIn('MailingSegment.mailing_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Segment';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'nom'             => 'Text',
      'localite'        => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'latitude'        => 'Text',
      'longitude'       => 'Text',
      'metier_list'     => 'ManyKey',
      'theme_list'      => 'ManyKey',
      'competence_list' => 'ManyKey',
      'filiere_list'    => 'ManyKey',
      'mailing_list'    => 'ManyKey',
    );
  }
}
