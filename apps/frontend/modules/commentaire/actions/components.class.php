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

class commentaireComponents extends sfComponents
{
	public function executeList(sfWebRequest $request)
	{
		$this->comments = Doctrine_Query::create()
												->from('Commentaire c')
												->leftJoin("c.Profil p")
												->where("c.content_type = ?", $this->ctype)
												->andWhere("c.content_id = ?", $this->cid)
												->orderBy("c.created_at DESC")
												->execute(array(), "commentaire");
	}
}

?>