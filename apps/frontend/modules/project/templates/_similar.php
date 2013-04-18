<?php if($projects->count()): ?>
<div class="block">
	<h2><?php echo __("Projets similaires"); ?></h2>
	<div class="clear"></div>
	<ul class="project-list">
		<?php foreach($projects as $project): ?>
		<li>
			<a href="<?php echo $project["url"]; ?>">
				<?php echo image_tag($project["photo_mini"], array("alt" => __("Photo du projet similaire"))); ?>
				<div class="descr">
					<span class="title"><?php echo $project["Commune"]["Pays"]["nom"]; ?></span>
					<span class="last"><?php echo $project["nom"]; ?></span>
				</div>
			</a>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>