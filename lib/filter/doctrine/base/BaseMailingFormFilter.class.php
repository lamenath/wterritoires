<?php

/**
 * Mailing filter form base class.
 *
 * @package    rrr
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMailingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'sujet'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'message'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_sent'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'segment_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Segment')),
      'filiere_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Filiere')),
    ));

    $this->setValidators(array(
      'sujet'        => new sfValidatorPass(array('required' => false)),
      'message'      => new sfValidatorPass(array('required' => false)),
      'is_sent'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'segment_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Segment', 'required' => false)),
      'filiere_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Filiere', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mailing_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
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
      ->leftJoin($query->getRootAlias().'.MailingSegment MailingSegment')
      ->andWhereIn('MailingSegment.segment_id', $values)
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
      ->leftJoin($query->getRootAlias().'.MailingFiliere MailingFiliere')
      ->andWhereIn('MailingFiliere.filiere_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Mailing';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'sujet'        => 'Text',
      'message'      => 'Text',
      'is_sent'      => 'Boolean',
      'created_at'   => 'Date',
      'updated_at'   => 'Date',
      'segment_list' => 'ManyKey',
      'filiere_list' => 'ManyKey',
    );
  }
}
