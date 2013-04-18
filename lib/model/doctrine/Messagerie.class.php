<?php

/**
 * Messagerie
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Messagerie extends BaseMessagerie 
{
	public function postInsert($event)
	{
		rMail::create($this->get("profil_id"), "", "inbox", array("subject" => $this->get("sujet"), "message" => $this->get("message"), "sender" => sfContext::getInstance()->getUser()->getObject()->__toString()), true)
				->send();
	}
	
}