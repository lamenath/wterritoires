<?php

/**
 * PhotoProjet
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class PhotoProjet extends BasePhotoProjet
{
	
	public function postInsert($values)
	{
		// Create Story
		if($this->get("projet_id"))
			Story::set_relation("Projet", $this->get("projet_id"));
		
		if($this->get("event_id"))
			Story::set_relation("Event", $this->get("event_id"));

		Story::publish(
					"photo",
					"PhotoProjet",
					$this->get("id"),
					sfContext::getInstance()->getUser()->getId(),
					"photo"
		);
	}
	
}
