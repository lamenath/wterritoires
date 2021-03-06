<?php

/**
 * BaseStoryBuddies
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $story_id
 * @property integer $profil_id
 * @property Story $Story
 * @property Profil $Profil
 * 
 * @method integer      getStoryId()   Returns the current record's "story_id" value
 * @method integer      getProfilId()  Returns the current record's "profil_id" value
 * @method Story        getStory()     Returns the current record's "Story" value
 * @method Profil       getProfil()    Returns the current record's "Profil" value
 * @method StoryBuddies setStoryId()   Sets the current record's "story_id" value
 * @method StoryBuddies setProfilId()  Sets the current record's "profil_id" value
 * @method StoryBuddies setStory()     Sets the current record's "Story" value
 * @method StoryBuddies setProfil()    Sets the current record's "Profil" value
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseStoryBuddies extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('story_buddies');
        $this->hasColumn('story_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('profil_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
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
             'onDelete' => 'CASCADE'));

        $this->hasOne('Profil', array(
             'local' => 'profil_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}