<?php

/***
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

class defaultComponents extends sfComponents
{
	public function executeNews(){}
	public function executeMap(){}

	public function executeContacts(sfWebRequest $request)
	{
		$friends = Doctrine_Query::create()
										->from('ProfilProfil p')
										->leftJoin("p.Profil c")
										->where("p.contact_id=?", $this->getUser()->getId())
										->andWhere('p.is_activated = 1')
										->orderBy("c.nom ASC");

		if($term = $request->getParameter("search"))
		{
			$friends->andWhere("(CONCAT(TRIM(c.nom), ' ', TRIM(c.prenom)) LIKE ? OR CONCAT(TRIM(c.prenom), ' ', TRIM(c.nom)) LIKE ?)", array("%".$term."%", "%".$term."%"));
		}

		$this->pager($friends, $request);
	}

	protected function pager($query, sfWebRequest $request)
	{
		$numPage = $request->getParameter('page', $request->getParameter("page"));
		$nbPosts = sfConfig::get('app_posts_number_per_page', 10);

		$this->pager = new sfDoctrinePager('Profil', $nbPosts);

		$this->pager->setQuery($query);
		$this->pager->setPage($numPage);
		$this->pager->init();

		$this->total = $this->pager->getNbResults();
	}

	public function executeInvitations()
	{
		$cond = isset($this->home);

		// Wish list
		$this->wish = Doctrine_Query::create()
										->from('WishInvitation w')
										->leftJoin("w.Profil ppn")
										->where("w.projet_id IN (SELECT p1.projet_id FROM ProfilProjet p1 LEFT JOIN p1.Projet p2 ON p1.projet_id = p2.id WHERE p1.profil_id=? AND p1.role='referent')", $this->getUser()->getId())
										->andWhere("w.hidden = 0");
		
		if($cond)
			$this->wish = $this->wish->count();
		else
			$this->wish = $this->wish->execute(array(), "profile_light");
		
		// Friends
		$this->frequests = Doctrine_Query::create()
										->from('ProfilProfil p')
										->leftJoin("p.Profil c")
										->where("p.contact_id=?", $this->getUser()->getId())
										->andWhere('p.is_activated = 0');
		if($cond)
			$this->frequests = $this->frequests->count();
		else
			$this->frequests = $this->frequests->execute(array(), "profile_light");

		// Event invitations
		$this->erequests = Doctrine_Query::create()
										->from('Invitation p')
										->leftJoin("p.Event c")
										->where("p.profil_id=?", $this->getUser()->getId())
										->andWhere('p.event_id IS NOT NULL')
										->andWhere("p.hidden IS NULL");

		if($cond)
			$this->erequests = $this->erequests->count();
		else
			$this->erequests = $this->erequests->execute(array(), "event_light");

		// Project invitations
		$this->prequests = Doctrine_Query::create()
										->from('Invitation p')
										->leftJoin("p.Projet c")
										->where("p.profil_id=?", $this->getUser()->getId())
										->andWhere('p.projet_id IS NOT NULL')
										->andWhere("p.hidden IS NULL");

		if($cond)
			$this->prequests = $this->prequests->count();
		else
			$this->prequests = $this->prequests->execute(array(), "project_light");

		// Total des invitations
		if($cond)
			$this->total = $this->prequests + $this->frequests + $this->wish + $this->erequests;
		else
			$this->total = count($this->prequests) + count($this->wish) + count($this->frequests) + count($this->erequests);
	}
}