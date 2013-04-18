<?php

/**
 * Commune filter form base class.
 *
 * @package    rrr
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCommuneFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'pays_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Pays'), 'add_empty' => true)),
      'nom'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description' => new sfWidgetFormFilterInput(),
      'photo'       => new sfWidgetFormFilterInput(),
      'code_postal' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'code_insee'  => new sfWidgetFormFilterInput(),
      'slug'        => new sfWidgetFormFilterInput(),
      'latitude'    => new sfWidgetFormFilterInput(),
      'longitude'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'pays_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Pays'), 'column' => 'id')),
      'nom'         => new sfValidatorPass(array('required' => false)),
      'description' => new sfValidatorPass(array('required' => false)),
      'photo'       => new sfValidatorPass(array('required' => false)),
      'code_postal' => new sfValidatorPass(array('required' => false)),
      'code_insee'  => new sfValidatorPass(array('required' => false)),
      'slug'        => new sfValidatorPass(array('required' => false)),
      'latitude'    => new sfValidatorPass(array('required' => false)),
      'longitude'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('commune_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Commune';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'pays_id'     => 'ForeignKey',
      'nom'         => 'Text',
      'description' => 'Text',
      'photo'       => 'Text',
      'code_postal' => 'Text',
      'code_insee'  => 'Text',
      'slug'        => 'Text',
      'latitude'    => 'Text',
      'longitude'   => 'Text',
    );
  }
}
