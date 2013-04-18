<?php

/**
	wTerritoires <http://www.wterritoires.fr/>
	Copyright (C) 2010 Simon Lamellière <opensource@worketer.fr>

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

class EventHydrator extends Doctrine_Hydrator_ArrayDriver
{
	static function hydrate($event)
	{
		sfContext::getInstance()->getConfiguration()->loadHelpers('Date');

		// Relations ?
		if(isset($event["Event"]))
		{
			$block = true;
			$old = $event;
			$event = $event["Event"];
			$event["extraData"] = $old;

			unset($old, $event["extraData"]["Event"]);
		}

		// Set correct date
		$gd = format_date($event["start_at"], 'R');
		$gd1 = explode(",", $gd);
		$gd2 = explode(" ", $gd1[1]);

		$event["date"] = array( "day" => $gd1[0],
								"num" => $gd2[1],
								"month" => $gd2[2] );

		// Set images
		$event["photo_mini"] = sfConfig::get("app_cdn_full") . "/event/" . ($event["photo"] ? "mini_" . $event["photo"] : "default.png");
		$event["photo_std"] = sfConfig::get("app_cdn_full") . ($event["photo"] ? "event/normal_" . $event["photo"] : "event/default.png");
		$event["photo_max"] = sfConfig::get("app_cdn_full") . "/event/" . ($event["photo"] ? "profil/max_" . $event["photo"] : "event/default.png");

		$event["my_response"] = sfContext::getInstance()->getUser()->isInEvent($event["id"]);

		// ACL
		if(!isset($event["ACL"]))
			$event["ACL"] = EventACL::init($event);

		$event["url"] = sfContext::getInstance()->getController()->genUrl("@event?slug=".$event["slug"], true);

		return $event;
	}

	public function hydrateResultSet($stmt)
	{
		$events = parent::hydrateResultSet($stmt);

		foreach($events as &$event)
		{
			$event = self::hydrate($event);

			// Creator
			$event["creator"] = Doctrine_Query::create()
														->from("Profil p")
														->where("p.id=?", $event["createur_id"])
														->fetchOne(array(), "profile_light");

			// Creator
			$event["referents"] = Doctrine_Query::create()
														->from("EventInvite p")
														->leftJoin("p.Profil")
														->where("p.id=?", $event["id"])
														->andWhere("etat=?", "referent")
														->execute(array(), "profile_light");

			// Guests et attendings
			$event["participants"] = Doctrine_Query::create()
														->from("EventInvite p")
														->leftJoin("p.Profil pf")
														->leftJoin("pf.ProfilCompetence rel")
														->leftJoin("rel.Competence")
														->where("p.event_id=?", $event["id"])
														->andWhere("(etat=?", "referent")
														->orWhere("etat=?)", "yes")
														->execute(array(), "profile_light");
			
			// Comptes divers
			$event["count_total"] = count($event["participants"]);
			
			$event["count_ideas"] = Doctrine_Query::create()
													->from("ProjetIdee p")
													->where("p.event_id=?", $event["id"])
													->count();

			$event["count_ressources"] = Doctrine_Query::create()
													->from("Ressource p")
													->where("p.event_id=?", $event["id"])
													->count();
			
			$event["guests"] = Doctrine_Query::create()
														->from("EventInvite p")
														->leftJoin("p.Profil")
														->where("p.event_id=?", $event["id"])
														->andWhere("etat=?", "pending")
														->execute(array(), "profile_light");

			$event["nos"] = Doctrine_Query::create()
														->from("EventInvite p")
														->leftJoin("p.Profil")
														->where("p.event_id=?", $event["id"])
														->andWhere("etat=?", "no")
														->execute(array(), "profile_light");
		}

		return $events;
	}
}

?>