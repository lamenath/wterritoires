<?php

/**
 * Structure
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Structure extends BaseStructure
{
	public function __toString()
	{
		return RRR::cut_text($this->getNom(), 45);	
	}
	
	public function getCommune()
	{
		$commune = Doctrine_Query::create()
								->from('Commune p')
								->leftJoin('p.Pays')
								->where('p.code_postal = ?', $this->getCodePostal())
								->orWhere('p.code_insee = ?', $this->getCodeInsee())
								->limit(1)
								->useResultCache(true, 8000)
								->execute();
								
		return (isset($commune[0]) ? $commune[0] : false);
	}
	
	public function getPays()
	{
		$com = $this->getCommune();
		
		if($com)
			return $com->getPays();
		else
			return false;		
	}
}