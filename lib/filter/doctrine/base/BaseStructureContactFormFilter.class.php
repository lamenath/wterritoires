<?php

/**
 * StructureContact filter form base class.
 *
 * @package    rrr
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseStructureContactFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'structure_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Structure'), 'add_empty' => true)),
      'profil_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'add_empty' => true)),
      'civilite'     => new sfWidgetFormChoice(array('choices' => array('' => '', 'm' => 'm', 'melle' => 'melle', 'mme' => 'mme'))),
      'nom'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'prenom'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fonction'     => new sfWidgetFormFilterInput(),
      'mail'         => new sfWidgetFormFilterInput(),
      'phone'        => new sfWidgetFormFilterInput(),
      'requalif'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'structure_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Structure'), 'column' => 'id')),
      'profil_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Profil'), 'column' => 'id')),
      'civilite'     => new sfValidatorChoice(array('required' => false, 'choices' => array('m' => 'm', 'melle' => 'melle', 'mme' => 'mme'))),
      'nom'          => new sfValidatorPass(array('required' => false)),
      'prenom'       => new sfValidatorPass(array('required' => false)),
      'fonction'     => new sfValidatorPass(array('required' => false)),
      'mail'         => new sfValidatorPass(array('required' => false)),
      'phone'        => new sfValidatorPass(array('required' => false)),
      'requalif'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('structure_contact_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StructureContact';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'structure_id' => 'ForeignKey',
      'profil_id'    => 'ForeignKey',
      'civilite'     => 'Enum',
      'nom'          => 'Text',
      'prenom'       => 'Text',
      'fonction'     => 'Text',
      'mail'         => 'Text',
      'phone'        => 'Text',
      'requalif'     => 'Boolean',
      'created_at'   => 'Date',
      'updated_at'   => 'Date',
    );
  }
}
