<?php

/**
 * BaseProfilExpertise
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $profil_id
 * @property integer $expertise_id
 * @property Profil $Profil
 * @property Expertise $Expertise
 * 
 * @method integer         getId()           Returns the current record's "id" value
 * @method integer         getProfilId()     Returns the current record's "profil_id" value
 * @method integer         getExpertiseId()  Returns the current record's "expertise_id" value
 * @method Profil          getProfil()       Returns the current record's "Profil" value
 * @method Expertise       getExpertise()    Returns the current record's "Expertise" value
 * @method ProfilExpertise setId()           Sets the current record's "id" value
 * @method ProfilExpertise setProfilId()     Sets the current record's "profil_id" value
 * @method ProfilExpertise setExpertiseId()  Sets the current record's "expertise_id" value
 * @method ProfilExpertise setProfil()       Sets the current record's "Profil" value
 * @method ProfilExpertise setExpertise()    Sets the current record's "Expertise" value
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProfilExpertise extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('profil_expertise');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('profil_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('expertise_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
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

        $this->hasOne('Expertise', array(
             'local' => 'expertise_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}