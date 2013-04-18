<?php

/**
   wTerritoires <http://www.wterritoires.fr/>
   Copyright (C) 2011 Simon Lamellière <opensource@worketer.fr>

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details.

   You should have received a copy of the GNU Affero General Public License
   along with this program.  If not, see <http://www.gnu.org/licenses/>.
**/

class profileComponents extends sfComponents
{
	public function executeSidebar()
	{
		$this->profilref = RRR::profile_projects($this->user["id"], "referent");
		$this->profilcon = RRR::profile_projects($this->user["id"], "contributeur");
		$this->profilobs = RRR::profile_projects($this->user["id"], "observateur");
		
		$this->events = Doctrine_Query::create()
										->from("EventInvite r")
										->leftJoin("r.Event")
										->where("r.etat = ?", "yes")
										->andWhere("r.profil_id=?", $this->user["id"])
										->execute(array(), "event_light");
		
		$this->actorC = count($this->profilref) + count($this->profilcon);
		$this->obserC = count($this->profilobs);
		$this->name = $this->user["prenom"];
	}

	public function executeSuggest()
	{
		$contacts = $this->getUser()->getFriendsIds();

		$this->profiles = Doctrine_Query::create()
										->from("Profil p")
										->leftJoin("p.Filiere f")
										->leftJoin("p.Competence c")
										->where("c.id IN (SELECT r3.competence_id FROM ProfilCompetence r3 WHERE r3.profil_id = ?) OR f.id IN (SELECT r2.filiere_id FROM ProfilFiliere r2 WHERE r2.profil_id = ?)", array($this->getUser()->getId(), $this->getUser()->getId()))
										->andWhereNotIn("p.id", $contacts)
										->andWhere("p.id != ?", $this->getUser()->getId())
										->andWhere("p.photo IS NOT NULL")
										->limit(5)
										->orderBy("RAND()")
										->execute(array(), "profile_light");
	}

	public function executeMembers()
	{
		
	}
	
	public function executeReminder()
	{
		$user = $this->getUser()->getObject();
		$cont = sfContext::getInstance()->getController();
		$i18n = sfContext::getInstance()->getI18n();
		
		$my_structures = Doctrine_Query::create()
										->from("ProfilStructure p")
										->leftJoin("p.Structure s")
										->where("p.profil_id=?", $this->getUser()->getId())
										->execute(array(), "structure");
										
		$my_projects = Doctrine_Query::create()
										->from("Projet s")
										->where("s.createur_id=?", $this->getUser()->getId())
										->count();
		
		$this->tests = array(
			array($user->getFiliere()->count(), $cont->genUrl("@profileedit?proute=relations"), $i18n->__("Dans quelle <b>fillière</b> je travaille")),
			array($user->getTheme()->count(), $cont->genUrl("@profileedit?proute=relations"), $i18n->__("Quels sont <b>mes thèmes d'intérêt</b>")),
			array($user->getMetier()->count(), $cont->genUrl("@profileedit?proute=relations"), $i18n->__("Quel est <b>mon métier</b>")),
			array($user->getCompetence()->count(), $cont->genUrl("@profileedit?proute=relations"), $i18n->__("Quelles sont <b>mes compétences</b>")),
			array($user->getStructure()->count(), $cont->genUrl("@profileedit?proute=structures"), $i18n->__("Quelle(s) <b>entreprise(s) ou organisation(s)</b> je représente sur le Réseau")),
			array($user->getProjet()->count(), $cont->genUrl("projects/list"), $i18n->__("Observer des projets ou contribuer : <b>voir la liste complète des projets du Réseau</b>")),
		);
		
		// Check My Structures
		foreach($my_structures as $struct)
		{
			if($struct["ACL"]["write"] == 1 && $struct["ville"] == "")
			{
				$this->tests[] = array(0, $cont->genUrl("structure/edit?id=".$struct["id"]), $i18n->__("Votre structure: complétez la fiche \"%name\"", array("%name" => $struct["nom"])) );
			}
		}
		
		// Check My Projects
		if($my_projects == 0)
			$this->tests[] = array(0, $cont->genUrl("project/edit"), $i18n->__("Promouvoir mes projet : <b>créer ma 1ère fiche projet</b>") );
		
		// Rendu
		foreach($this->tests as $k => $t)
		{
			if($t[0] > 0)
				unset($this->tests[$k]);
		}
	}
}

?>