<?php

/**
 * BaseActionPassword
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $profil_id
 * @property string $ticket
 * @property timestamp $date
 * @property Profil $Profil
 * 
 * @method integer        getId()        Returns the current record's "id" value
 * @method integer        getProfilId()  Returns the current record's "profil_id" value
 * @method string         getTicket()    Returns the current record's "ticket" value
 * @method timestamp      getDate()      Returns the current record's "date" value
 * @method Profil         getProfil()    Returns the current record's "Profil" value
 * @method ActionPassword setId()        Sets the current record's "id" value
 * @method ActionPassword setProfilId()  Sets the current record's "profil_id" value
 * @method ActionPassword setTicket()    Sets the current record's "ticket" value
 * @method ActionPassword setDate()      Sets the current record's "date" value
 * @method ActionPassword setProfil()    Sets the current record's "Profil" value
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseActionPassword extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('action_password');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('profil_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('ticket', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('date', 'timestamp', null, array(
             'type' => 'timestamp',
             ));


        $this->index('ticket', array(
             'fields' => 
             array(
              0 => 'ticket',
             ),
             ));
        $this->index('date', array(
             'fields' => 
             array(
              0 => 'date',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Profil', array(
             'local' => 'profil_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}