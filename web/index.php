<?php

/**
   wTerritoires <http://www.wterritoires.fr/>
   Copyright (C) 2010 Simon Lamellière <opensource@worketer.fr>

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as
   published by the Free Software Foundation, either version 3 of the
   License, or (at your option) any later version.
**/

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

if($_SERVER["HTTP_HOST"] == "bo.reseau-rural-picardie.fr")
{
	$configuration = ProjectConfiguration::getApplicationConfiguration('backend', 'prod', false);
	sfContext::createInstance($configuration)->dispatch();
}
else
{
	$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', false);
	sfContext::createInstance($configuration)->dispatch();
}
