<?php

/**
 * Theme form.
 *
 * @package    rrr
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ThemeForm extends BaseThemeForm
{
	public function configure()
	{
		unset($this["created_at"], $this["ressource_list"], $this["mailing_list"], $this["updated_at"], $this["annonce_list"], $this["projet_list"], $this["slug"], $this["segment_list"], $this["structure_list"], $this["event_list"], $this["profil_list"]);

		$relations = array(
								"replace_list" => array(
													"max" => 1,
													"min" => 0,
													"required" => false,
													"label" => "Remplacer par?",
													"input" => array( "display" => "Theme"),
		)
		);

		foreach($relations as $cname => $config)
		{
			$this->widgetSchema[$cname] = new rrWidgetRelations(
			array('label' => $config["label"]),
			array("config" => $config["input"], "max" => $config["max"])
			);

			$this->validatorSchema[$cname] = new rrValidatorRelations($config);
		}
	}

	protected function doSave($con = null)
	{
		parent::doSave();
		
		if($ids = sfContext::getInstance()->getRequest()->getPostParameter("theme[replace_list]"))
		{
			$rpl = array("ProjetTheme", "ProfilTheme", "RessourceTheme", "EventTheme", "StructureTheme", "AnnonceTheme");
			RRR::replace_relation("Theme", $this->getObject()->get("id"), $ids[0], $rpl);
			sfContext::getInstance()->getController()->redirect("/backend.php/theme/".$ids[0]."/edit");
		}
	}
}
