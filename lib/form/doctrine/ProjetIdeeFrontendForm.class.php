<?php

/***
	wTerritoires <http://www.wterritoires.fr/>
	Copyright (C) 2011 Simon Lamellière <opensource@worketer.fr>

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU Affero General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU Affero General Public License for more details.

	You should have received a copy of the GNU Affero General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
**/

class ProjetIdeeFrontendForm extends BaseProjetIdeeForm
{
	public function configure()
	{
		unset($this["id"]);

		$this->useFields(array('titre', 'message'));

		$this->setValidators(array(
			"titre" => new sfValidatorString(),
			'message' => new sfValidatorString(array('min_length' => 10, 'max_length' => 700))
			//'status' => new sfValidatorChoice(array("required" => false, "choices" => array("test" => "new", "prod", "acknowledged")))
		));

		$this->widgetSchema->setLabels(array(
									'titre'    => 'Titre de la discussion',
									'message'   => 'Texte'
		));
	}

	public function ignoreStatus()
	{
		unset($this["status"]);
	}

}
