<?php

/**
 * BaseProfilTheme
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $profil_id
 * @property integer $theme_id
 * @property Profil $Profil
 * @property Theme $Theme
 * 
 * @method integer     getId()        Returns the current record's "id" value
 * @method integer     getProfilId()  Returns the current record's "profil_id" value
 * @method integer     getThemeId()   Returns the current record's "theme_id" value
 * @method Profil      getProfil()    Returns the current record's "Profil" value
 * @method Theme       getTheme()     Returns the current record's "Theme" value
 * @method ProfilTheme setId()        Sets the current record's "id" value
 * @method ProfilTheme setProfilId()  Sets the current record's "profil_id" value
 * @method ProfilTheme setThemeId()   Sets the current record's "theme_id" value
 * @method ProfilTheme setProfil()    Sets the current record's "Profil" value
 * @method ProfilTheme setTheme()     Sets the current record's "Theme" value
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProfilTheme extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('profil_theme');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('profil_id', 'integer', null, array(
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
        $this->hasOne('Profil', array(
             'local' => 'profil_id',
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