<?php

/**
 * BaseProjet
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $createur_id
 * @property integer $story_id
 * @property integer $commune_id
 * @property enum $type
 * @property string $nom
 * @property enum $action
 * @property string $url
 * @property string $photo
 * @property string $photo_crop
 * @property clob $objectifs_qualitatif
 * @property clob $objectifs_quantitatif
 * @property clob $strategie
 * @property clob $resultats
 * @property clob $besoins
 * @property clob $lecons
 * @property integer $avancement
 * @property timestamp $date_debut
 * @property timestamp $date_echeance
 * @property Profil $Profil
 * @property Commune $Commune
 * @property Story $Story
 * @property Doctrine_Collection $Metier
 * @property Doctrine_Collection $Structure
 * @property Doctrine_Collection $StructurePartenaire
 * @property Doctrine_Collection $Filiere
 * @property Doctrine_Collection $Theme
 * @property Doctrine_Collection $Competence
 * @property Doctrine_Collection $WishInvitation
 * @property Doctrine_Collection $Invitation
 * @property Doctrine_Collection $InvitationEmail
 * @property Doctrine_Collection $ProfilProjet
 * @property Doctrine_Collection $PhotoProjet
 * @property Doctrine_Collection $Ressource
 * @property Doctrine_Collection $ProjetIdee
 * @property Doctrine_Collection $ProjetStructure
 * @property Doctrine_Collection $ProjetStructurePartenaire
 * @property Doctrine_Collection $ProjetFiliere
 * @property Doctrine_Collection $ProjetTheme
 * @property Doctrine_Collection $ProjetCompetence
 * @property Doctrine_Collection $ProjetMetier
 * 
 * @method integer             getCreateurId()                Returns the current record's "createur_id" value
 * @method integer             getStoryId()                   Returns the current record's "story_id" value
 * @method integer             getCommuneId()                 Returns the current record's "commune_id" value
 * @method enum                getType()                      Returns the current record's "type" value
 * @method string              getNom()                       Returns the current record's "nom" value
 * @method enum                getAction()                    Returns the current record's "action" value
 * @method string              getUrl()                       Returns the current record's "url" value
 * @method string              getPhoto()                     Returns the current record's "photo" value
 * @method string              getPhotoCrop()                 Returns the current record's "photo_crop" value
 * @method clob                getObjectifsQualitatif()       Returns the current record's "objectifs_qualitatif" value
 * @method clob                getObjectifsQuantitatif()      Returns the current record's "objectifs_quantitatif" value
 * @method clob                getStrategie()                 Returns the current record's "strategie" value
 * @method clob                getResultats()                 Returns the current record's "resultats" value
 * @method clob                getBesoins()                   Returns the current record's "besoins" value
 * @method clob                getLecons()                    Returns the current record's "lecons" value
 * @method integer             getAvancement()                Returns the current record's "avancement" value
 * @method timestamp           getDateDebut()                 Returns the current record's "date_debut" value
 * @method timestamp           getDateEcheance()              Returns the current record's "date_echeance" value
 * @method Profil              getProfil()                    Returns the current record's "Profil" value
 * @method Commune             getCommune()                   Returns the current record's "Commune" value
 * @method Story               getStory()                     Returns the current record's "Story" value
 * @method Doctrine_Collection getMetier()                    Returns the current record's "Metier" collection
 * @method Doctrine_Collection getStructure()                 Returns the current record's "Structure" collection
 * @method Doctrine_Collection getStructurePartenaire()       Returns the current record's "StructurePartenaire" collection
 * @method Doctrine_Collection getFiliere()                   Returns the current record's "Filiere" collection
 * @method Doctrine_Collection getTheme()                     Returns the current record's "Theme" collection
 * @method Doctrine_Collection getCompetence()                Returns the current record's "Competence" collection
 * @method Doctrine_Collection getWishInvitation()            Returns the current record's "WishInvitation" collection
 * @method Doctrine_Collection getInvitation()                Returns the current record's "Invitation" collection
 * @method Doctrine_Collection getInvitationEmail()           Returns the current record's "InvitationEmail" collection
 * @method Doctrine_Collection getProfilProjet()              Returns the current record's "ProfilProjet" collection
 * @method Doctrine_Collection getPhotoProjet()               Returns the current record's "PhotoProjet" collection
 * @method Doctrine_Collection getRessource()                 Returns the current record's "Ressource" collection
 * @method Doctrine_Collection getProjetIdee()                Returns the current record's "ProjetIdee" collection
 * @method Doctrine_Collection getProjetStructure()           Returns the current record's "ProjetStructure" collection
 * @method Doctrine_Collection getProjetStructurePartenaire() Returns the current record's "ProjetStructurePartenaire" collection
 * @method Doctrine_Collection getProjetFiliere()             Returns the current record's "ProjetFiliere" collection
 * @method Doctrine_Collection getProjetTheme()               Returns the current record's "ProjetTheme" collection
 * @method Doctrine_Collection getProjetCompetence()          Returns the current record's "ProjetCompetence" collection
 * @method Doctrine_Collection getProjetMetier()              Returns the current record's "ProjetMetier" collection
 * @method Projet              setCreateurId()                Sets the current record's "createur_id" value
 * @method Projet              setStoryId()                   Sets the current record's "story_id" value
 * @method Projet              setCommuneId()                 Sets the current record's "commune_id" value
 * @method Projet              setType()                      Sets the current record's "type" value
 * @method Projet              setNom()                       Sets the current record's "nom" value
 * @method Projet              setAction()                    Sets the current record's "action" value
 * @method Projet              setUrl()                       Sets the current record's "url" value
 * @method Projet              setPhoto()                     Sets the current record's "photo" value
 * @method Projet              setPhotoCrop()                 Sets the current record's "photo_crop" value
 * @method Projet              setObjectifsQualitatif()       Sets the current record's "objectifs_qualitatif" value
 * @method Projet              setObjectifsQuantitatif()      Sets the current record's "objectifs_quantitatif" value
 * @method Projet              setStrategie()                 Sets the current record's "strategie" value
 * @method Projet              setResultats()                 Sets the current record's "resultats" value
 * @method Projet              setBesoins()                   Sets the current record's "besoins" value
 * @method Projet              setLecons()                    Sets the current record's "lecons" value
 * @method Projet              setAvancement()                Sets the current record's "avancement" value
 * @method Projet              setDateDebut()                 Sets the current record's "date_debut" value
 * @method Projet              setDateEcheance()              Sets the current record's "date_echeance" value
 * @method Projet              setProfil()                    Sets the current record's "Profil" value
 * @method Projet              setCommune()                   Sets the current record's "Commune" value
 * @method Projet              setStory()                     Sets the current record's "Story" value
 * @method Projet              setMetier()                    Sets the current record's "Metier" collection
 * @method Projet              setStructure()                 Sets the current record's "Structure" collection
 * @method Projet              setStructurePartenaire()       Sets the current record's "StructurePartenaire" collection
 * @method Projet              setFiliere()                   Sets the current record's "Filiere" collection
 * @method Projet              setTheme()                     Sets the current record's "Theme" collection
 * @method Projet              setCompetence()                Sets the current record's "Competence" collection
 * @method Projet              setWishInvitation()            Sets the current record's "WishInvitation" collection
 * @method Projet              setInvitation()                Sets the current record's "Invitation" collection
 * @method Projet              setInvitationEmail()           Sets the current record's "InvitationEmail" collection
 * @method Projet              setProfilProjet()              Sets the current record's "ProfilProjet" collection
 * @method Projet              setPhotoProjet()               Sets the current record's "PhotoProjet" collection
 * @method Projet              setRessource()                 Sets the current record's "Ressource" collection
 * @method Projet              setProjetIdee()                Sets the current record's "ProjetIdee" collection
 * @method Projet              setProjetStructure()           Sets the current record's "ProjetStructure" collection
 * @method Projet              setProjetStructurePartenaire() Sets the current record's "ProjetStructurePartenaire" collection
 * @method Projet              setProjetFiliere()             Sets the current record's "ProjetFiliere" collection
 * @method Projet              setProjetTheme()               Sets the current record's "ProjetTheme" collection
 * @method Projet              setProjetCompetence()          Sets the current record's "ProjetCompetence" collection
 * @method Projet              setProjetMetier()              Sets the current record's "ProjetMetier" collection
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProjet extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('projet');
        $this->hasColumn('createur_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('story_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('commune_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'public',
              1 => 'group',
             ),
             'default' => 'public',
             ));
        $this->hasColumn('nom', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 255,
             ));
        $this->hasColumn('action', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'regional',
              1 => 'territorial',
              2 => 'local',
              3 => 'ultralocal',
             ),
             ));
        $this->hasColumn('url', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 255,
             ));
        $this->hasColumn('photo', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('photo_crop', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('objectifs_qualitatif', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('objectifs_quantitatif', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('strategie', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('resultats', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('besoins', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('lecons', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('avancement', 'integer', 3, array(
             'type' => 'integer',
             'length' => 3,
             ));
        $this->hasColumn('date_debut', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => false,
             ));
        $this->hasColumn('date_echeance', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => false,
             ));


        $this->index('date_debut', array(
             'fields' => 
             array(
              0 => 'date_debut',
             ),
             ));
        $this->index('date_echeance', array(
             'fields' => 
             array(
              0 => 'date_echeance',
             ),
             ));
        $this->index('created_at', array(
             'fields' => 
             array(
              0 => 'created_at',
             ),
             ));
        $this->index('type', array(
             'fields' => 
             array(
              0 => 'type',
             ),
             ));
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Profil', array(
             'local' => 'createur_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Commune', array(
             'local' => 'commune_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Story', array(
             'local' => 'story_id',
             'foreign' => 'id',
             'onDelete' => 'SET NULL'));

        $this->hasMany('Metier', array(
             'refClass' => 'ProjetMetier',
             'local' => 'projet_id',
             'foreign' => 'metier_id'));

        $this->hasMany('Structure', array(
             'refClass' => 'ProjetStructure',
             'local' => 'projet_id',
             'foreign' => 'structure_id'));

        $this->hasMany('Structure as StructurePartenaire', array(
             'refClass' => 'ProjetStructurePartenaire',
             'local' => 'projet_id',
             'foreign' => 'structure_id'));

        $this->hasMany('Filiere', array(
             'refClass' => 'ProjetFiliere',
             'local' => 'projet_id',
             'foreign' => 'filiere_id'));

        $this->hasMany('Theme', array(
             'refClass' => 'ProjetTheme',
             'local' => 'projet_id',
             'foreign' => 'theme_id'));

        $this->hasMany('Competence', array(
             'refClass' => 'ProjetCompetence',
             'local' => 'projet_id',
             'foreign' => 'competence_id'));

        $this->hasMany('WishInvitation', array(
             'local' => 'id',
             'foreign' => 'projet_id'));

        $this->hasMany('Invitation', array(
             'local' => 'id',
             'foreign' => 'projet_id'));

        $this->hasMany('InvitationEmail', array(
             'local' => 'id',
             'foreign' => 'projet_id'));

        $this->hasMany('ProfilProjet', array(
             'local' => 'id',
             'foreign' => 'projet_id'));

        $this->hasMany('PhotoProjet', array(
             'local' => 'id',
             'foreign' => 'projet_id'));

        $this->hasMany('Ressource', array(
             'local' => 'id',
             'foreign' => 'projet_id'));

        $this->hasMany('ProjetIdee', array(
             'local' => 'id',
             'foreign' => 'projet_id'));

        $this->hasMany('ProjetStructure', array(
             'local' => 'id',
             'foreign' => 'projet_id'));

        $this->hasMany('ProjetStructurePartenaire', array(
             'local' => 'id',
             'foreign' => 'projet_id'));

        $this->hasMany('ProjetFiliere', array(
             'local' => 'id',
             'foreign' => 'projet_id'));

        $this->hasMany('ProjetTheme', array(
             'local' => 'id',
             'foreign' => 'projet_id'));

        $this->hasMany('ProjetCompetence', array(
             'local' => 'id',
             'foreign' => 'projet_id'));

        $this->hasMany('ProjetMetier', array(
             'local' => 'id',
             'foreign' => 'projet_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'nom',
             ),
             'unique' => 
             array(
              0 => 'nom',
             ),
             ));
        $this->actAs($timestampable0);
        $this->actAs($sluggable0);
    }
}