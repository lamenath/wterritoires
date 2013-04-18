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

class rrWidgetSlider extends sfWidgetForm
{
	public function configure($options = array(), $attributes = array())
	{
		parent::configure($options, $attributes);

		$this->addOption('is_hidden');
		$this->addOption('type');

		$this->setOption('is_hidden', false);
		$this->setOption('type', 'hidden');
	}

	public function render($name, $value = null, $attributes = array(), $errors = array())
	{
		if($value == null)
			$value = 0;

		$md5 = md5(time());

		$html = '<div class="sider_'.$md5.'"></div>
				<div class="clear"></div>
				<div class="perc perc_'.$md5.'">'.$value.'%</div>
				 <script language="javascript">
					$(function() {
						$( ".sider_'.$md5.'" ).slider({
							value: $( \'input[name="'.$name.'"]\' ).val(),
							min: 0,
							max: 100,
							step: 5,
							slide: function( event, ui ) {
								$( \'input[name="'.$name.'"]\' ).val(ui.value);
								$( \'.perc_'.$md5.'\' ).html(ui.value+"%");
							}
						});
					});
					</script>';

		return $this->renderTag('input', array_merge(array('type' => $this->getOption('type'), 'name' => $name, 'value' => $value), $attributes)) . $html;
	}
}

?>