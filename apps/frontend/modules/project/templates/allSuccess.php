<h1 class="uptitle mega"><?php echo __("Les Projets"); ?></h1>
<div class="clear"></div>
<div class="carousel-menu">
	<div class="buttons">
		<a href="<?php echo url_for("@groupadd"); ?>">
			<div class="button-135 black">
				<div><?php echo __("Créer un groupe de travail"); ?></div>
			</div>
		</a>
		<a href="<?php echo url_for("@projectadd"); ?>">
			<div class="button-135 green">
				<div><?php echo __("Créer un nouveau projet"); ?></div>
			</div>
		</a>
	</div>
	<?php include_component("templates", "menu", array("module" => "project", "load" => "project_page")); ?>
	<div class="clear"></div>
	<div class="carousel">
		<?php echo image_tag("new/shadow_940_top.png", array("class" => "shadow")); ?>
		<div class="carousel-left">
		</div>
		<div class="carousel-right">
		</div>
		<?php echo include_component("project", "list", array("jcarousel" => true, "projects" => $projects)); ?>
		<div class="clear"></div>
		<?php echo image_tag("new/shadow_940_bottom.png", array("class" => "shadow bottom")); ?>
	</div>
</div>
<script language="javascript">
	$(".jCarousel").jCarouselLite({
	    btnNext: ".carousel-right",
	    btnPrev: ".carousel-left",
	    circular: true,
	    visible: 4,
	    scroll: 4,
	    speed: 600
	});
</script>