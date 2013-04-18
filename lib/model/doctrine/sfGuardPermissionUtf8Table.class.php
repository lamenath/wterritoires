<?php


class sfGuardPermissionUtf8Table extends sfGuardPermissionTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('sfGuardPermissionUtf8');
    }
}