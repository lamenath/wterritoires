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

class RRR
{
	static $sidebar;
	static $pager = array();
	static $total = 0;
	static $hod = false;

	static function to_csv($arrays)
	{
		$string = '';
		$c=0;
		foreach($arrays AS $array) {
			unset($array["cell"]);
			
			$val_array = array();
			$key_array = array();
			foreach($array AS $key => $val) {
				$key_array[] = $key;
				$val = str_replace('"', '""', $val);
				$val_array[] = "\"$val\"";
			}
			if($c == 0) {
				$string .= implode(",", $key_array)."\n";
			}
			$string .= implode(",", $val_array)."\n";
			$c++;
		}

		return $string;
	}
 
	static function replace_relation($model, $old_id, $new_id, $models=array())
	{
		$old = Doctrine::getTable($model)->find($old_id);
		$new = Doctrine::getTable($model)->find($new_id);
		$id = strtolower($model) . "_id";
		
		// Parcourir les relations
		foreach($models as $table)
		{
			$items = Doctrine_Query::create()
							->from($table)
							->where($id."=?", $old->getId())
							->execute();
							
			foreach($items as $item)
			{
				try
				{
					$item->set($id, $new->getId());
					$item->save();
				}
				catch(Exception $e)
				{
					$item->delete();
				}
			}
		}
		
		$old->delete();
	}
	
	static function pager($query, $class, $np=10)
	{
		$numPage = sfContext::getInstance()->getRequest()->getParameter('page');
		$nbPosts = sfConfig::get('app_posts_number_per_page', $np);

		$pager = new sfDoctrinePager($class, $nbPosts);

		$pager->setQuery($query);
		$pager->setPage($numPage);
		$pager->init();

		self::$pager = $pager;
		self::$total = $pager->getNbResults();

		return array(self::$pager, self::$total);
	}

	static function wikipedia($s, $lang="en")
	{
		$url = "http://".$lang.".wikipedia.org/w/api.php?action=opensearch&search=".urlencode($s)."&format=xml&limit=1";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
		curl_setopt($ch, CURLOPT_POST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_NOBODY, FALSE);
		curl_setopt($ch, CURLOPT_VERBOSE, FALSE);
		curl_setopt($ch, CURLOPT_REFERER, "");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; he; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8");
		$page = curl_exec($ch);
		$xml = simplexml_load_string($page);

		if(isset($xml->Section->Item->Description) && (string)$xml->Section->Item->Description)
		{
			return array((string)$xml->Section->Item->Text, (string)$xml->Section->Item->Description, (string)$xml->Section->Item->Url);
		}
		else
		{
			return false;
		}
	}

	static function genericCrop($fileName, $directory = "")
	{
		// Create the thumbnail
		$thumbnail = new sfThumbnail(218, 140,  false, false, 80, "sfImageMagickAdapter", array('convert' => '/usr/local/bin/convert', 'method' => 'shave_all'));
		$thumbnail->loadFile(sfConfig::get('sf_upload_dir').'/'.$directory.'/' . $fileName);
		$thumbnail->save(sfConfig::get('sf_upload_dir').'/'.$directory.'/max_'.$fileName, 'image/png');

		// Create the thumbnail
		$thumbnail = new sfThumbnail(95, 60,  false, false, 80, "sfImageMagickAdapter", array('convert' => '/usr/local/bin/convert', 'method' => 'shave_all'));
		$thumbnail->loadFile(sfConfig::get('sf_upload_dir').'/'.$directory.'/' . $fileName);
		$thumbnail->save(sfConfig::get('sf_upload_dir').'/'.$directory.'/normal_'.$fileName, 'image/png');

		// Create the thumbnail
		$thumbnail = new sfThumbnail(60, 60, false, false, 80, "sfImageMagickAdapter", array('convert' => '/usr/local/bin/convert', 'method' => 'shave_all'));
		$thumbnail->loadFile(sfConfig::get('sf_upload_dir').'/'.$directory.'/' . $fileName);
		$thumbnail->save(sfConfig::get('sf_upload_dir').'/'.$directory.'/mini_'.$fileName, 'image/png');
	}

	static function genericCropGal($fileName, $directory = "")
	{
		// Create the thumbnail
		$thumbnail = new sfThumbnail(120, 80,  false, false, 90, "sfImageMagickAdapter", array('convert' => '/usr/local/bin/convert', 'method' => 'shave_all'));
		$thumbnail->loadFile(sfConfig::get('sf_upload_dir').'/'.$directory.'/' . $fileName);
		$thumbnail->save(sfConfig::get('sf_upload_dir').'/'.$directory.'/std_'.$fileName, 'image/png');

		// Create the thumbnail
		$thumbnail = new sfThumbnail(800, 533,  false, false, 90, "sfImageMagickAdapter", array('convert' => '/usr/local/bin/convert', 'method' => 'shave_all'));
		$thumbnail->loadFile(sfConfig::get('sf_upload_dir').'/'.$directory.'/' . $fileName);
		$thumbnail->save(sfConfig::get('sf_upload_dir').'/'.$directory.'/max_'.$fileName, 'image/png');

		// Create the thumbnail
		$thumbnail = new sfThumbnail(60, 60, false, false, 90, "sfImageMagickAdapter", array('convert' => '/usr/local/bin/convert', 'method' => 'shave_all'));
		$thumbnail->loadFile(sfConfig::get('sf_upload_dir').'/'.$directory.'/' . $fileName);
		$thumbnail->save(sfConfig::get('sf_upload_dir').'/'.$directory.'/mini_'.$fileName, 'image/png');
	}

	static function give_ids($array)
	{
		$r = array();

		foreach($array as $i)
		{
			$r[] = $i["id"];
		}

		return $r;
	}

	static function getExtPic($file)
	{
		$extension = pathinfo($file,  PATHINFO_EXTENSION);
		$type = "Word";

		switch($extension)
		{
			case "pdf":
				$type = "Pdf";
				break;
			case "doc":
				$type = "Word";
				break;
			case "docx":
				$type = "Word";
				break;
			case "ppt":
				$type = "PowerPoint";
				break;
			case "xls":
				$type = "Excel";
				break;
			default:
				$type = "Word";
			break;
		}

		return $type . "_Icon_PNG.png";
	}

	static function getTotalActors()
	{
		return Doctrine_Query::create()
							->from("ProfilProjet p")
							->where("p.role=?", "observateur")
							->useResultCache(true, 86400)
							->count();
	}

	static function getTotalObservers()
	{
		return Doctrine_Query::create()
							->from("ProfilProjet p")
							->where("p.role!=?", "observateur")
							->useResultCache(true, 86400)
							->count();
	}

	static function getTotalEvents()
	{
		return Doctrine_Query::create()
							->from("Event p")
							->useResultCache(true, 86400)
							->count();
	}

	static function getTotalDocs()
	{
		return Doctrine_Query::create()
							->from("Ressource p")
							->useResultCache(true, 86400)
							->count();
	}

	static function getTotalMembers()
	{
		return Doctrine_Query::create()
							->from("Profil p")
							->useResultCache(true, 86400)
							->count();
	}

	static function getTotalProjects()
	{
		return Doctrine_Query::create()
							->from("Projet p")
							->useResultCache(true, 86400)
							->count();
	}

	static function public_profile($user_id, $slug = false)
	{
		if($user_id instanceof  sfOutputEscaperArrayDecorator)
			$user_id = $user_id->getRawValue();

		if(is_array($user_id))
		{
			$user = $user_id;
		}
		else
		{
			$user = Doctrine_Query::create()
										->from("Profil p")
										->leftJoin("p.ProfilFiliere pf")
										->leftJoin("pf.Filiere f")
										->leftJoin("p.ProfilTheme pt")
										->leftJoin("pt.Theme t")
										->leftJoin("p.ProfilStructure ps")
										->leftJoin("ps.Structure s")
										->where("p.id=?", $user_id)
										->orWhere("p.slug=?", $user_id)
										->fetchOne(array(), Doctrine::HYDRATE_ARRAY);
		}

		// Set User Data
		$user["full_name"] = ucfirst(trim($user["prenom"])) . " " . mb_strtoupper($user["nom"], "UTF-8");

		if(file_exists(sfConfig::get('sf_upload_dir')."/profil/mini_".$user["photo"]))
			$user["photo_mini"] = "mini_" . $user["photo"];
		else
			$user["photo_mini"] = "default.png";

		return $user;
	}

	static function profile_projects($user_id, $role = false)
	{
		$user = Doctrine_Query::create()
								->from("ProfilProjet p")
								->leftJoin("p.Projet pc")
								->where("p.profil_id=?", $user_id);

		if($role !== false)
			$user = $user->andWhere("p.role=?", $role);

		return $user->execute(array(), "project_light");
	}

	static function cut_text($text, $long)
	{
		$new = mb_substr($text, 0, $long,  'UTF-8');
		if(mb_strlen($text, 'UTF-8') > $long) $new .= '...';

		return $new;
	}

	// code derived from http://php.vrana.cz/vytvoreni-pratelskeho-url.php
	static public function slugify($text)
	{
		setlocale(LC_ALL, 'fr_FR.UTF8');

		// replace non letter or digits by -
		$text = preg_replace('~[^\\pL\d]+~u', '-', $text);

		// trim
		$text = trim($text, '-');

		// transliterate
		if (function_exists('iconv'))
		{
			$text = iconv('utf-8', 'ASCII//TRANSLIT', $text);
		}

		// lowercase
		$text = strtolower($text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		if (empty($text))
		{
			return 'n-a';
		}

		return $text;
	}

	// send mail
	static function sendMail($mailBody, $sujet, $to, $from = null)
	{
		if($from == null) $from = sfConfig::get("app_email");

		try
		{
		  $transport = Swift_MailTransport::newInstance();
		  $mailer = Swift_Mailer::newInstance($transport);

		  $message = Swift_Message::newInstance($sujet)
			  ->setFrom(array($from))
			  ->setTo(array($to))
			  ->setBody($mailBody, 'text/html') ;

		  $mailer->send($message);
		}
		catch (Exception $e)
		{
		  $mailer->disconnect();
		}
	}

	static function sendMailHybrid($mailBody, $sujet, $to, $from = null)
	{
		if($from == null) $from = array(sfConfig::get("app_email"));
		elseif(!is_array($from)) $from = array($from);

		$transport = Swift_SmtpTransport::newInstance(sfConfig::get("app_mail_server"), 25);
		$mailer = Swift_Mailer::newInstance($transport);

		try
		{
		  $message = Swift_Message::newInstance($sujet)
			  ->setFrom($from)
			  ->setTo(array($to))
			  ->setBody(nl2br($mailBody), 'text/html');

		  $message->addPart(strip_tags($mailBody), 'text/plain');

		  $mailer->send($message);
		}
		catch (Exception $e)
		{
	// nothing
		}
	}

	static function complexMail($sujet, $dest, $mailBody, $instance, $txt = false)
	{
		// Envoi du mail
		sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
		$transport = Swift_SmtpTransport::newInstance(sfConfig::get("app_mail_server"), 25);
		$mailer = Swift_Mailer::newInstance($transport);

		$message  = $instance->setCharset("UTF-8")
								->setSubject($sujet)
							    ->setFrom(array(sfConfig::get("app_email") => "Réseau Rural Picardie"))
							    ->setTo(array($dest));

		$message->setBody($mailBody, 'text/html') ;

		if($txt) $message->addPart(strip_tags($mailBody), 'text/plain');

		//$message->addPart($im . Worketer::gs('notice_bottom', $long->code), 'text/plain'); text

		$mailer->send($message);
	}

}

?>