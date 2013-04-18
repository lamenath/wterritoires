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

class ProfilFrontendPrivacyIdentifiedForm extends BaseProfilForm
{
	public function configure()
	{
		unset($this["id"]);

		$this->useFields(array("privacy_type", "notify_new_item", "notify_comment"));

		$this->widgetSchema['privacy_type'] = new sfWidgetFormChoice(array('choices' => array('public' => 'Tout le monde', 'private' => 'Les membres du réseau', 'friends' => 'Seulement mes contacts')));

		$this->setValidators(array(
			'privacy_type' => new sfValidatorChoice(array('choices' => array(0 => 'private', 1 => 'public', 2 => 'friends'), 'required' => true)),
			'notify_new_item' => new sfValidatorBoolean(array("required" => false)),
			'notify_comment' => new sfValidatorBoolean(array("required" => false))
		));

		$this->widgetSchema->setLabels(array(
			'privacy_type'    => 'Qui peut voir mon profil ?',
			'notify_new_item'   => 'Notifications par email (message, invitation projet...)',
			'notify_comment'   => 'Notification en cas de commentaire',
		));
	}
}

?>