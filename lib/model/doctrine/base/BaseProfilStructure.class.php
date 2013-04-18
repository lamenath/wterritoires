<?php

/**
 * BaseProfilStructure
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $profil_id
 * @property integer $structure_id
 * @property enum $role
 * @property Profil $Profil
 * @property Structure $Structure
 * 
 * @method integer         getId()           Returns the current record's "id" value
 * @method integer         getProfilId()     Returns the current record's "profil_id" value
 * @method integer         getStructureId()  Returns the current record's "structure_id" value
 * @method enum            getRole()         Returns the current record's "role" value
 * @method Profil          getProfil()       Returns the current record's "Profil" value
 * @method Structure       getStructure()    Returns the current record's "Structure" value
 * @method ProfilStructure setId()           Sets the current record's "id" value
 * @method ProfilStructure setProfilId()     Sets the current record's "profil_id" value
 * @method ProfilStructure setStructureId()  Sets the current record's "structure_id" value
 * @method ProfilStructure setRole()         Sets the current record's "role" value
 * @method ProfilStructure setProfil()       Sets the current record's "Profil" value
 * @method ProfilStructure setStructure()    Sets the current record's "Structure" value
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProfilStructure extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('profil_structure');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('profil_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('structure_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('role', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'referent',
              1 => 'membre',
             ),
             ));


        $this->index('role', array(
             'fields' => 
             array(
              0 => 'role',
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

        $this->hasOne('Structure', array(
             'local' => 'structure_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}