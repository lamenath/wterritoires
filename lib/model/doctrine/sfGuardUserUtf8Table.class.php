<?php


class sfGuardUserUtf8Table extends sfGuardUserTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('sfGuardUserUtf8');
    }
}