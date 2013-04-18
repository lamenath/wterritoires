<?php

/**
 * Metier filter form base class.
 *
 * @package    rrr
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMetierFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'    => new sfWidgetFormFilterInput(),
      'is_activated'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'slug'           => new sfWidgetFormFilterInput(),
      'profil_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Profil')),
      'segment_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Segment')),
      'annonce_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Annonce')),
      'event_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Event')),
      'structure_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Structure')),
      'projet_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Projet')),
    ));

    $this->setValidators(array(
      'nom'            => new sfValidatorPass(array('required' => false)),
      'description'    => new sfValidatorPass(array('required' => false)),
      'is_activated'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'           => new sfValidatorPass(array('required' => false)),
      'profil_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Profil', 'required' => false)),
      'segment_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Segment', 'required' => false)),
      'annonce_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Annonce', 'required' => false)),
      'event_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Event', 'required' => false)),
      'structure_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Structure', 'required' => false)),
      'projet_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Projet', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('metier_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addProfilListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('ProfilMetier.profil_id', $values)
    ;
  }

  public function addSegmentListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('SegmentMetier.segment_id', $values)
    ;
  }

  public function addAnnonceListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.AnnonceMetier AnnonceMetier')
      ->andWhereIn('AnnonceMetier.annonce_id', $values)
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
      ->leftJoin($query->getRootAlias().'.EventMetier EventMetier')
      ->andWhereIn('EventMetier.event_id', $values)
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
      ->leftJoin($query->getRootAlias().'.StructureMetier StructureMetier')
      ->andWhereIn('StructureMetier.structure_id', $values)
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
      ->leftJoin($query->getRootAlias().'.ProjetMetier ProjetMetier')
      ->andWhereIn('ProjetMetier.projet_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Metier';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'nom'            => 'Text',
      'description'    => 'Text',
      'is_activated'   => 'Boolean',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'slug'           => 'Text',
      'profil_list'    => 'ManyKey',
      'segment_list'   => 'ManyKey',
      'annonce_list'   => 'ManyKey',
      'event_list'     => 'ManyKey',
      'structure_list' => 'ManyKey',
      'projet_list'    => 'ManyKey',
    );
  }
}
