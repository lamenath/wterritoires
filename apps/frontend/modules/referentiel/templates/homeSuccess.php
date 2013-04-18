<h1 class="uptitle mega"><?php echo __("Référentiel %type", array("%type" => $sf_request->getParameter("type"))); ?></h1>
<div class="clear"></div>
<div class="carousel-menu">
	<div class="content">
		<div class="carousel-menu test">
			<div class="carousel">
				<div class="content-fixed">
					<?php echo include_partial("dashboard/tendances", array('public' => true)); ?>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
			<?php echo image_tag("new/shadow_650_bottom.png", array("class" => "shadow bottom")); ?>
		</div>
	</div>
</div>