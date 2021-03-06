<?php

/**
 * Event
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Event extends BaseEvent
{
	public function postInsert($values)
	{
		// Create Story
		Story::publish(
				"default",
				"Event",
				$this->get("id"),
				sfContext::getInstance()->getUser()->getId(),
				"create",
				"",
				array()
		);
	}

	public function postDelete($values)
	{
		// Remove all stories from this project
		Story::erase_all(
					"Event",
					$this->get("id")
		);
	}
	
	public function __toString()
	{
		return $this->getTitre();
	}
}
