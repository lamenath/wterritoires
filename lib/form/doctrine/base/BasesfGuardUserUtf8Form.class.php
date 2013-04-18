<?php

/**
 * sfGuardUserUtf8 form base class.
 *
 * @method sfGuardUserUtf8 getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasesfGuardUserUtf8Form extends sfGuardUserForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('sf_guard_user_utf8[%s]');
  }

  public function getModelName()
  {
    return 'sfGuardUserUtf8';
  }

}
