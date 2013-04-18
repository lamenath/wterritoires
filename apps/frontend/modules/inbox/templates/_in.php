<div class="head">
	<?php $count = $pager->getNbResults(); ?>
	<?php echo ($count > 1 ? __("%c messages", array("%c" => $count)) : __("%c message", array("%c" => $count))); ?>
	<div class="menu-feed">
		<form action="<?php echo $sf_request->getPathInfo(); ?>" method="get">
			<input type="text" placeholder="<?php echo __("Rechercher un message"); ?>" class="search" name="search" value="<?php echo $sf_request->getParameter("search"); ?>">
			<input type="hidden" name="page" value="1">
		</form>
		<div class="clear"></div>
	</div>
</div>

<div class="common-inbox">
	<div id="box-direct" class="box">
		<div class="avert"><?php echo __("Cliquez ci-contre sur un message<br> pour le consulter."); ?></div>
	</div>
</div>

<div class="common-feed inbox">
	<div class="padded">
	<?php foreach($pager->getResults("profile_light") as $item): ?>
		<div class="entry<?php if($item["extraData"]["seen_at"] == null) echo ' new'; ?>" id="inbox-<?php echo $item["extraData"]["id"]; ?>">
			<a data-destination="box-direct" class="ajax-action" href="<?php echo url_for("@inboxc?proute=read&id=" . $item["extraData"]["id"]); ?>">
				<?php echo image_tag($item["photo_mini"], array("alt" => $item["full_name"], "class" => "big user")); ?>
				<div class="s-buttons">
				</div>
				<div class="info">
					<h3 class="limited"><?php echo ($item["extraData"]["sujet"]?$item["extraData"]["sujet"]:__("sans objet")); ?></h3>
					<h4 class="limited"><?php echo $item["extraData"]["message"]; ?></h4>
					<span><?php echo $item["full_name"]; ?> | <?php echo __("le %date", array("%date" => format_date($item["extraData"]["created_at"], "f"))); ?></span>
				</div>
			</a>
		</div>
	<?php endforeach; ?>
	</div>
</div>

<?php if(!$pager->getNbResults()): ?>
	<div class="no-results">
		<?php echo __("Vous n'avez pas de messages"); ?>
	</div>
<?php endif; ?>

<?php if (isset($pager) && $pager->haveToPaginate()): ?>
<div class="clear"></div>
<div class="pagination bottom">
	<?php include_partial('templates/paginate', array('pager' => $pager)) ?>
	<div class="clear"></div>
</div>
<?php endif ?>