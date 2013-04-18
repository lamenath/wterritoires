<h1 class="uptitle mega"><?php echo __("Mon espace"); ?></h1>
<div class="clear"></div>
<div class="carousel-menu">
	<div class="content">
		<div class="carousel-menu test">
			<?php include_component("templates", "menu", array("module" => "default", "load" => "myspace")); ?>
			<div class="clear"></div>
			<div class="carousel">
				<div class="content-fixed">
					<?php include_component((isset($moduleRoute) ? $moduleRoute : "default"), $proute, array("homepage" => true)); ?>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
			<?php echo image_tag("new/shadow_650_bottom.png", array("class" => "shadow bottom")); ?>
		</div>
	</div>
</div>