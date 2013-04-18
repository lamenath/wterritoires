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

class sfMemcache extends Memcache
{
  static private $instance = null;

  private function __construct()
  {
    $this->initialize();
  }

  static public function getInstance()
  {
    if(!self::$instance)
    {
      self::$instance = new sfMemcache();
    }

    return self::$instance;
  }

  private function initialize()
  {
    $this->options = sfConfig::get('app_memcache', array());

    // START: taken from sfMemcacheCache::initialize
    if ($this->getOption('servers'))
    {
      foreach ($this->getOption('servers') as $server)
      {
        $port = isset($server['port']) ? $server['port'] : 11211;
        if (!$this->addServer($server['host'], $port, isset($server['persistent']) ? $server['persistent'] : true))
        {
          throw new sfInitializationException(sprintf('Unable to connect to the memcache server (%s:%s).', $server['host'], $port));
        }
      }
    }
    else
    {
      $method = $this->getOption('persistent', true) ? 'pconnect' : 'connect';
      if (!$this->$method($this->getOption('host', 'localhost'), $this->getOption('port', 11211), $this->getOption('timeout', 1)))
      {
        throw new sfInitializationException(sprintf('Unable to connect to the memcache server (%s:%s).', $this->getOption('host', 'localhost'), $this->getOption('port', 11211)));
      }
    }
    // END: taken from sfMemcacheCache::initialize
  }

  protected function getOption($name, $default = null)
  {
    return isset($this->options[$name]) ? $this->options[$name] : $default;
  }
}