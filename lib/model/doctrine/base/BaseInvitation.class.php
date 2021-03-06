<?php

/**
 * BaseInvitation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $profil_id
 * @property integer $projet_id
 * @property integer $event_id
 * @property integer $inviteur_id
 * @property integer $story_id
 * @property timestamp $date
 * @property boolean $hidden
 * @property Profil $Profil
 * @property Projet $Projet
 * @property Event $Event
 * @property Story $Story
 * @property Profil $Inviteur
 * 
 * @method integer    getId()          Returns the current record's "id" value
 * @method integer    getProfilId()    Returns the current record's "profil_id" value
 * @method integer    getProjetId()    Returns the current record's "projet_id" value
 * @method integer    getEventId()     Returns the current record's "event_id" value
 * @method integer    getInviteurId()  Returns the current record's "inviteur_id" value
 * @method integer    getStoryId()     Returns the current record's "story_id" value
 * @method timestamp  getDate()        Returns the current record's "date" value
 * @method boolean    getHidden()      Returns the current record's "hidden" value
 * @method Profil     getProfil()      Returns the current record's "Profil" value
 * @method Projet     getProjet()      Returns the current record's "Projet" value
 * @method Event      getEvent()       Returns the current record's "Event" value
 * @method Story      getStory()       Returns the current record's "Story" value
 * @method Profil     getInviteur()    Returns the current record's "Inviteur" value
 * @method Invitation setId()          Sets the current record's "id" value
 * @method Invitation setProfilId()    Sets the current record's "profil_id" value
 * @method Invitation setProjetId()    Sets the current record's "projet_id" value
 * @method Invitation setEventId()     Sets the current record's "event_id" value
 * @method Invitation setInviteurId()  Sets the current record's "inviteur_id" value
 * @method Invitation setStoryId()     Sets the current record's "story_id" value
 * @method Invitation setDate()        Sets the current record's "date" value
 * @method Invitation setHidden()      Sets the current record's "hidden" value
 * @method Invitation setProfil()      Sets the current record's "Profil" value
 * @method Invitation setProjet()      Sets the current record's "Projet" value
 * @method Invitation setEvent()       Sets the current record's "Event" value
 * @method Invitation setStory()       Sets the current record's "Story" value
 * @method Invitation setInviteur()    Sets the current record's "Inviteur" value
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseInvitation extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('invitation');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('profil_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('projet_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('event_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('inviteur_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('story_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('date', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('hidden', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => false,
             ));


        $this->index('date', array(
             'fields' => 
             array(
              0 => 'date',
             ),
             ));
        $this->index('hidden', array(
             'fields' => 
             array(
              0 => 'hidden',
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

        $this->hasOne('Projet', array(
             'local' => 'projet_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Event', array(
             'local' => 'event_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Story', array(
             'local' => 'story_id',
             'foreign' => 'id',
             'onDelete' => 'SET NULL'));

        $this->hasOne('Profil as Inviteur', array(
             'local' => 'inviteur_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}