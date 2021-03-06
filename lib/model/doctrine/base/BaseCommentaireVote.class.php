<?php

/**
 * BaseCommentaireVote
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $profil_id
 * @property integer $story_id
 * @property integer $content_id
 * @property string $content_type
 * @property Profil $Profil
 * @property Story $Story
 * 
 * @method integer         getProfilId()     Returns the current record's "profil_id" value
 * @method integer         getStoryId()      Returns the current record's "story_id" value
 * @method integer         getContentId()    Returns the current record's "content_id" value
 * @method string          getContentType()  Returns the current record's "content_type" value
 * @method Profil          getProfil()       Returns the current record's "Profil" value
 * @method Story           getStory()        Returns the current record's "Story" value
 * @method CommentaireVote setProfilId()     Sets the current record's "profil_id" value
 * @method CommentaireVote setStoryId()      Sets the current record's "story_id" value
 * @method CommentaireVote setContentId()    Sets the current record's "content_id" value
 * @method CommentaireVote setContentType()  Sets the current record's "content_type" value
 * @method CommentaireVote setProfil()       Sets the current record's "Profil" value
 * @method CommentaireVote setStory()        Sets the current record's "Story" value
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCommentaireVote extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('commentaire_vote');
        $this->hasColumn('profil_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('story_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('content_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('content_type', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
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

        $this->hasOne('Story', array(
             'local' => 'story_id',
             'foreign' => 'id',
             'onDelete' => 'SET NULL'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}