<?php

/**
 * Profil
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    rrr
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Profil extends BaseProfil
{
	public function __toString()
	{
		return ucfirst($this->getPrenom()) . " " . mb_strtoupper($this->getNom(), "UTF-8");
	}

	public function addVisit()
	{

	}

	public static function getNewProfils()
	{
		return Doctrine_Query::create()
						->from('Profil p')
						->orderBy("p.created_at DESC")
						->limit(5)
						->useResultCache(true, 8000)
						->execute();
	}

	public function isInvited($pid = 0)
	{
		$invited = Doctrine_Query::create()
					->from('Invitation i')
					->where('i.profil_id = ?', $this->getId())
					->andWhere('i.projet_id = ?', $pid)
					->fetchOne();

		return $invited ? true : false;
	}

	// Amis
	public function getFriends()
	{
		$all = Doctrine_Query::create()
					->from('ProfilProfil p')
					->where('p.profil_id = ? ', $this->getId())
					->leftJoin('p.Contact c')
					->andWhere('p.is_activated = 1')
					->execute(array(), "profile_light");

		return $all;
	}

	public function getFriendsArray()
	{
		$all = Doctrine_Query::create()
					->select("p.id, p.contact_id")
					->from('ProfilProfil p')
					->where('p.profil_id = ? ', $this->getId())
					->leftJoin('p.Contact c')
					->andWhere('p.is_activated = 1')
					->useResultCache(true, 60)
					->execute(null, Doctrine_Core::HYDRATE_ARRAY);

		return $all;
	}

	public function getPicture($min=false)
	{
		if(!$this->getPhoto()) return "blank.gif";

		if(($min==true || !file_exists(sfConfig::get('sf_upload_dir')."/profil/normal_".$this->getPhoto())) && file_exists(sfConfig::get('sf_upload_dir')."/profil/big_mini_".$this->getPhoto()) )
		{
			return "big_mini_" . $this->getPhoto();
		}
		elseif(file_exists(sfConfig::get('sf_upload_dir')."/profil/normal_".$this->getPhoto()))
		{
			return "normal_" . $this->getPhoto();
		}
		else
		{
			return "blank.gif";
		}
	}

	public function getMiniPicture($min=false)
	{
		if(!$this->getPhoto()) return "default.png";

		if(file_exists(sfConfig::get('sf_upload_dir')."/profil/mini_".$this->getPhoto()))
		{
			return "mini_" . $this->getPhoto();
		}
		else
		{
			return "default.png";
		}
	}

	public function getDashboardSuggestion($through_class="Metier", $specific_id = false, $excludeProfil = array(0), $excludeProjet = array(0), $tests = false)
	{
		$ajouts = array();

		if($excludeProfil instanceof sfOutputEscaperArrayDecorator) $excludeProfil = $excludeProfil->getRawValue();
		if($excludeProjet instanceof sfOutputEscaperArrayDecorator) $excludeProjet = $excludeProjet->getRawValue();

		if($specific_id == false)
		{
			$whereIn = array(0);
			eval("\$elements = \$this->getProfil".$through_class."();");
			foreach($elements as $el) { $whereIn[] = $el->get($through_class)->getId(); }
		}
		else
		{
			$whereIn = array((int)$specific_id);
		}

		$newMembers = Doctrine_Query::create()
								->from('Profil'.$through_class.' p')
								->where('p.profil_id != ?', $this->getId())
								->andWhere('p.profil_id NOT IN ('.implode(',', $excludeProfil).')')
								->andWhere('p.'.$through_class.'_id IN ('.implode(',',$whereIn).')')
								->orderBy("p.id DESC")
								->groupBy("p.profil_id")
								->limit(5)
								->useResultCache(true)
								->execute();

		$newProjects = Doctrine_Query::create()
								->from('Projet'.$through_class.' p')
								->where('p.'.$through_class.'_id IN ('.implode(',',$whereIn).')')
								->andWhere('p.projet_id NOT IN ('.implode(',', $excludeProjet).')')
								->orderBy("p.id DESC")
								->groupBy("p.projet_id")
								->limit(5)
								->useResultCache(true)
								->execute();


		foreach($newMembers as $g) { $ajouts[strtotime($g->getProfil()->getCreatedAt())] = array("membre", $g->getProfil()); }
		foreach($newProjects as $g) { $ajouts[strtotime($g->getProjet()->getCreatedAt())] = array("projet", $g->getProjet()); }

		krsort($ajouts);

		$i=0;
		foreach($ajouts as $key => $ajout)
		{
			if(++$i > 5)
			{
				unset($ajouts[$key]);
			}
			else
			{
				if($ajout[0] == "membre")
					$excludeProfil[] = $ajout[1]->getId();
				else
					$excludeProjet[] = $ajout[1]->getId();
			}
		}

		return array($ajouts, $excludeProfil, $excludeProjet);
	}

	public function getFilieres()
	{
		$return = array();

		foreach( $this->getFiliere() as $metier)
		{
			$return[] = $metier;
		}
		return implode(", ", $return);
	}

	public function getMetiers()
	{
		$return = array();

		foreach( $this->getMetier() as $metier)
		{
			$return[] = $metier;
		}
		return implode(", ", $return);
	}

	public function getProfilsSuggest()
	{
		$filieres = array(0);
		$sreturn = array();

		foreach($this->getFiliere() as $filiere)
		{
			$filieres[] = $filiere->getId();
		}

		$suggestions = Doctrine_Query::create()
										->from("ProfilFiliere p")
										->innerJoin("p.Profil a")
										->leftJoin("a.ProfilProfil b")
										->where("p.profil_id != ?", $this->getId())
										->andWhere("p.filiere_id IN (".implode(",", $filieres).")")
										->groupBy("p.profil_id")
										->useResultCache(true)
										->execute();

		foreach($suggestions as $k => $f)
		{
			if(!sfContext::getInstance()->getUser()->hasPendingRequest($f->getProfil()->getId()) && !sfContext::getInstance()->getUser()->isFriendWith($f->getProfil()->getId()))
			{
				$sreturn[] = $f;
			}
		}

		shuffle($sreturn);

		return count($sreturn) ? $sreturn : array();
	}

	public function getProjets($limit=false)
	{
		return Doctrine_Query::create()
								->from("ProfilProjet p")
								->where("p.profil_id = ?", $this->getId())
								->limit($limit)
								->useResultCache(true)
								->execute();
	}

	public function getStructures($limit=false)
	{
		return Doctrine_Query::create()
								->from("ProfilStructure p")
								->where("p.profil_id = ?", $this->getId())
								->limit($limit)
								->useResultCache(true)
								->execute();
	}

	public function getProjetsSuggest()
	{
		$listIn = array(0);
		$Query = array();
		$skills = array();
		$correct=array();

		foreach($this->getProfilProjet() as $k) { $listIn[] = $k->getProjetId(); }

		$QuerySkill = Doctrine_Query::create()
									->from('ProjetCompetence p')
									->innerJoin("p.ProfilCompetence g")
									->where('g.profil_id = ?', $this->getId())
									->andWhere('p.projet_id NOT IN (' . implode(',', $listIn).")")
									->orderBy("RANDOM()")
									->groupBy("p.projet_id")
									->useResultCache(true);

		$QueryJob = Doctrine_Query::create()
									->from('ProjetMetier p')
									->innerJoin("p.ProfilMetier g")
									->where('g.profil_id = ?', $this->getId())
									->andWhere('p.projet_id NOT IN (' . implode(',', $listIn).")")
									->orderBy("RANDOM()")
									->groupBy("p.projet_id")
									->useResultCache(true);

		$QueryFiliere = Doctrine_Query::create()
									->from('ProjetFiliere p')
									->innerJoin("p.ProfilFiliere g")
									->where('g.profil_id = ?', $this->getId())
									->andWhere('p.projet_id NOT IN (' . implode(',', $listIn).")")
									->orderBy("RANDOM()")
									->groupBy("p.projet_id")
									->useResultCache(true);

		// On ne fait un choix que sur les parties qui matchent
		$Count0 = $QuerySkill->count(); if($Count0 > 0) $correct[] = 0;
		$Count1 = $QueryJob->count(); if($Count1 > 0) $correct[] = 1;
		$Count2 = $QueryFiliere->count(); if($Count2 > 0) $correct[] = 2;

		if(count($correct))
		{
			$check = array_rand($correct,1);
		}
		else
		{
			return false;
		}

		// Choix au hasard
		switch($check)
		{
			case "0":
				// Liste des compétences
				$Query = $QuerySkill->fetchOne();
				if($Query) $skills = $Query->getMatchingSkills($this->getId());

				// Message
				$message = __("Vous pouvez mettre vos compétences <b>%1%</b> à contribution", array("%1%" => implode(', ', $skills)));
				$cas = "skill";
			break;

			case "1":
				// Liste des métiers
				$Query = $QueryJob->fetchOne();
				if($Query)	$skills = $Query->getMatchingJobs($this->getId());

				$message = __("Vous pouvez mettre vos métiers <b>%1%</b> à contribution", array("%1%" => implode(', ', $skills)));
				$cas = "job";
			break;

			case "2":
				// Liste des métiers
				$Query = $QueryFiliere->fetchOne();
				if($Query)	$skills = $Query->getMatchingFilieres($this->getId());

				$message = __("Vous travaillez dans les filières <b>%1%</b>", array("%1%" => implode(', ', $skills)));
				$cas = "filiere";
			break;
		}

		return array($message, $Query);
	}

	public function getDashboardActivity($all = false)
	{
		$ajouts = array();
		$i=0;
		$over = 0;
		$actualities = array();
		$listfriend = array(0);
		$list = array(0);

		// Mes amis
		if($all == false)
		{
			$friends = $this->getFriendsArray();

			if(count($friends))
			{
			    $listfriend = array();
		        foreach ($friends as $record) {
		             if (isset($record["contact_id"])) {
		                 $listfriend[] = $record["contact_id"];
		             }
		        }
			}

			// Projets
			$myprojets = Doctrine_Query::create()
								->from('ProfilProjet p')
								->where("p.profil_id = ?", $this->getId())
								->groupBy("p.projet_id")
								->execute();
		}

        $list = array(0);
		$lastg = false;

		if($all == false && count($myprojets))
		{
	        foreach ($myprojets->getData() as $record) {
	             if (isset($record["projet_id"])) {
	                 $list[] = $record["projet_id"];
	             }
	         }
		}

		$data = Doctrine_Query::create()
								->from('ProfilProjet p')
								->leftJoin('p.Profil')
								->leftJoin('p.Projet')
								->andWhere('p.profil_id != ?', $this->getId())
								->orderBy("p.date DESC")
								->limit(30)
								->useResultCache(true);

		if($all == false) $data = $data->where('p.projet_id IN ('.implode(',', $list).') OR p.profil_id IN ('.implode(',', $listfriend).')')->execute();
		else $data = $data->execute();

		$dataFiles = Doctrine_Query::create()
								->from('Ressource r')
								->leftJoin('r.Profil')
								->leftJoin('r.Projet')
								->where('r.createur_id != ?', $this->getId())
								->orderBy("r.date DESC")
								->limit(20)
								->useResultCache(true);

		if($all == false) $dataFiles = $dataFiles->where('r.projet_id IN ('.implode(',', $list).')')->execute();
		else $dataFiles = $dataFiles->execute();

		foreach($data as $g)
		{
			$pid = $g->getProfil()->getId();
			$pdate = strtotime($g->getDate());

			if(!isset($actualities[$pid])) $actualities[$pid] = 0;

			// Pas plus de 3 actualités consécutives d'un seul membre
			if(is_object($lastg) && $pid == $lastg->getProfil()->getId())
			{
				if(++$i >= 4)
				{
					// pas plus de 18 actualités de ce type par membre
					if(++$actualities[$pid] > 10) continue;
					if($actualities[$pid] == 1) $ajouts[$pdate] = array("adhesion", $g, "similarFirst");
					else $ajouts[$pdate] = array("adhesion", $g, "similar");

					++$over;
					$lastg = $g;
					continue;
				}
			}
			else {
				$i=1;
			}

			$ajouts[$pdate] = array("adhesion", $g);
			$lastg = $g;
		}

		foreach($dataFiles as $g) { $ajouts[strtotime($g->getDate())] = array("files", $g); }

		// Profils (mises en relation)
		$lastg = false;
		$data =	Doctrine_Query::create()
				->from('ProfilProfil p')
				->leftJoin('p.Contact')
				->leftJoin('p.Profil')
				->andWhere('p.contact_id != ?', $this->getId())
				->andWhere('p.is_activated = 1')
				->useResultCache(true, 300)
				->limit(15);

		if($all == false) $data = $data->where('p.profil_id IN ('.implode(',', $listfriend).')')->execute();
		else $data = $data->execute();

		foreach($data as $g) {
			if(is_object($lastg) && $g->getContact()->getId() == $lastg->getProfil()->getId() && $g->getProfil()->getId() == $lastg->getContact()->getId()) { $lastg = $g; continue; }
			$ajouts[strtotime($g->getDate())] = array("friend", $g);
			$lastg = $g;
		}

		// Dernières opérations
		krsort($ajouts);

		$i=0;
		foreach($ajouts as $key => $ajout)
		{
			if(++$i > 60 + $over) unset($ajouts[$key]);
		}

		return $ajouts;
	}

	public function getCommune()
	{
		$commune = Doctrine_Query::create()
								->from('Commune p')
								->where('p.code_postal = ?', $this->getCodePostal())
								->limit(1)
								->useResultCache(true, 8000)
								->execute();

		return (isset($commune[0]) ? $commune[0] : false);
	}

	public function getPays()
	{
		$com = $this->getCommune();

		if($com)
		{
			try {
				if($com->getPaysId())
					return $com->getPays();
				else
					return false;
			}
			catch (Exception $e)
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	public function getProfilsConnexes()
	{
		$filieres = $this->getProjetFiliere();
		$results = array();

		foreach($filieres as $f)
		{
			$results[] = $f->getFiliereId();
		}

		if(!count($results)) return array();

		return Doctrine_Query::create()
							->from('ProjetFiliere p')
							->where('p.filiere_id IN ('.implode(',', $results).')')
							->andWhere('p.projet_id != ?', $this->getId())
							->orderBy("RANDOM()")
							->limit(3)
							->useResultCache(true)
							->execute();
	}
}
