<?php

/**
 * Formulaire autonome d'inscription initiale
 *
 */

class ProfilFrontendForm extends BaseProfilForm
{
	public function configure()
	{
		unset($this["id"]);

		$this->useFields(array('email', "nom", "prenom", "login", "password", 'is_activated'));

		$this->setValidators(array(
			'email'   => new sfValidatorEmail(),
			'nom' => new sfValidatorString(array('min_length' => 2, 'max_length' => 30)),
			'prenom' => new sfValidatorString(array('min_length' => 2, 'max_length' => 30)),
			'login' => new sfValidatorAnd(array(new sfValidatorString(array('min_length' => 3, 'max_length' => 15)), new sfValidatorRegex(array('pattern' => '#^[\w\#\/]+$#ui'))) ),
			'password' => new sfValidatorString(array('min_length' => 6, 'max_length' => 20)),
			"is_activated" => new sfValidatorBoolean(array("required" => true)),
		));

		$this->widgetSchema["password"] = new sfWidgetFormInputPassword();
		
		$this->widgetSchema->setHelp('email', "Veuillez entrer une adresse email valide, nous vous enverrons un lien d'activation sur cette adresse.");
		$this->widgetSchema->setHelp('login', "Votre nom d'utilisateur peut être un raccourci de votre nom, exemple 'fdupont' pour François Dupont, ou bien un pseudonyme anonyme. Il ne doit pas contenir d'espaces ou de caractères spéciaux. Seul le underscore est accepté '_'.");

		$this->validatorSchema->setPreValidator(new sfValidatorAnd(array(
			new sfValidatorCallback(array('callback'=> array($this, 'checkEmailAvailability'))),
			new sfValidatorCallback(array('callback'=> array($this, 'checkUsernameAvailability')))
		)));
		
		$this->widgetSchema->setLabels(array(
			'nom'    => 'Nom',
			'prenom'   => 'Prénom',
			'email'   => 'Adresse email',
			'password' => 'Mot de passe',
			'login' => 'Nom d\'utilisateur',
			'is_activated' => "Acceptez-vous les conditions générales?"
		));
	}

	static function checkEmailAvailability($validator, $values)
	{
		if (!empty($values['email']))
		{
			$nbr = Doctrine_Query::create()
									->from('Profil u')
									->where("u.email = ?", (is_array($values) ? $values['email'] : $values))
									->count();

			if ($nbr==0) {
				return $values;
			} else {
				throw new sfValidatorError($validator, 'Cet email est déjà pris par un autre membre.');
			}
		}
	}

	static function checkUsernameAvailability($validator, $values)
	{
		if (!empty($values['login']))
		{
			$nbr = Doctrine_Query::create()
									->from('Profil u')
									->where("u.login = ?", $values['login'])
									->count();

			if ($nbr==0) {
				return $values;
			} else {
				throw new sfValidatorError($validator, "Ce nom d'utilisateur est déjà pris par quelqu'un.");
			}
		}
	}
}

?>