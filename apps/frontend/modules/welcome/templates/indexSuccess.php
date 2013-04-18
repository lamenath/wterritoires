<?php echo include_component('welcome', 'hoody'); ?>
<h1 class="uptitle"><?php echo __("Derniers Projets"); ?></h1>
<div class="rich">
	<?php include_component('project', 'list', array("projects" => $projects, "homepage" => true)); ?>
	<div class="clear"></div>
</div>