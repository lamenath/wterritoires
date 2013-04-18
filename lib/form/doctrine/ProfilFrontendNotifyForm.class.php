<?php

/**
 * Profil form.
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 * PART 1
 */
class ProfilFrontendNotifyForm extends BaseProfilForm
{
  public function configure()
  {
  	unset($this["id"]);
  	
  	$this->useFields(array("notify_comment", "notify_new_item"));
  	

  }
}
