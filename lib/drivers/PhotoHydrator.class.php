<?php

/**
	wTerritoires <http://www.wterritoires.fr/>
	Copyright (C) 2013 Simon Lamellière <opensource@worketer.fr>

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

class PhotoHydrator extends Doctrine_Hydrator_ArrayDriver
{
	static function hydrate($photo)
	{
		sfContext::getInstance()->getConfiguration()->loadHelpers('Date');

		// Relations ?
		if(isset($photo["PhotoProjet"]))
		{
			$block = true;
			$old = $photo;
			$photo = $photo["PhotoProjet"];
			$photo["extraData"] = $old;

			unset($old);
		}
		
		// ACL
		if(!isset($photo["ACL"]))
			$photo["ACL"] = PhotoACL::init($photo);

		// Set User images
		$photo["photo_mini"] = sfConfig::get("app_cdn_full") . ($photo["fichier"] ? "galerie/mini_" . $photo["fichier"] : "galerie/default.png");
		$photo["photo_std"] = sfConfig::get("app_cdn_full") . ($photo["fichier"] ? "galerie/std_" . $photo["fichier"] : "galerie/default.png");
		$photo["photo_max"] = sfConfig::get("app_cdn_full") . ($photo["fichier"] ? "galerie/max_" . $photo["fichier"] : "galerie/default.png");
		
		return $photo;
	}

	public function hydrateResultSet($stmt)
	{
		$photos = parent::hydrateResultSet($stmt);

		foreach($photos as &$photo)
		{
			$photo = self::hydrate($photo);
		}

		return $photos;
	}
}

?>