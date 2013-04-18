<?php


class PhotoProjetTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PhotoProjet');
    }
}