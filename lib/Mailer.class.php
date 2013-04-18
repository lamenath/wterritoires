<?php

/**
	wTerritoires <http://www.wterritoires.fr/>
	Copyright (C) 2010 Simon Lamellière <opensource@worketer.fr>

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU Affero General Public License as published by
	the Free Software Foundation, either version 3 of the License,  or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU Affero General Public License for more details.

	You should have received a copy of the GNU Affero General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
**/

class rMail
{
	public $email = false;
	public $user_id = 0;
	public $disable_signature = false;
	public $force_email = false;
	public $subject = false;
	public $message = false;
	public $force = false;
	public $content_type = false;
	public $content_options = array();
	public $sender = array();
	private $content = "";
	private $user; // a generic_profile array

	static function create($uid, $subject="", $content_type = "notification", $content_options = array(), $force=false, $force_email=false)
	{
		return new rMail($uid, $subject, $content_type, $content_options, $force, $force_email);
	}

	public function __construct($uid, $subject="", $content_type = "notification", $content_options = array(), $force=false, $force_email=false)
	{
		sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');

		$this->sender = array(sfConfig::get("app_email") => sfConfig::get("app_email_name"));
		$this->user_id = $uid;
		$this->force_email = $force_email;
		$this->pimg = sfConfig::get("app_filer_user_big_mini") . sfConfig::get("app_filer_default_image");
		$this->subject = $subject;
		$this->force = $force;
		$this->attach = false;
		$this->content_type = $content_type;
		$this->content_options = $content_options;

		// Force in dev (pour éviter les erreurs)
		$this->force_email = (sfConfig::get("app_force_email") ? sfConfig::get("app_force_email") : $force_email);

		return $this;
	}

	public function send($realtime_status=false)
	{
		if($this->prepare($realtime_status))
		{
			try {
				sfContext::getInstance()->getMailer()->send($this->message);
			}
			catch(Exception $e)
			{
				error_log($e->getMessage());
			}
		}

		return true;
	}

	private function prepare($realtime_status)
	{
		if(!$this->__determinate_body($realtime_status))
			return false;

		if(sfConfig::get("app_enable_mailer") == false && $this->force == false)
			return false;

		try
		{
			$message2 = Swift_Message::newInstance()
										->setCharset("UTF-8")
										->setSubject($this->subject)
										->setFrom($this->sender)
										->setTo(
											(
												$this->force_email !== false ?
												array($this->force_email)
												:
												(is_array($this->email) ? $this->email : array($this->email))
											)
										);

			// Get Std Structure for Mail
			if($this->content_type == "raw")
			{
				$this->content = preg_replace("/{full_name}/ui", $this->user["full_name"], $this->content);
				$structure = $this->content;
			}
			else
			{
				$structure = get_partial("templates/struct", array(
					"title" => $this->subject,
					"disable_signature" => $this->disable_signature,
					"name" => $this->user["full_name"],
					"content" => $this->content,
					"link" => $this->content_options["link"],
					"link_text" => $this->content_options["link_text"],
					"logo" => $message2->embed(Swift_Image::fromPath(dirname(__FILE__)."/../web/".sfConfig::get("app_email_logo")))
					)
				);
			}

			$message2->setBody($structure, 'text/html');
			$this->message = $message2;
		}
		catch(Exception $e)
		{
			return false;
		}

		return true;
	}

	private function __determinate_body($realtime_status)
	{
		// Fetch User
		$this->user = Doctrine_Query::create()->from("Profil")->where("id=?", $this->user_id)->fetchOne(array(), "profile_light");
		
		if($this->content_type == "raw")
		{
			$this->email = $this->user["email"];
			return $this->content = $this->content_options["html"];
		}
	
		// Fetch User
		$this->automatic_sender = Doctrine_Query::create()->from("Profil")->where("id=?", sfContext::getInstance()->getUser()->getId())->fetchOne(array(), "profile_light");
		$this->content_options["automatic_sender"] = $this->automatic_sender;

		// User exists ?
		if((!isset($this->user["id"]) || $this->user["id"] == 0) && $this->force_email === false)
			return false;

		switch($this->content_type)
		{
			case "subscribe":
				$this->sender = array(sfConfig::get("app_support") => sfConfig::get("app_email_name"));
				$this->subject = sfContext::getInstance()->getI18N()->__("%fname, votre inscription au Réseau Rural Régional %type", array("%type" => sfConfig::get("app_rrr_complete"), "%fname" => $this->user["prenom"]));
				$this->email = $this->user["email"];
				$this->content_options["link"] = sfConfig::get("app_url") . "profile/" . $this->user["login"];
				$this->content_options["link_text"] =  sfContext::getInstance()->getI18N()->__("Connectez-vous au Réseau Rural Régional");

				return $this->content = get_partial("templates/subscribe", array(
					"full_name" => $this->user["full_name"],
					"login" => $this->user["login"],
					"password" => $this->content_options["password"]
				));
			break;
			case "lost":
				$this->sender = array(sfConfig::get("app_support") => sfConfig::get("app_email_name"));
				$this->subject = sfContext::getInstance()->getI18N()->__("%fname, votre demande de changement de mot de passe...", array("%fname" => $this->user["prenom"]));
				$this->email = $this->user["email"];
				$this->content_options["link_text"] = $this->content_options["link"];

				return $this->content = get_partial("templates/lost", array(
					"full_name" => $this->user["full_name"]
				));
			break;
			case "inbox":
				$this->sender = array(sfConfig::get("app_support") => sfConfig::get("app_email_name"));
				$this->subject = sfContext::getInstance()->getI18N()->__("%fname vous a envoyé un message privé", array("%fname" => $this->content_options["sender"]));
				$this->email = $this->user["email"];
				$this->content_options["link_text"] = $this->content_options["link"] = sfContext::getInstance()->getController()->genUrl("@inbox", true);
				$this->disable_signature = true;
				
				return $this->content = get_partial("templates/inbox", array_merge(array("you" => $this->user["full_name"]), $this->content_options));
			break;
			case "invite":
				$this->sender = array(sfConfig::get("app_support") => sfConfig::get("app_email_name"));
				$this->subject = sfContext::getInstance()->getI18N()->__("%fname vous invité à rejoindre %content", array("%content" => $this->content_options["name"], "%user" => $this->user["full_name"], "%fname" => $this->content_options["inviter"]));
				$this->email = $this->user["email"];
				$this->disable_signature = true;

				return $this->content = get_partial("templates/invite", array_merge(array("you" => $this->user["full_name"]), $this->content_options));
			break;
			
			case "wishp":
				$this->sender = array(sfConfig::get("app_support") => sfConfig::get("app_email_name"));
				$this->subject = sfContext::getInstance()->getI18N()->__("%user souhaite rejoindre le groupe privé %name", array("%user" => $this->content_options["uname"], "%name" => $this->content_options["gname"]));
				$this->email = $this->user["email"];
				$this->disable_signature = true;
				$this->content_options["link_text"] = $this->content_options["link"] = sfContext::getInstance()->getController()->genUrl("home/invitations", true);
				
				return $this->content = get_partial("templates/wishp", array_merge(array("you" => $this->user["full_name"]), $this->content_options));
			break;
			
			case "wisha":
				$this->sender = array(sfConfig::get("app_support") => sfConfig::get("app_email_name"));
				$this->subject = sfContext::getInstance()->getI18N()->__("Vous faites maintenant partie du groupe de travail '%content'", array("%content" => $this->content_options["gname"]));
				$this->email = $this->user["email"];
				$this->disable_signature = true;
				$this->content_options["link_text"] = $this->content_options["link"] = $this->content_options["gurl"];
				
				return $this->content = get_partial("templates/wisha", array_merge(array("you" => $this->user["full_name"]), $this->content_options));
			break;
			
			case "upgrade":
				$this->sender = array(sfConfig::get("app_support") => sfConfig::get("app_email_name"));
				$this->subject = sfContext::getInstance()->getI18N()->__("%fname vous a nommé référent du projet %content", array("%content" => $this->content_options["name"], "%fname" => $this->content_options["inviter"]));
				$this->email = $this->user["email"];
				$this->disable_signature = true;
				$this->content_options["link_text"] = $this->content_options["link"] = $this->content_options["url"];

				return $this->content = get_partial("templates/upgrade", array_merge(array("you" => $this->user["full_name"]), $this->content_options));
				break;
			case "frequest":
				$this->sender = array(sfConfig::get("app_support") => sfConfig::get("app_email_name"));
				$this->email = $this->user["email"];
				$this->disable_signature = true;

				if($this->content_options["direction"] == "notify")
				{
					$this->subject = sfContext::getInstance()->getI18N()->__("%fname souhaite entrer en contact avec vous", array("%fname" => $this->automatic_sender["full_name"]));
					$this->content_options["link_text"] = $this->content_options["link"] = sfContext::getInstance()->getController()->genUrl("@invitations", true);
				}
				else
				{
					$this->subject = sfContext::getInstance()->getI18N()->__("%fname a accepté votre demande de mise en relation", array("%fname" => $this->automatic_sender["full_name"]));
					$this->content_options["link_text"] = $this->content_options["link"] = $this->automatic_sender["url"];
				}

				return $this->content = get_partial("templates/frequest", array_merge(array("you" => $this->user["full_name"]), $this->content_options));

			break;
			case "mailing":
				$this->sender = array(sfConfig::get("app_support") => sfConfig::get("app_email_name"));
				$this->subject = sfContext::getInstance()->getI18N()->__("[%content] Message aux membres", array("%content" => $this->content_options["name"], "%user" => $this->user["full_name"], "%fname" => $this->content_options["inviter"]));
				$this->email = $this->user["email"];
				$this->disable_signature = true;

				return $this->content = get_partial("templates/mailing", array_merge(array("you" => $this->user["full_name"]), $this->content_options));
				break;
			default:
				return false;
			break;
		}
	}

}

?>