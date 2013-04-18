<?php

/**
 * Story filter form base class.
 *
 * @package    rrr
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseStoryFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'profil_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'add_empty' => true)),
      'object_id'      => new sfWidgetFormFilterInput(),
      'object_model'   => new sfWidgetFormFilterInput(),
      'relation_id'    => new sfWidgetFormFilterInput(),
      'relation_model' => new sfWidgetFormFilterInput(),
      'story_i18n'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'type'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'url'            => new sfWidgetFormFilterInput(),
      'params'         => new sfWidgetFormFilterInput(),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'buddies_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Profil')),
    ));

    $this->setValidators(array(
      'profil_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Profil'), 'column' => 'id')),
      'object_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'object_model'   => new sfValidatorPass(array('required' => false)),
      'relation_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'relation_model' => new sfValidatorPass(array('required' => false)),
      'story_i18n'     => new sfValidatorPass(array('required' => false)),
      'type'           => new sfValidatorPass(array('required' => false)),
      'url'            => new sfValidatorPass(array('required' => false)),
      'params'         => new sfValidatorPass(array('required' => false)),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'buddies_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Profil', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('story_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addBuddiesListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.StoryBuddies StoryBuddies')
      ->andWhereIn('StoryBuddies.profil_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Story';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'profil_id'      => 'ForeignKey',
      'object_id'      => 'Number',
      'object_model'   => 'Text',
      'relation_id'    => 'Number',
      'relation_model' => 'Text',
      'story_i18n'     => 'Text',
      'type'           => 'Text',
      'url'            => 'Text',
      'params'         => 'Text',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'buddies_list'   => 'ManyKey',
    );
  }
}
