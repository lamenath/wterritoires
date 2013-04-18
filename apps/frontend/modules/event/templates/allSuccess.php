<h1 class="uptitle mega"><?php echo __("Les Événements"); ?></h1>
<div class="clear"></div>
<div class="carousel-menu">
	<div class="buttons">
		<a href="<?php echo url_for("event/edit"); ?>">
			<div class="button-135 black">
				<div><?php echo __("Créer un nouvel événement"); ?></div>
			</div>
		</a>
	</div>
	<?php include_component("templates", "menu", array("module" => "event", "load" => "event_page")); ?>
	<div class="clear"></div>
	<div class="list-plane max">
		<?php echo image_tag("new/shadow_940_top.png", array("class" => "shadow")); ?>
		<div class="content-fixed">
			<?php include_component((isset($moduleRoute) ? $moduleRoute : "project"), $proute, array("pager" => $pager, "identifier" => "event")); ?>
		</div>
		<div class="clear"></div>
		<?php echo image_tag("new/shadow_940_bottom.png", array("class" => "shadow bottom")); ?>
	</div>
</div>