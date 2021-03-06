<?php

/**
 * BaseMailing
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $sujet
 * @property clob $message
 * @property boolean $is_sent
 * @property Doctrine_Collection $Filiere
 * @property Doctrine_Collection $MailingFiliere
 * 
 * @method string              getSujet()          Returns the current record's "sujet" value
 * @method clob                getMessage()        Returns the current record's "message" value
 * @method boolean             getIsSent()         Returns the current record's "is_sent" value
 * @method Doctrine_Collection getFiliere()        Returns the current record's "Filiere" collection
 * @method Doctrine_Collection getMailingFiliere() Returns the current record's "MailingFiliere" collection
 * @method Mailing             setSujet()          Sets the current record's "sujet" value
 * @method Mailing             setMessage()        Sets the current record's "message" value
 * @method Mailing             setIsSent()         Sets the current record's "is_sent" value
 * @method Mailing             setFiliere()        Sets the current record's "Filiere" collection
 * @method Mailing             setMailingFiliere() Sets the current record's "MailingFiliere" collection
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMailing extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('mailing');
        $this->hasColumn('sujet', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('message', 'clob', null, array(
             'type' => 'clob',
             'notnull' => true,
             ));
        $this->hasColumn('is_sent', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));


        $this->index('created_at', array(
             'fields' => 
             array(
              0 => 'created_at',
             ),
             ));
        $this->index('updated_at', array(
             'fields' => 
             array(
              0 => 'updated_at',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Filiere', array(
             'refClass' => 'MailingFiliere',
             'local' => 'mailing_id',
             'foreign' => 'filiere_id'));

        $this->hasMany('MailingFiliere', array(
             'local' => 'id',
             'foreign' => 'mailing_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}