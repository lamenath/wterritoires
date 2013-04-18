<a href="<?php echo $event["url"]; ?>">
<li>
	<?php echo image_tag($event["photo_mini"], array("class" => "user")); ?>
	<div class="descr">
		<span class="title"><?php echo $event["titre"]; ?></span>
		<span><?php echo $event["presentation"]; ?></span>
	</div>
</li>
</a>