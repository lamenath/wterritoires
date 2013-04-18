<?php


class sfGuardRememberKeyUtf8Table extends sfGuardRememberKeyTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('sfGuardRememberKeyUtf8');
    }
}