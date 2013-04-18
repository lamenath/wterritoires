<h1 class="uptitle mega"><?php echo __("Recherche"); ?></h1>
<div class="clear"></div>
<div class="carousel-menu">
	<?php include_component("templates", "menu", array("module" => "search", "load" => "search")); ?>
	<div class="clear"></div>
	<div class="list-plane max">
		<?php echo image_tag("new/shadow_940_top.png", array("class" => "shadow")); ?>
		<div class="content-fixed">
			<?php include_component((isset($moduleRoute) ? $moduleRoute : "search"), $proute, array("total" => RRR::$total, "pager" => RRR::$pager)); ?>
		</div>
		<div class="clear"></div>
		<?php echo image_tag("new/shadow_940_bottom.png", array("class" => "shadow bottom")); ?>
	</div>
</div>