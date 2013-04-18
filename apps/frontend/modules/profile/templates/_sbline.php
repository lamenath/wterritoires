<a href="<?php echo $user["url"]; ?>">
<li>
	<?php echo image_tag($user["photo_mini"], array("alt" => __("Photo de profil de %name", array("%name" => $user["full_name"])) , "class" => "user")); ?>
	<div class="descr">
		<span class="title"><?php echo $user["full_name"]; ?></span>
		<span><?php echo $user["ville"]; ?></span>
		<span><?php echo $user["presentation"]; ?></span>
	</div>
</li>
</a>