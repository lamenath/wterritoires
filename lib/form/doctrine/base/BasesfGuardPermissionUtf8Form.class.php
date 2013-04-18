<?php

/**
 * sfGuardPermissionUtf8 form base class.
 *
 * @method sfGuardPermissionUtf8 getObject() Returns the current form's model object
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasesfGuardPermissionUtf8Form extends sfGuardPermissionForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('sf_guard_permission_utf8[%s]');
  }

  public function getModelName()
  {
    return 'sfGuardPermissionUtf8';
  }

}
