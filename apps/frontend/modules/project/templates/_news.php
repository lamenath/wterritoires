<h1><?php echo __("Projets populaires"); ?></h1>
<?php foreach($projects as $p): ?>
<div class="entry">
	<span class="date"><?php echo __("le %date", array("%date" => format_date($p["created_at"], "f"))); ?></span>
	<div class="block">
		<a href="<?php echo url_for("@project?slug=".$p["slug"]); ?>">
			<?php echo image_tag($p["photo_std"], array("alt" => __("Photo du projet %name", array("%name" => $p["nom"])))); ?>
			<div class="data">
				<h2><?php echo $p["nom"]; ?></h2>
				<p>
					<?php echo $p["objectifs_qualitatif"]; ?>
				</p>
				<div class="clear"></div>
			</div>
		</a>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
<?php endforeach; ?>