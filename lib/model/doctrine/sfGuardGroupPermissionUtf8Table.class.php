<?php


class sfGuardGroupPermissionUtf8Table extends sfGuardGroupPermissionTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('sfGuardGroupPermissionUtf8');
    }
}