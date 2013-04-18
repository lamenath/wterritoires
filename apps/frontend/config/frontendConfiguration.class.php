<?php

/**
   wTerritoires <http://www.wterritoires.fr/>
   Copyright (C) 2010 Simon Lamellière <opensource@worketer.fr>

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

class frontendConfiguration extends sfApplicationConfiguration
{
	public function configure()
	{

	}

	public function configureDoctrine(Doctrine_Manager $manager) {

		$servers = array(
				'host' => 'localhost',
				'port' => 11211,
				'persistent' => true
		);


		$cacheDriver = new Doctrine_Cache_Memcache(array(
				'servers' => $servers,
				'compression' => false
			)
		);

		//enable Doctrine cache
		$manager = Doctrine_Manager::getInstance();
		$manager->setAttribute(Doctrine::ATTR_RESULT_CACHE_LIFESPAN, 1000);
		$manager->setAttribute(Doctrine::ATTR_RESULT_CACHE, $cacheDriver);

		$manager->registerHydrator('project', 'ProjectHydrator');
		$manager->registerHydrator('event', 'EventHydrator');
		$manager->registerHydrator('photo', 'PhotoHydrator');
		$manager->registerHydrator('event_light', 'EventLightHydrator');
		$manager->registerHydrator('idea', 'IdeaHydrator');
		$manager->registerHydrator('structure', 'StructureHydrator');
		$manager->registerHydrator('profile', 'ProfileHydrator');
		$manager->registerHydrator('profile_light', 'ProfileLightHydrator');
		$manager->registerHydrator('project_light', 'ProjectLightHydrator');
		$manager->registerHydrator('commentaire', 'CommentaireHydrator');
	}
}

?>