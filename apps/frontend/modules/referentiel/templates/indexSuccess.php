<div class="directory">
	<div class="content">
		<div class="return">
			<a href="<?php echo url_for("@directory_index?type=".$modelt); ?>"><?php echo __("< retour"); ?></a>
		</div>
		<div class="group">
			<h1 class="head">
				<?php echo $item->getNom(); ?>
			</h1>
			<h2 class="type">
				<?php echo $model; ?>
			</h2>
			<?php if($item["description"]): ?>
			<div class="appro">
				<span><?php echo __("Description"); ?></span>
				<p><?php echo $item->getDescription(); ?></p>
			</div>
			<?php endif; ?>
		</div>
		<div class="clear"></div>
		<div class="carousel-menu">
			<?php include_component("templates", "menu", array("object" => $item, "module" => "referentiel", "load" => "directory")); ?>
			<div class="clear"></div>
			<div class="list-plane max">
				<?php echo image_tag("new/shadow_940_top.png", array("class" => "shadow")); ?>
				<div class="content-fixed">
					<?php include_component((isset($moduleRoute) ? $moduleRoute : "referentiel"), $proute, array("object" => $item, "fixed" => true, "total" => RRR::$total, "pager" => RRR::$pager)); ?>
				</div>
				<div class="clear"></div>
				<?php echo image_tag("new/shadow_650_bottom.png", array("class" => "shadow bottom")); ?>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>