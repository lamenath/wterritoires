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

class rrValidatorRelations extends sfValidatorBase
{
	protected function configure($options = array(), $messages = array())
	{
		$this->addMessage('max', 'Veuillez indiquer moins de tags (%max% maximum).');
		$this->addMessage('min', 'Vous devez indiquer au minimum %min% tags.');
		$this->addMessage('cfg', 'Mauvaise configuration du validateur.');
		$this->addMessage('required', 'Mauvaise configuration du validateur.');

		$this->addOption('max');
		$this->addOption('min');
		$this->addOption('label');
		$this->addOption('input');
	}

	protected function doClean($value)
	{
		if (!is_array($value))
		{
			throw new sfValidatorError($this, 'Doit être un tableau de données.');
		}

		$length = count($value);

		if ($this->hasOption('max') && $length > $this->getOption('max'))
		{
			throw new sfValidatorError($this, 'max', array('value' => $value, 'max' => $this->getOption('max')));
		}

		if ($this->hasOption('min') && $length < $this->getOption('min'))
		{
			throw new sfValidatorError($this, 'min', array('value' => $value, 'min' => $this->getOption('min')));
		}

		return $value;
	}
}

?>