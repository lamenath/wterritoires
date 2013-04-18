<?php

/**
 * Projet filter form base class.
 *
 * @package    rrr
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProjetFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'createur_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Profil'), 'add_empty' => true)),
      'story_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Story'), 'add_empty' => true)),
      'commune_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Commune'), 'add_empty' => true)),
      'type'                      => new sfWidgetFormChoice(array('choices' => array('' => '', 'public' => 'public', 'group' => 'group'))),
      'nom'                       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'action'                    => new sfWidgetFormChoice(array('choices' => array('' => '', 'regional' => 'regional', 'territorial' => 'territorial', 'local' => 'local', 'ultralocal' => 'ultralocal'))),
      'url'                       => new sfWidgetFormFilterInput(),
      'photo'                     => new sfWidgetFormFilterInput(),
      'photo_crop'                => new sfWidgetFormFilterInput(),
      'objectifs_qualitatif'      => new sfWidgetFormFilterInput(),
      'objectifs_quantitatif'     => new sfWidgetFormFilterInput(),
      'strategie'                 => new sfWidgetFormFilterInput(),
      'resultats'                 => new sfWidgetFormFilterInput(),
      'besoins'                   => new sfWidgetFormFilterInput(),
      'lecons'                    => new sfWidgetFormFilterInput(),
      'avancement'                => new sfWidgetFormFilterInput(),
      'date_debut'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'date_echeance'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'slug'                      => new sfWidgetFormFilterInput(),
      'metier_list'               => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Metier')),
      'structure_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Structure')),
      'structure_partenaire_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Structure')),
      'filiere_list'              => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Filiere')),
      'theme_list'                => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Theme')),
      'competence_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Competence')),
    ));

    $this->setValidators(array(
      'createur_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Profil'), 'column' => 'id')),
      'story_id'                  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Story'), 'column' => 'id')),
      'commune_id'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Commune'), 'column' => 'id')),
      'type'                      => new sfValidatorChoice(array('required' => false, 'choices' => array('public' => 'public', 'group' => 'group'))),
      'nom'                       => new sfValidatorPass(array('required' => false)),
      'action'                    => new sfValidatorChoice(array('required' => false, 'choices' => array('regional' => 'regional', 'territorial' => 'territorial', 'local' => 'local', 'ultralocal' => 'ultralocal'))),
      'url'                       => new sfValidatorPass(array('required' => false)),
      'photo'                     => new sfValidatorPass(array('required' => false)),
      'photo_crop'                => new sfValidatorPass(array('required' => false)),
      'objectifs_qualitatif'      => new sfValidatorPass(array('required' => false)),
      'objectifs_quantitatif'     => new sfValidatorPass(array('required' => false)),
      'strategie'                 => new sfValidatorPass(array('required' => false)),
      'resultats'                 => new sfValidatorPass(array('required' => false)),
      'besoins'                   => new sfValidatorPass(array('required' => false)),
      'lecons'                    => new sfValidatorPass(array('required' => false)),
      'avancement'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'date_debut'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'date_echeance'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'                      => new sfValidatorPass(array('required' => false)),
      'metier_list'               => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Metier', 'required' => false)),
      'structure_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Structure', 'required' => false)),
      'structure_partenaire_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Structure', 'required' => false)),
      'filiere_list'              => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Filiere', 'required' => false)),
      'theme_list'                => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Theme', 'required' => false)),
      'competence_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Competence', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('projet_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
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
      ->leftJoin($query->getRootAlias().'.ProjetMetier ProjetMetier')
      ->andWhereIn('ProjetMetier.metier_id', $values)
    ;
  }

  public function addStructureListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.ProjetStructure ProjetStructure')
      ->andWhereIn('ProjetStructure.structure_id', $values)
    ;
  }

  public function addStructurePartenaireListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.ProjetStructurePartenaire ProjetStructurePartenaire')
      ->andWhereIn('ProjetStructurePartenaire.structure_id', $values)
    ;
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
      ->leftJoin($query->getRootAlias().'.ProjetFiliere ProjetFiliere')
      ->andWhereIn('ProjetFiliere.filiere_id', $values)
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
      ->leftJoin($query->getRootAlias().'.ProjetTheme ProjetTheme')
      ->andWhereIn('ProjetTheme.theme_id', $values)
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
      ->leftJoin($query->getRootAlias().'.ProjetCompetence ProjetCompetence')
      ->andWhereIn('ProjetCompetence.competence_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Projet';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'createur_id'               => 'ForeignKey',
      'story_id'                  => 'ForeignKey',
      'commune_id'                => 'ForeignKey',
      'type'                      => 'Enum',
      'nom'                       => 'Text',
      'action'                    => 'Enum',
      'url'                       => 'Text',
      'photo'                     => 'Text',
      'photo_crop'                => 'Text',
      'objectifs_qualitatif'      => 'Text',
      'objectifs_quantitatif'     => 'Text',
      'strategie'                 => 'Text',
      'resultats'                 => 'Text',
      'besoins'                   => 'Text',
      'lecons'                    => 'Text',
      'avancement'                => 'Number',
      'date_debut'                => 'Date',
      'date_echeance'             => 'Date',
      'created_at'                => 'Date',
      'updated_at'                => 'Date',
      'slug'                      => 'Text',
      'metier_list'               => 'ManyKey',
      'structure_list'            => 'ManyKey',
      'structure_partenaire_list' => 'ManyKey',
      'filiere_list'              => 'ManyKey',
      'theme_list'                => 'ManyKey',
      'competence_list'           => 'ManyKey',
    );
  }
}
