<?php

/**
 * ProfilFiliere
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class ProfilFiliere extends BaseProfilFiliere
{
	public function getMatchingFilieres($profil_id, $render = false)
	{
		$filieres = array(0);
		$ProfilComparaison = Doctrine::getTable('Profil')->find($profil_id);
		
		foreach($ProfilComparaison->getFiliere() as $filiere)
		{
			$filieres[] = $filiere->getId();
		}
			
		$Query = Doctrine_Query::create()
								->from('ProfilFiliere pf')
								->where('pf.profil_id = ?', $this->getProfilId())
								->andWhere('pf.filiere_id IN ('.implode(",",$filieres).')')
								->orderBy("RANDOM()")
								->limit(5)
								->execute();

		$returns = array();
		
		foreach($Query as $mm)
		{
			$returns[] = $mm->getFiliere()->getNom();
		}
		
		if($render) return implode(', ', $returns);
		else return $returns;
	}
}