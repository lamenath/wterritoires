<?php


class sfGuardUserPermissionUtf8Table extends sfGuardUserPermissionTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('sfGuardUserPermissionUtf8');
    }
}