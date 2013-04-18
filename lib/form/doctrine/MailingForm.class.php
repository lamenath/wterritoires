<?php

class MailingForm extends BaseMailingForm {
		
	public function configure()
	{
		unset($this["id"]);

		$this->useFields(array('is_sent', "sujet", "message"));

		$this->setValidators(array(
			'sujet' => new sfValidatorString(array("required" => true, 'min_length' => 2, 'max_length' => 160)),
			'message' => new sfValidatorString(array('min_length' => 50, "required" => true)),
			'is_sent' => new sfValidatorBoolean(array("required" => false))
		));
		
		$this->widgetSchema["is_sent"]->setLabel("Protection 'Message envoyé' ?");

		$relations = array(
								"filiere_list" => array(
													"max" => 10,
													"min" => 1,
													"required" => false,
													"label" => "Filtrer par filière(s)",
													"input" => array( "curl" => "/json/cm", "count" => true, "display" => "Filiere"),
								),
		);

		foreach($relations as $cname => $config)
		{
			$this->widgetSchema[$cname] = new rrWidgetRelations(
					array('label' => $config["label"]),
					array("config" => $config["input"], "max" => $config["max"])
			);

			$this->validatorSchema[$cname] = new rrValidatorRelations($config);
		}
	}
}
