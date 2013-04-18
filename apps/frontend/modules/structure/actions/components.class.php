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

class structureComponents extends sfComponents
{
	public function executeSidebar()
	{

	}

	// Reusable list (horizontal)
	public function executeIndex(sfWebRequest $request)
	{
		$structures = Doctrine_Query::create()
											->select("s.*")
											->from("Structure s")
											->leftJoin("s.Profil p")
											->leftJoin("s.Theme t")
											->leftJoin("s.Filiere f")
											->leftJoin("s.Metier m")
											->leftJoin("s.Competence c");

		// My Structures
		if(isset($this->homepage))
		{
			$structures->where("(s.createur_id=?", $this->getUser()->getId())
						->orWhere("s.id IN (SELECT x.structure_id FROM ProfilStructure x WHERE x.profil_id=?))", $this->getUser()->getId());
		}


		if($term = $request->getParameter("search"))
		{
			$structures->andWhere("m.nom LIKE ? OR f.nom LIKE ? OR s.nom LIKE ? OR t.nom LIKE ? OR c.nom LIKE ?", array("%".$term."%","%".$term."%","%".$term."%","%".$term."%","%".$term."%"));
		}

		list($this->pager, $this->total) = RRR::pager($structures, "Structure");
	}

	public function executeMine()
	{

	}
}

?>