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

class rrWidgetRelations extends sfWidgetForm
{
	public function configure($options = array(), $attributes = array())
	{
	}

	public function render($name, $value = null, $attributes = array(), $errors = array())
	{
		$config = $this->getAttribute("config");
		$template = '<label class="ajax-f">%s <img src="/images/close_tick_t.png" class="closer"><input type="hidden" name="%s" value="%s"></label>';
		$values = "";
		$maxreached = false;
		$clean_name = preg_replace("/\]/ui", "", preg_replace("/\[/ui", "_", $name));
		$eid = (isset($attributes["eid"]) ? $attributes["eid"] : "");

		if(is_array($value))
		{
			$maxreached = ($attributes["max"] <= count($value) ? true : false);

			foreach((array)$value as $val)
			{
				$fname = Doctrine::getTable($config['display'])->find($val);
				$values .= sprintf($template , $fname, $name."[]", $val);
			}
		}
		else
		{
			if($value)
			{
				$maxreached = true;

				$fname = Doctrine::getTable($config['display'])->find($value);
				$values .= sprintf($template , $fname, $name, $value);
			}
		}

		if(isset($attributes["simple"]))
		{
			return '<input style="'.($maxreached ? "display:none" : "").'" type="text" id="'.$clean_name.'" name="'.$clean_name.'" class="'.$clean_name.' auto-complete" data-simple="1" data-eid="'.$eid.'"  data-max-choices="'.$attributes["max"].'" data-field-name="'.$name.'" data-class="'.$config['display'].'">
							<div class="solo salad-ac">
								<div class="salad">'.$values.'</div>
								<div class="source">
									'.$template.'
								</div>
								<div class="clear"></div>
							</div>';
		}
		else
		{
			return '<input style="'.($maxreached ? "display:none" : "").'" type="text" id="'.$clean_name.'" name="'.$clean_name.'" class="'.$clean_name.' auto-complete" data-max-choices="'.$attributes["max"].'" data-eid="'.$eid.'" data-field-name="'.$name.'[]" data-class="'.$config['display'].'">
							<div class="salad-ac">
								<div class="salad">'.$values.'</div>
								<div class="source">
									'.$template.'
								</div>
								<div class="clear"></div>
								'.(isset($config["count"]) ? '<div data-url="'.$config["curl"].'" class="counter"></div>' : "").'
								<div class="clear"></div>
							</div>';
		}
	}
}

?>