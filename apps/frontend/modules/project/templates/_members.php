<div class="head">
	<?php echo ($sf_request->getParameter("search") ? __("%c membres correspondant à \"%term\"", array("%term" => $sf_request->getParameter("search"), "%c" => $total)) : __("%c membres", array("%c" => $total))); ?>
	<div class="menu-feed">
		<form action="<?php echo $sf_request->getPathInfo(); ?>" method="get">
			<input placeholder="<?php echo __("Rechercher un membre"); ?>" type="text" class="search" name="search" value="<?php echo $sf_request->getParameter("search"); ?>">
			<input type="hidden" name="page" value="1">
		</form>
		<div class="clear"></div>
	</div>
</div>
<div class="common-feed contacts-corrector">
	<div class="padded">
		<?php foreach($pager->getResults("profile_light") as $item): ?>
		<div class="entry">
			<a href="<?php echo $item["url"]; ?>">
				<?php echo image_tag($item["photo_mini"], array("alt" => __("Photo de profil de %name", array("%name" => $item["full_name"])), "class" => "user")); ?>
			</a>
			<div class="s-bulle">
				<?php if(isset($structure)): ?>
				<label><?php echo ($item["extraData"]["role"] == "admin" ? __("Référent") : __("Membre")); ?></label>
				<?php else: ?>
				<label><?php echo ($item["extraData"]["role"] == "referent" ? __("Référent") : ($item["extraData"]["role"] == "contributeur" ? __("Contributeur") : __("Observateur"))); ?></label>
				<?php endif; ?>
			</div>
			<div class="s-buttons">
				<?php if(isset($structure)): ?>
					<?php if($acl["admin"]): ?>
						<?php if($item["extraData"]["role"] == "admin"): ?>
							<a data-action="structure_admin" data-more="pid=<?php echo $item["extraData"]["structure_id"]; ?>&direction=notreferent" data-to="<?php echo $item["id"]; ?>" class="live-action button"><span><?php echo __("Supprimer des référents"); ?></span></a>
							<?php else: ?>
							<a data-action="structure_admin" data-more="pid=<?php echo $item["extraData"]["structure_id"]; ?>&direction=referent" data-to="<?php echo $item["id"]; ?>" class="live-action button"><span><?php echo __("Nommer référent"); ?></span></a>
							<?php endif; ?>
							<a data-action="structure_admin" data-more="pid=<?php echo $item["extraData"]["structure_id"]; ?>&direction=kick" data-to="<?php echo $item["id"]; ?>" class="live-action button"><span><?php echo __("Exclure"); ?></span></a>
					<?php endif; ?>
				<?php else: ?>
					<?php if($acl["admin"]): ?>
						<?php if($item["extraData"]["role"] == "referent"): ?>
							<a data-action="project_admin" data-more="pid=<?php echo $project["id"]; ?>&direction=notreferent" data-to="<?php echo $item["id"]; ?>" class="live-action button"><span><?php echo __("Supprimer des référents"); ?></span></a>
							<?php else: ?>
							<a data-action="project_admin" data-more="pid=<?php echo $project["id"]; ?>&direction=referent" data-to="<?php echo $item["id"]; ?>" class="live-action button"><span><?php echo __("Nommer référent"); ?></span></a>
							<?php endif; ?>
							<a data-action="project_admin" data-more="pid=<?php echo $project["id"]; ?>&direction=kick" data-to="<?php echo $item["id"]; ?>" class="live-action button"><span><?php echo __("Exclure"); ?></span></a>
						<?php endif; ?>
				<?php endif; ?>
			</div>
			<a href="<?php echo $item["url"]; ?>">
				<div class="info">
					<h3><?php echo $item["full_name"]; ?></h3>
					<span><?php echo __("membre  depuis le %date", array("%date" => format_date($item["extraData"]["created_at"], "f"))); ?></span>
				</div>
			</a>
			<div class="clear"></div>
		</div>
		<?php endforeach; ?>
		<?php if(!$total): ?>
		<div class="no-results">
			<?php echo __("Il n'y a pas de membres..."); ?>
		</div>
		<?php endif; ?>
	</div>
</div>
<?php if (isset($pager) && $pager->haveToPaginate()): ?>
<div class="clear"></div>
<div class="pagination bottom">
	<?php include_partial('templates/paginate', array('pager' => $pager)) ?>
	<div class="clear"></div>
</div>
<?php endif ?>