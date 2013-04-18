<div class="head">
	<?php $count=$pager->getNbResults(); echo ($count > 1 ? __("<b>%nb</b> discussions", array("%nb" => $count)) : __("<b>%nb</b> discussion", array("%nb" => $count))); ?>

	<?php if($acl["publish"] === true): ?>
	<div class="menu-feed">
		<a class="live-action" data-action="idea" data-type="<?php echo $identifier; ?>" data-to="<?php echo $id; ?>"><?php echo __("Ajouter une discussion"); ?></a>
		<div class="clear"></div>
	</div>
	<?php endif; ?>
</div>
<div class="nopad generic-list-prepend">
	<?php foreach($pager->getResults("idea") as $item): ?>
		<?php include_partial("ideas/render", array("item" => $item)); ?>
	<?php endforeach; ?>

	<?php if(!$pager->getNbResults()): ?>
		<div class="no-results">
			<?php echo __("Il n'y pas encore de dialogues"); ?>
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