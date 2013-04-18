<?php

/**
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

class SegmentForm extends BaseSegmentForm
{
	public function configure()
	{
		unset($this["id"]);

		$this->useFields(array("nom", "localite", "filiere_list", "theme_list", "competence_list", "metier_list"));

		$this->setValidators(array(
			'nom' => new sfValidatorString(array("required" => true, 'min_length' => 2, 'max_length' => 30)),
			'localite' => new sfValidatorString(array('min_length' => 2, "required" => false)),
		));
		
		$relations = array(
								"metier_list" => array(
													"max" => 10,
													"min" => 1,
													"required" => false,
													"label" => "Métiers",
													"input" => array( "display" => "Metier"),
								),
								"competence_list" => array(
													"max" => 10,
													"min" => 1,
													"required" => false,
													"label" => "Compétences",
													"input" => array( "display" => "Competence"),
								),
								"filiere_list" => array(
													"max" => 10,
													"min" => 1,
													"required" => false,
													"label" => "Filières",
													"input" => array( "display" => "Filiere"),
													),
								"theme_list" => array(
													"max" => 10,
													"min" => 1,
													"required" => false,
													"label" => "Thèmes",
													"input" => array( "display" => "Theme"),
													)
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
