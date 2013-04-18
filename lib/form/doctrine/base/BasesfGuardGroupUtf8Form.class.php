<?php

/**
 * sfGuardGroupUtf8 form base class.
 *
 * @method sfGuardGroupUtf8 getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasesfGuardGroupUtf8Form extends sfGuardGroupForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('sf_guard_group_utf8[%s]');
  }

  public function getModelName()
  {
    return 'sfGuardGroupUtf8';
  }

}
