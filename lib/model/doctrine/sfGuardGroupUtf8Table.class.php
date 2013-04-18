<?php


class sfGuardGroupUtf8Table extends sfGuardGroupTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('sfGuardGroupUtf8');
    }
}