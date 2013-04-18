<?php $ressources = Doctrine_Query::create()->from("StoryPictures a")->leftJoin("a.PhotoProjet x")->where("a.story_id=?", $item["extraData"]["id"])->orderBy("created_at DESC")->limit(8)->execute(array(), "photo"); ?>
<h3 class="less"><?php echo __("<a href='%url'>%name</a> a ajouté %count photo(s) à la galerie", array( "%count" => count($ressources), "%url" => $item["url"], "%name" => $item["full_name"])); ?></h3>
<div class="buddies">
	<?php foreach($ressources as $ressource): ?>
	<a alt="<?php echo __("Photo de la gallerie"); ?>" title="<?php echo $ressource["nom"]; ?>" href="<?php echo $ressource["photo_max"]; ?>" class="mustang-gallery-home"><?php echo image_tag($ressource["photo_std"], array("class" => "gal", "alt" =>  __("Photo de la gallerie"), "id" => $ressource["id"])); ?></a>
	<?php endforeach; ?>
	<div class="clear"></div>
</div>