<div class="profile project">
	<div class="sidebar">
		<?php echo include_component("structure", "sidebar", array("structure" => $structure)); ?>
	</div>
	<div class="content">
		<div class="title">
			<a href='<?php echo $structure["url"]; ?>'>
				<?php echo image_tag($structure["photo_std"], array("class" => "user")); ?>
				<div class="block">
					<h1><?php echo $structure["nom"]; ?></h1>
					<div class="clear"></div>
				</div>
			</a>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		<div class="carousel-menu up">
			<div class="carousel">
				<div class="content-fixed">
					<div class="common-feed">
						<?php include_partial("project/members", array("structure" => true, "acl" => $structure["ACL"], "total" => $total, "pager" => $pager)); ?>
					</div>
				</div>
				<div class="clear"></div>
				<?php echo image_tag("new/shadow_650_bottom.png", array("class" => "shadow bottom")); ?>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>