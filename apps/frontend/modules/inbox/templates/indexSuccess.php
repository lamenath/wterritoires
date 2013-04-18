<h1 class="uptitle mega"><?php echo __("Messagerie privée"); ?></h1>
<div class="clear"></div>
<div class="carousel-menu">
	<div class="buttons">
	</div>
	<?php include_component("templates", "menu", array("module" => "inbox", "load" => "inbox_page")); ?>
	<div class="clear"></div>
	<div class="list-plane max">
		<?php echo image_tag("new/shadow_940_top.png", array("class" => "shadow")); ?>
		<div class="content-fixed">
			<?php include_component((isset($moduleRoute) ? $moduleRoute : "inbox"), $proute,  array("message" => $message, "pager" => $pager)); ?>
		</div>
		<div class="clear"></div>
		<?php echo image_tag("new/shadow_940_bottom.png", array("class" => "shadow bottom")); ?>
	</div>
</div>