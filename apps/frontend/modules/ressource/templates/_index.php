<div class="head">
	<?php $count=$pager->getNbResults(); echo ($count > 1 ? __("<b>%nb</b> ressources", array("%nb" => $count)) : __("<b>%nb</b> ressource", array("%nb" => $count))); ?>
	<div class="menu-feed">
		<form action="<?php echo $sf_request->getPathInfo(); ?>" method="get">
			<input placeholder="<?php echo __("Rechercher une ressource"); ?>" type="text" class="search" name="search" value="<?php echo $sf_request->getParameter("search"); ?>" <?php if(isset($fixed)) echo 'style="display:none"'; ?>>
			<input type="hidden" name="page" value="1">
		</form>
		<?php if($acl["publish"] === true): ?>
			<a class="live-action" data-action="ressource" data-type="<?php echo $identifier; ?>" data-to="<?php echo $id; ?>"><?php echo __("Ajouter une ressource"); ?></a>
		<?php endif; ?>
		<div class="clear"></div>
	</div>
</div>
<div class="nopad generic-list-prepend">
	<?php foreach($pager->getResults("profile_light") as $item): ?>
		<?php include_partial("ressource/render", array("identifier" => $identifier, "id" => $id, "item" => $item)); ?>
	<?php endforeach; ?>

	<?php if(!$pager->getNbResults()): ?>
	<div class="no-results">
		<?php echo __("Il n'y pas encore de ressources"); ?>
	</div>
	<?php endif; ?>

	<?php if (isset($pager) && $pager->haveToPaginate()): ?>
	<div class="clear"></div>
	<div class="pagination bottom">
		<?php include_partial('templates/paginate', array('pager' => $pager)) ?>
		<div class="clear"></div>
	</div>
	<?php endif ?>
</div>