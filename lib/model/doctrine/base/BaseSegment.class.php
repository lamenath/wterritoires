<?php

/**
 * BaseSegment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $nom
 * @property string $localite
 * @property Doctrine_Collection $Metier
 * @property Doctrine_Collection $Theme
 * @property Doctrine_Collection $Competence
 * @property Doctrine_Collection $Filiere
 * @property Doctrine_Collection $Mailing
 * @property Doctrine_Collection $MailingSegment
 * @property Doctrine_Collection $SegmentCompetence
 * @property Doctrine_Collection $SegmentMetier
 * @property Doctrine_Collection $SegmentTheme
 * @property Doctrine_Collection $SegmentFiliere
 * 
 * @method string              getNom()               Returns the current record's "nom" value
 * @method string              getLocalite()          Returns the current record's "localite" value
 * @method Doctrine_Collection getMetier()            Returns the current record's "Metier" collection
 * @method Doctrine_Collection getTheme()             Returns the current record's "Theme" collection
 * @method Doctrine_Collection getCompetence()        Returns the current record's "Competence" collection
 * @method Doctrine_Collection getFiliere()           Returns the current record's "Filiere" collection
 * @method Doctrine_Collection getMailing()           Returns the current record's "Mailing" collection
 * @method Doctrine_Collection getMailingSegment()    Returns the current record's "MailingSegment" collection
 * @method Doctrine_Collection getSegmentCompetence() Returns the current record's "SegmentCompetence" collection
 * @method Doctrine_Collection getSegmentMetier()     Returns the current record's "SegmentMetier" collection
 * @method Doctrine_Collection getSegmentTheme()      Returns the current record's "SegmentTheme" collection
 * @method Doctrine_Collection getSegmentFiliere()    Returns the current record's "SegmentFiliere" collection
 * @method Segment             setNom()               Sets the current record's "nom" value
 * @method Segment             setLocalite()          Sets the current record's "localite" value
 * @method Segment             setMetier()            Sets the current record's "Metier" collection
 * @method Segment             setTheme()             Sets the current record's "Theme" collection
 * @method Segment             setCompetence()        Sets the current record's "Competence" collection
 * @method Segment             setFiliere()           Sets the current record's "Filiere" collection
 * @method Segment             setMailing()           Sets the current record's "Mailing" collection
 * @method Segment             setMailingSegment()    Sets the current record's "MailingSegment" collection
 * @method Segment             setSegmentCompetence() Sets the current record's "SegmentCompetence" collection
 * @method Segment             setSegmentMetier()     Sets the current record's "SegmentMetier" collection
 * @method Segment             setSegmentTheme()      Sets the current record's "SegmentTheme" collection
 * @method Segment             setSegmentFiliere()    Sets the current record's "SegmentFiliere" collection
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSegment extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('segment');
        $this->hasColumn('nom', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('localite', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
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
        $this->index('latitude', array(
             'fields' => 
             array(
              0 => 'latitude',
             ),
             ));
        $this->index('longitude', array(
             'fields' => 
             array(
              0 => 'longitude',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Metier', array(
             'refClass' => 'SegmentMetier',
             'local' => 'segment_id',
             'foreign' => 'metier_id'));

        $this->hasMany('Theme', array(
             'refClass' => 'SegmentTheme',
             'local' => 'segment_id',
             'foreign' => 'theme_id'));

        $this->hasMany('Competence', array(
             'refClass' => 'SegmentCompetence',
             'local' => 'segment_id',
             'foreign' => 'competence_id'));

        $this->hasMany('Filiere', array(
             'refClass' => 'SegmentFiliere',
             'local' => 'segment_id',
             'foreign' => 'filiere_id'));

        $this->hasMany('Mailing', array(
             'refClass' => 'MailingSegment',
             'local' => 'segment_id',
             'foreign' => 'mailing_id'));

        $this->hasMany('MailingSegment', array(
             'local' => 'id',
             'foreign' => 'segment_id'));

        $this->hasMany('SegmentCompetence', array(
             'local' => 'id',
             'foreign' => 'segment_id'));

        $this->hasMany('SegmentMetier', array(
             'local' => 'id',
             'foreign' => 'segment_id'));

        $this->hasMany('SegmentTheme', array(
             'local' => 'id',
             'foreign' => 'segment_id'));

        $this->hasMany('SegmentFiliere', array(
             'local' => 'id',
             'foreign' => 'segment_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $geolocatable0 = new Doctrine_Template_Geolocatable(array(
             'fields' => 
             array(
              0 => 'localite',
             ),
             ));
        $this->actAs($timestampable0);
        $this->actAs($geolocatable0);
    }
}