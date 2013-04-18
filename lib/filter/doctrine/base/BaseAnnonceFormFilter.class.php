<?php

/**
 * Annonce filter form base class.
 *
 * @package    rrr
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAnnonceFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'createur_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'add_empty' => true)),
      'story_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story'), 'add_empty' => true)),
      'projet_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Projet'), 'add_empty' => true)),
      'categorie_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AnnonceCategorie'), 'add_empty' => true)),
      'structure_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Structure'), 'add_empty' => true)),
      'type'            => new sfWidgetFormChoice(array('choices' => array('' => '', 'offre' => 'offre', 'demande' => 'demande'))),
      'titre'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'     => new sfWidgetFormFilterInput(),
      'ville'           => new sfWidgetFormFilterInput(),
      'photo'           => new sfWidgetFormFilterInput(),
      'slug'            => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'filiere_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Filiere')),
      'theme_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Theme')),
      'competence_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Competence')),
      'metier_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Metier')),
    ));

    $this->setValidators(array(
      'createur_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Profil'), 'column' => 'id')),
      'story_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Story'), 'column' => 'id')),
      'projet_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Projet'), 'column' => 'id')),
      'categorie_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('AnnonceCategorie'), 'column' => 'id')),
      'structure_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Structure'), 'column' => 'id')),
      'type'            => new sfValidatorChoice(array('required' => false, 'choices' => array('offre' => 'offre', 'demande' => 'demande'))),
      'titre'           => new sfValidatorPass(array('required' => false)),
      'description'     => new sfValidatorPass(array('required' => false)),
      'ville'           => new sfValidatorPass(array('required' => false)),
      'photo'           => new sfValidatorPass(array('required' => false)),
      'slug'            => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'filiere_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Filiere', 'required' => false)),
      'theme_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Theme', 'required' => false)),
      'competence_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Competence', 'required' => false)),
      'metier_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Metier', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('annonce_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addFiliereListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.AnnonceFiliere AnnonceFiliere')
      ->andWhereIn('AnnonceFiliere.filiere_id', $values)
    ;
  }

  public function addThemeListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.AnnonceTheme AnnonceTheme')
      ->andWhereIn('AnnonceTheme.theme_id', $values)
    ;
  }

  public function addCompetenceListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.AnnonceCompetence AnnonceCompetence')
      ->andWhereIn('AnnonceCompetence.competence_id', $values)
    ;
  }

  public function addMetierListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.AnnonceMetier AnnonceMetier')
      ->andWhereIn('AnnonceMetier.metier_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Annonce';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'createur_id'     => 'ForeignKey',
      'story_id'        => 'ForeignKey',
      'projet_id'       => 'ForeignKey',
      'categorie_id'    => 'ForeignKey',
      'structure_id'    => 'ForeignKey',
      'type'            => 'Enum',
      'titre'           => 'Text',
      'description'     => 'Text',
      'ville'           => 'Text',
      'photo'           => 'Text',
      'slug'            => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'filiere_list'    => 'ManyKey',
      'theme_list'      => 'ManyKey',
      'competence_list' => 'ManyKey',
      'metier_list'     => 'ManyKey',
    );
  }
}
