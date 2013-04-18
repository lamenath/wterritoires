<?php

/**
 * BaseProfilFiliere
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $profil_id
 * @property integer $filiere_id
 * @property Profil $Profil
 * @property Filiere $Filiere
 * 
 * @method integer       getId()         Returns the current record's "id" value
 * @method integer       getProfilId()   Returns the current record's "profil_id" value
 * @method integer       getFiliereId()  Returns the current record's "filiere_id" value
 * @method Profil        getProfil()     Returns the current record's "Profil" value
 * @method Filiere       getFiliere()    Returns the current record's "Filiere" value
 * @method ProfilFiliere setId()         Sets the current record's "id" value
 * @method ProfilFiliere setProfilId()   Sets the current record's "profil_id" value
 * @method ProfilFiliere setFiliereId()  Sets the current record's "filiere_id" value
 * @method ProfilFiliere setProfil()     Sets the current record's "Profil" value
 * @method ProfilFiliere setFiliere()    Sets the current record's "Filiere" value
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProfilFiliere extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('profil_filiere');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('profil_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('filiere_id', 'integer', null, array(
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

        $this->hasOne('Filiere', array(
             'local' => 'filiere_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}