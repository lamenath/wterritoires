<a href="<?php echo url_for("@project?slug=".$relation["slug"]); ?>">
	<li>
		<?php echo image_tag($relation["photo_mini"], array("alt" => __("Photo de l'utilisateur"), "class" => "user")); ?>
		<div class="descr">
			<span class="title"><?php echo $relation["nom"]; ?></span>
			<span><?php echo $relation["nom"]; ?></span>
		</div>
	</li>
</a>