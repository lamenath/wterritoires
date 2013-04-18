<?php

/**
 * BaseAnnonceMetier
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $annonce_id
 * @property integer $metier_id
 * @property Annonce $Annonce
 * @property Metier $Metier
 * 
 * @method integer       getId()         Returns the current record's "id" value
 * @method integer       getAnnonceId()  Returns the current record's "annonce_id" value
 * @method integer       getMetierId()   Returns the current record's "metier_id" value
 * @method Annonce       getAnnonce()    Returns the current record's "Annonce" value
 * @method Metier        getMetier()     Returns the current record's "Metier" value
 * @method AnnonceMetier setId()         Sets the current record's "id" value
 * @method AnnonceMetier setAnnonceId()  Sets the current record's "annonce_id" value
 * @method AnnonceMetier setMetierId()   Sets the current record's "metier_id" value
 * @method AnnonceMetier setAnnonce()    Sets the current record's "Annonce" value
 * @method AnnonceMetier setMetier()     Sets the current record's "Metier" value
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAnnonceMetier extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('annonce_metier');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('annonce_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('metier_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Annonce', array(
             'local' => 'annonce_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Metier', array(
             'local' => 'metier_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}