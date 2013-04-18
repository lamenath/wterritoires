<?php

/**
 * BaseProfilProfil
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $profil_id
 * @property integer $contact_id
 * @property integer $story_id
 * @property integer $is_activated
 * @property timestamp $date
 * @property Story $Story
 * @property Profil $Profil
 * @property Profil $Contact
 * 
 * @method integer      getId()           Returns the current record's "id" value
 * @method integer      getProfilId()     Returns the current record's "profil_id" value
 * @method integer      getContactId()    Returns the current record's "contact_id" value
 * @method integer      getStoryId()      Returns the current record's "story_id" value
 * @method integer      getIsActivated()  Returns the current record's "is_activated" value
 * @method timestamp    getDate()         Returns the current record's "date" value
 * @method Story        getStory()        Returns the current record's "Story" value
 * @method Profil       getProfil()       Returns the current record's "Profil" value
 * @method Profil       getContact()      Returns the current record's "Contact" value
 * @method ProfilProfil setId()           Sets the current record's "id" value
 * @method ProfilProfil setProfilId()     Sets the current record's "profil_id" value
 * @method ProfilProfil setContactId()    Sets the current record's "contact_id" value
 * @method ProfilProfil setStoryId()      Sets the current record's "story_id" value
 * @method ProfilProfil setIsActivated()  Sets the current record's "is_activated" value
 * @method ProfilProfil setDate()         Sets the current record's "date" value
 * @method ProfilProfil setStory()        Sets the current record's "Story" value
 * @method ProfilProfil setProfil()       Sets the current record's "Profil" value
 * @method ProfilProfil setContact()      Sets the current record's "Contact" value
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProfilProfil extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('profil_profil');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('profil_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('contact_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('story_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('is_activated', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('date', 'timestamp', null, array(
             'type' => 'timestamp',
             ));


        $this->index('date', array(
             'fields' => 
             array(
              0 => 'date',
             ),
             ));
        $this->index('is_activated', array(
             'fields' => 
             array(
              0 => 'is_activated',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Story', array(
             'local' => 'story_id',
             'foreign' => 'id',
             'onDelete' => 'SET NULL'));

        $this->hasOne('Profil', array(
             'local' => 'profil_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Profil as Contact', array(
             'local' => 'contact_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}