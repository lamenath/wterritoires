<?php

/**
 * BaseHomeNews
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $photo
 * @property string $titre
 * @property clob $text
 * @property string $titre_lien
 * 
 * @method string   getPhoto()      Returns the current record's "photo" value
 * @method string   getTitre()      Returns the current record's "titre" value
 * @method clob     getText()       Returns the current record's "text" value
 * @method string   getTitreLien()  Returns the current record's "titre_lien" value
 * @method HomeNews setPhoto()      Sets the current record's "photo" value
 * @method HomeNews setTitre()      Sets the current record's "titre" value
 * @method HomeNews setText()       Sets the current record's "text" value
 * @method HomeNews setTitreLien()  Sets the current record's "titre_lien" value
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseHomeNews extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('home_news');
        $this->hasColumn('photo', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('titre', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('text', 'clob', null, array(
             'type' => 'clob',
             'notnull' => true,
             ));
        $this->hasColumn('titre_lien', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}