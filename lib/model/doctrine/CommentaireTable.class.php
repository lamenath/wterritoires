<?php


class CommentaireTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Commentaire');
    }
}