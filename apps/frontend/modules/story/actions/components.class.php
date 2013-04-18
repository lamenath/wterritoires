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

class storyComponents extends sfComponents
{
	public function executeExtract($request)
	{
		$this->stories = Doctrine_Query::create()
										->from("Story s")
										->leftJoin("s.Profil p")
										->leftJoin("s.Buddies b")
										->where("(s.object_model = ?", $this->model)
										->andWhere("s.object_id = ?)", $this->id)
										->orWhere("(s.relation_model = ?", $this->model)
										->andWhere("s.relation_id = ?)", $this->id)
										->orderBy("updated_at DESC")
										->limit(15)
										->execute(array(), "profile_light");
	}

	// Nouveautés de mon réseau
	public function executeHome($request)
	{
		$this->homepage = true;
		
		// Search stories
		$this->stories = Doctrine_Query::create()
										->from("Story s")
										->leftJoin("s.Profil p")
										->leftJoin("s.Buddies b")
										->whereIn("s.profil_id", $this->getUser()->getFriendsIds())
										->orWhere("(object_id IN (SELECT CC.projet_id FROM ProfilProjet CC WHERE CC.profil_id = ?) AND s.profil_id != ? AND object_model = 'Projet') OR (relation_id IN (SELECT DD.projet_id FROM ProfilProjet DD WHERE DD.profil_id = ?) AND s.profil_id != ? AND relation_model = 'Projet')", array($this->getUser()->getId(), $this->getUser()->getId(), $this->getUser()->getId(), $this->getUser()->getId() ) )
										->orWhere("(object_id IN (SELECT EE.event_id FROM EventInvite EE WHERE EE.profil_id = ?) AND s.profil_id != ? AND object_model = 'Event') OR (relation_id IN (SELECT FF.event_id FROM EventInvite FF WHERE FF.profil_id = ?) AND s.profil_id != ? AND relation_model = 'Event')", array($this->getUser()->getId(), $this->getUser()->getId(), $this->getUser()->getId(), $this->getUser()->getId() ) )
										->orderBy("updated_at DESC")
										->limit(24);

		$this->stories = $this->hydrate($this->stories->execute(array(), "profile_light"));
	}

	public function hydrate($feed)
	{
		foreach($feed as &$line)
		{
			switch($line["extraData"]["object_model"])
			{
				case "Projet":
					$line["extraData"]["obj"] = Doctrine_Query::create()->from("Projet p")->where("id=?", $line["extraData"]["object_id"])->useResultCache(true, 1000)->fetchOne(array(), "project_light");
					$line["extraData"]["url"] = $line["extraData"]["obj"]["url"];
					$line["extraData"]["in"] =  $line["extraData"]["obj"]["nom"];
					break;
				case "PhotoProjet":
					if($line["extraData"]["relation_model"] == "Projet")
					{
						$line["extraData"]["obj"] = Doctrine_Query::create()->from("Projet p")->where("id=?", $line["extraData"]["relation_id"])->useResultCache(true, 1000)->fetchOne(array(), "project_light");
						$line["extraData"]["in"] =  $line["extraData"]["obj"]["nom"];
					}
					elseif($line["extraData"]["relation_model"] == "Event")
					{
						$line["extraData"]["obj"] = Doctrine_Query::create()->from("Event p")->where("id=?", $line["extraData"]["relation_id"])->useResultCache(true, 1000)->fetchOne(array(), "event_light");
						$line["extraData"]["in"] =  $line["extraData"]["obj"]["titre"];
					}

					$line["extraData"]["url"] = $line["extraData"]["obj"]["url"];
					break;
				case "ProjetIdee":
				case "Ressource":
					if($line["extraData"]["relation_model"] == "Projet")
					{
						$line["extraData"]["obj"] = Doctrine_Query::create()->from("Projet p")->where("id=?", $line["extraData"]["relation_id"])->useResultCache(true, 1000)->fetchOne(array(), "project_light");
						$line["extraData"]["in"] =  $line["extraData"]["obj"]["nom"];
					}
					elseif($line["extraData"]["relation_model"] == "Event")
					{
						$line["extraData"]["obj"] = Doctrine_Query::create()->from("Event p")->where("id=?", $line["extraData"]["relation_id"])->useResultCache(true, 1000)->fetchOne(array(), "event_light");
						$line["extraData"]["in"] =  $line["extraData"]["obj"]["titre"];
					}

					$line["extraData"]["url"] = $line["extraData"]["obj"]["url"];
					break;
				case "Profil":
					$line["extraData"]["obj"] = Doctrine_Query::create()->from("Profil p")->where("id=?", $line["extraData"]["object_id"])->fetchOne(array(), "profile_light");
					$line["extraData"]["url"] = sfContext::getInstance()->getController()->genUrl("@public_profile?slug=". $line["slug"], false);
					break;
				case "Event":
					$line["extraData"]["obj"] = Doctrine_Query::create()->from("Event p")->where("id=?", $line["extraData"]["object_id"])->useResultCache(true, 1000)->fetchOne(array(), "event_light");
					$line["extraData"]["url"] = $line["extraData"]["obj"]["url"];
					$line["extraData"]["in"] =  $line["extraData"]["obj"]["titre"];
					break;
			}
		}


		return $feed;
	}
}

?>