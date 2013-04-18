<?php

/**
 * MailingSegment form base class.
 *
 * @method MailingSegment getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMailingSegmentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'segment_id' => new sfWidgetFormInputHidden(),
      'mailing_id' => new sfWidgetFormInputHidden(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'segment_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('segment_id')), 'empty_value' => $this->getObject()->get('segment_id'), 'required' => false)),
      'mailing_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('mailing_id')), 'empty_value' => $this->getObject()->get('mailing_id'), 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('mailing_segment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MailingSegment';
  }

}
