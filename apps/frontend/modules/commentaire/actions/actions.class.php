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

class commentaireActions extends sfActionsJson
{
	public $ctypes = array("idea");

	public function executeVote(sfWebRequest $request)
	{
		$cid = (int)$request->getParameter("cid");

		if( $cid > 0 && in_array($request->getParameter("ctype"), $this->ctypes))
		{
			// A déjà voté ?	
			$result_still = Doctrine_Query::create()
										->from('CommentaireVote v')
										->where("v.content_type = ?", $request->getParameter("ctype"))
										->andWhere("v.content_id = ?", $cid)
										->andWhere("v.profil_id = ?", $this->getUser()->getId())
										->execute();

			if(count($result_still) == 0)
			{
				$commentaire = new CommentaireVote();
				$commentaire->setProfilId($this->getUser()->getId());
				$commentaire->setContentId($cid);
				$commentaire->setContentType($request->getParameter("ctype"));
				$commentaire->setCreatedAt(date("Y-m-d H:i:s"));
				$commentaire->save();
				
				$contents = array(	"status" => 200,
									"show_direction" => 0
								);
			}
			else
			{
				$result_still->delete();

				$contents = array(	"status" => 200,
									"show_direction" => 1
								);
			}

			$contents["current"] = Doctrine_Query::create()
											->from('CommentaireVote v')
											->where("v.content_type = ?", $request->getParameter("ctype"))
											->andWhere("v.content_id = ?", $cid)
											->count();

			$contents["text"] = sfContext::getInstance()->getI18N()->__("%nb votant(s)", array("%nb" => $contents["current"]));

			$this->setJsonContents( $contents );
		}
	}

	public function executeRemove(sfWebRequest $request)
	{
		// Continue
		if($request->getParameter("cid"))
		{
			CommentACL::init($request->getParameter("cid"), "admin", true);

			if(($request->isMethod("PUT") || $request->isMethod("POST")))
			{
				$idea = Doctrine::getTable("Commentaire")->find($request->getParameter("cid"));

				if($idea)
				{
					$idea->delete();
					$contents = array("errors" => array(), "method" => "remove", "id" => "commentaire_n_".$request->getParameter("cid"), "message" => sfContext::getInstance()->getI18n()->__("Le commentaire a été supprimé"), "status" => 200);
				}
				else
				{
					$contents = array("errors" => array(), "message" => sfContext::getInstance()->getI18n()->__("Le commentaire n'a pas pu être supprimé"), "status" => 200);
				}

				$this->setJsonContents($contents);
			}
			else
			{
				$this->isJsonable(false);
			}
		}
		else
		{
			exit;
		}
	}

	public function executeAdd(sfWebRequest $request)
	{
		sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');

		$this->form = new CommentaireFormFrontend();

		$cid = $request->getParameter("cid");

		if(($request->isMethod("PUT") || $request->isMethod("POST")))
		{
			$this->form->bind(
				$request->getParameter($this->form->getName()),
				$request->getFiles($this->form->getName())
			);

			if($this->form->isValid())
			{
				$this->form->save();

				$this->form->getObject()->setProfilId( $this->getUser()->getId() );
				$this->form->getObject()->setContentId( $cid );
				$this->form->getObject()->setContentType( $request->getParameter("ctype") );
				$this->form->getObject()->save();

				$hydrated = Doctrine_Query::create()->from("Commentaire c")->leftJoin("c.Profil")->where("id=?", $this->form->getObject()->getId())->fetchOne(array(), "commentaire");

				$contents = array("errors" => array(), "view" => get_partial("commentaire/displaycomment", array("commentaire" => $hydrated)), "status" => 200, "method" => "render");
			}
			else
			{
				$contents = array("errors" => sfActionsJson::getSfErrors($this->form), "status" => 500, "method" => "display");
			}

			$this->setJsonContents($contents);
		}
	}

	public function executeListvote(sfWebRequest $request)
	{
		sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
		$this->isJsonable(false);

		$cid = (int)$request->getParameter("cid");
		$resultat = "bad";
		$html = "...";

		if( $cid > 0 && in_array($request->getParameter("ctype"), $this->ctypes))
		{
			// Tous les votes
			$this->votes = $all_votes = Doctrine_Query::create()
													->from('CommentaireVote v')
													->leftJoin("v.Profil")
													->where("v.content_type = ?", $request->getParameter("ctype"))
													->andWhere("v.content_id = ?", $cid)
													->execute(array(), "profile_light");
		}
		else
		{
			die('WTF');
		}

		$this->setLayout(false);
	}
}

?>
