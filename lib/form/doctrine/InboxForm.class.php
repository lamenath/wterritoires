<?php

/**
 * Messagerie form.
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class InboxForm extends BaseMessagerieForm
{
	public function configure()
	{
		unset($this["id"]);

		$this->useFields(array('sujet', 'message'));

		$this->setValidators(array(
			"sujet" => new sfValidatorString(),
			'message' => new sfValidatorString(array('min_length' => 10))
		));

		$this->widgetSchema->setLabels(array(
									'sujet'    => 'Sujet du message',
									'message'   => 'Message'
		));
	}

}
