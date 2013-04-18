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

class projectComponents extends sfComponents
{
	// Reusable list (horizontal)
	public function executeList()
	{
	}

	public function executeMembers(sfWebRequest $request)
	{
		$members = Doctrine_Query::create()
										->from("ProfilProjet p")
										->leftJoin("p.Profil c")
										->where("p.projet_id=?", $this->id)
										->orderBy("p.created_at DESC");

		if($term = $request->getParameter("search"))
			$members->andWhere("(CONCAT(TRIM(c.nom), ' ', TRIM(c.prenom)) LIKE ? OR CONCAT(TRIM(c.prenom), ' ', TRIM(c.nom)) LIKE ?)", array("%".$term."%","%".$term."%"));

		list($this->pager, $this->total) = RRR::pager($members, "Profil", 10);
	}

	public function executeNews()
	{
		$this->projects = Doctrine_Query::create()
										->select("p.*, (Select count(*) from profil_projet where projet_id=p.id) as TC")
										->from("Projet p")
										->limit(3)
										->offset(0)
										->orderBy("TC DESC")
										->where("created_at > ?", date("Y-m-d 00:00:00", strtotime("-6 months")))
										->execute(array(), "project_light");
	}

	public function executeSimilar()
	{
		$filieres = RRR::give_ids($this->project["Filiere"]);
		$skills = RRR::give_ids($this->project["Competence"]);

		$this->projects = Doctrine_Query::create()
										->from("Projet p")
										->leftJoin("p.Commune com")
										->leftJoin("com.Pays x")
										->leftJoin("p.Filiere f")
										->leftJoin("p.Competence c")
										->whereIn("f.id", $filieres)
										->orWhereIn("c.id", $skills)
										->andWhere("p.id != ?", $this->project["id"])
										->limit(2)
										->orderBy("RAND()")
										->execute(array(), "project_light");
	}

	public function executePresentation(sfWebRequest $request)
	{
		
	}

	public function executeListlight()
	{
		if(isset($this->pager))
		{
			$this->total = $this->pager->getNbResults();
		}
		else
		{
			$this->total = $this->projects->count();
		}
	}

	public function executeSidebar()
	{
		// No Left Join in main query (performance)
		$this->pictures =  Doctrine_Query::create()
										->from("PhotoProjet p")
										->where("p.projet_id=?", $this->project["id"])
										->orderBy("created_at DESC")
										->execute(array(), "photo");
	}
}

?>