<?php

/**
 * sfGuardPermissionUtf8 filter form base class.
 *
 * @package    rrr
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasesfGuardPermissionUtf8FormFilter extends sfGuardPermissionFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('sf_guard_permission_utf8_filters[%s]');
  }

  public function getModelName()
  {
    return 'sfGuardPermissionUtf8';
  }
}
