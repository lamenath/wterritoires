<?php

/**
 * BaseProjetFiliere
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $projet_id
 * @property integer $filiere_id
 * @property Projet $Projet
 * @property Filiere $Filiere
 * 
 * @method integer       getId()         Returns the current record's "id" value
 * @method integer       getProjetId()   Returns the current record's "projet_id" value
 * @method integer       getFiliereId()  Returns the current record's "filiere_id" value
 * @method Projet        getProjet()     Returns the current record's "Projet" value
 * @method Filiere       getFiliere()    Returns the current record's "Filiere" value
 * @method ProjetFiliere setId()         Sets the current record's "id" value
 * @method ProjetFiliere setProjetId()   Sets the current record's "projet_id" value
 * @method ProjetFiliere setFiliereId()  Sets the current record's "filiere_id" value
 * @method ProjetFiliere setProjet()     Sets the current record's "Projet" value
 * @method ProjetFiliere setFiliere()    Sets the current record's "Filiere" value
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProjetFiliere extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('projet_filiere');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('projet_id', 'integer', null, array(
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
        $this->hasOne('Projet', array(
             'local' => 'projet_id',
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