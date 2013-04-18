<?php

/**
 * HomeNews filter form base class.
 *
 * @package    rrr
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseHomeNewsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'photo'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'titre'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'text'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'titre_lien' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'photo'      => new sfValidatorPass(array('required' => false)),
      'titre'      => new sfValidatorPass(array('required' => false)),
      'text'       => new sfValidatorPass(array('required' => false)),
      'titre_lien' => new sfValidatorPass(array('required' => false)),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('home_news_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'HomeNews';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'photo'      => 'Text',
      'titre'      => 'Text',
      'text'       => 'Text',
      'titre_lien' => 'Text',
      'created_at' => 'Date',
      'updated_at' => 'Date',
    );
  }
}
