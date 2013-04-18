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

class Story extends BaseStory
{
	static $relation_model = null;
	static $relation_id = null;
	static $created_at = null;

	static function set_relation($model, $id)
	{
		self::$relation_id = $id;
		self::$relation_model = $model;
	}

	static function publish($method="default", $model="", $object_id=false, $creator_id=false, $type="", $message="", $params = array(), $buddies=array(), $remove_similar=false)
	{
		switch($method)
		{
			case "default";
				return self::method_default($object_id, $model, $creator_id, $type, $message, $params, $remove_similar);
			break;
			case "photo":
				// increment if possible
				$sId = self::method_photo($object_id, $model, $creator_id, $type, $message, $params, $remove_similar);
				return $sId;
			break;
			case "invite";
				$sId = self::method_default($object_id, $model, $creator_id, $type, $message, $params, $remove_similar);
				self::method_invite($sId, $buddies);
				return $sId;
			break;
			default:
				return null;
			break;
		}
	}

	// Utile dans le cas d'une suppression totale d'un objet
	static function erase_all($model="", $object_id=false)
	{
		Doctrine_Query::create()
								->delete("Story")
								->where("(object_id=?", $object_id)
								->andWhere("object_model=?)", $model)
								->orWhere("(relation_id = ?", $object_id)
								->andWhere("object_model=?)", $model)
								->execute();
	}
	
	static function erase($model="", $object_id=false, $creator_id=false, $type="")
	{
		Doctrine_Query::create()
								->delete("Story")
								->where("profil_id=?", $creator_id)
								->andWhere("object_id=?", $object_id)
								->andWhere("object_model=?", $model)
								->andWhere("type=?", $type)
								->execute();
	}

	static function method_default($object_id=false, $model="", $creator_id=false, $type, $message, $params = array(), $remove_similar)
	{
		if($creator_id !== false && $object_id !== false)
		{
			// Remove similar sotires
			if($remove_similar === true)
			{
				Doctrine_Query::create()
								->delete("Story")
								->where("profil_id=?", $creator_id)
								->andWhere("object_id=?", $object_id)
								->andWhere("object_model=?", $model)
								->andWhere("type=?", $type)
								->execute();
			}

			// Save the newest story
			try {
				$story = new Story();
				$story->setProfilId($creator_id);
				$story->setObjectId($object_id);
				$story->setObjectModel($model);
				$story->setRelationId(self::$relation_id);
				$story->setRelationModel(self::$relation_model);
				$story->setType($type);
				$story->setStoryI18n($message);
				$story->setParams(serialize($params));
				$story->save();

				if(self::$created_at !== null)
				{
					$story->setCreatedAt(self::$created_at);
					$story->save();
				}

				$sId = $story->getId();
			}
			catch(Exception $e)
			{
				return null;
			}

			return $sId;
		}
	}
	
	static function method_photo($object_id=false, $model="", $creator_id=false, $type, $message, $params = array(), $remove_similar)
	{
		if($creator_id !== false && $object_id !== false)
		{
			// Are Similar Recent Stories
			if($remove_similar === true)
			{
				Doctrine_Query::create()
								->delete("Story")
								->where("profil_id=?", $creator_id)
								->andWhere("object_id=?", $object_id)
								->andWhere("object_model=?", $model)
								->andWhere("type=?", $type)
								->execute();
			}
			
			// Recent stories ?
			$story = Doctrine_Query::create()
							->from("Story")
							->where("profil_id=?", $creator_id)
							->andWhere("object_model=?", $model)
							->andWhere("relation_model=?", self::$relation_model)
							->andWhere("relation_id=?", self::$relation_id)
							->andWhere("type=?", $type)
							->andWhere("updated_at >= ?", date("Y-m-d H:i:s", strtotime("-10 minutes")))
							->orderBy("updated_at DESC")
							->fetchOne();

			if($story)
			{
				$story->setUpdatedAt(new Doctrine_Expression("NOW()"));
				$story->save();
				$sId = $story->getId();
			}
			else
			{
				// Save the newest story
				try {
					$story = new Story();
					$story->setProfilId($creator_id);
					$story->setObjectId($object_id);
					$story->setObjectModel($model);
					$story->setRelationId(self::$relation_id);
					$story->setRelationModel(self::$relation_model);
					$story->setType($type);
					$story->setStoryI18n($message);
					$story->setParams(serialize($params));
					$story->save();
	
					if(self::$created_at !== null)
					{
						$story->setCreatedAt(self::$created_at);
						$story->save();
					}
	
					$sId = $story->getId();
				}
				catch(Exception $e)
				{
					return null;
				}
			}
			
			if($sId)
			{
				// Add photo to set
				$relation = new StoryPictures();
				$relation->setStoryId($sId);
				$relation->setPhotoId($object_id);
				$relation->save();
			}

			return $sId;
		}
	}

	static function method_invite($sId, $buddies=array())
	{
		if(count($buddies) && $sId !== null)
		{
			foreach($buddies as $pId)
			{
				try {
					$story = new StoryBuddies();
					$story->setProfilId($pId);
					$story->setStoryId($sId);
					$story->save();
				}
				catch(Exception $e)
				{
					error_log($e->getMessage());
				}
			}
		}
	}
}
