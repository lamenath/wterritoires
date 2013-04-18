<h1><?php echo __("Suggestions de contacts"); ?></h1>
<?php foreach($profiles as $p): ?>
<div class="entry">
	<div class="block">
		<a href="<?php echo $p["url"]; ?>">
			<?php echo image_tag($p["photo_mini"], array("class" => "user")); ?>
			<div class="data">
				<h2><?php echo $p["full_name"]; ?></h2>
				<p class="user">
					<?php echo $p["presentation"]; ?>
				</p>
				<div class="clear"></div>
			</div>
		</a>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
<?php endforeach; ?>