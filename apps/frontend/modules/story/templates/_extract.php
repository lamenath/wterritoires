<div class="padded">
	<?php foreach($stories as $item): ?>
	<div class="entry">
		<?php echo image_tag($item["photo_mini"], array("class" => "user")); ?>
		<div class="info">
			<?php echo include_partial("story/".$item["extraData"]["type"], array("params" => unserialize(html_entity_decode($item["extraData"]["params"])), "item" => $item)); ?>
			<span><?php echo __("le %date", array("%date" => format_date($item["extraData"]["updated_at"], "f"))); ?></span>
		</div>
		<div class="clear"></div>
	</div>
	<?php endforeach; ?>
</div>
<?php if($stories->count() == 0): ?>
<div class="no-results">
	<?php echo __("Il n'y pas encore d'activité"); ?>
</div>
<?php endif; ?>