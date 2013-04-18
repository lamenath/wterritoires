<?php

/**
 * BaseAnnonceTheme
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $annonce_id
 * @property integer $theme_id
 * @property Annonce $Annonce
 * @property Theme $Theme
 * 
 * @method integer      getId()         Returns the current record's "id" value
 * @method integer      getAnnonceId()  Returns the current record's "annonce_id" value
 * @method integer      getThemeId()    Returns the current record's "theme_id" value
 * @method Annonce      getAnnonce()    Returns the current record's "Annonce" value
 * @method Theme        getTheme()      Returns the current record's "Theme" value
 * @method AnnonceTheme setId()         Sets the current record's "id" value
 * @method AnnonceTheme setAnnonceId()  Sets the current record's "annonce_id" value
 * @method AnnonceTheme setThemeId()    Sets the current record's "theme_id" value
 * @method AnnonceTheme setAnnonce()    Sets the current record's "Annonce" value
 * @method AnnonceTheme setTheme()      Sets the current record's "Theme" value
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAnnonceTheme extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('annonce_theme');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('annonce_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('theme_id', 'integer', null, array(
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

        $this->hasOne('Theme', array(
             'local' => 'theme_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}