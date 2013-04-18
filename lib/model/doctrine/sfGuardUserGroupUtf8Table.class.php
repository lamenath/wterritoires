<?php


class sfGuardUserGroupUtf8Table extends sfGuardUserGroupTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('sfGuardUserGroupUtf8');
    }
}