<?php

class StructureContactFormFrontend extends BaseStructureContactForm
{
	public function configure() 
	{
		unset($this["id"]);
		
		$this->useFields(array('nom', 'prenom', 'fonction', 'mail', 'phone'));
		
		$this->setValidators(array(
			'nom' => new sfValidatorString(array('min_length' => 2, 'max_length' => 50)),
			'prenom' => new sfValidatorString(array('min_length' => 2, 'max_length' => 50)),
			'fonction' => new sfValidatorString(array('min_length' => 2, 'max_length' => 150)),
			'mail' => new sfValidatorEmail(),
			'phone' => new sfValidatorString()
		));
		
		// Set Labels
		$this->widgetSchema->setLabels(array(
					'phone'    => 'Téléphone',
					'mail'    => 'Adresse email',
					'prenom'    => 'Prénom',
					'nom' => "Nom de famille",
					'fonction' => "Fonction"
		));
	}

}
