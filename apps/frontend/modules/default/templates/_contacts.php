<div class="common-feed-news">
	<?php include_component("profile", "suggest"); ?>
</div>
<div class="common-feed home contacts-corrector">
	<div class="head">
		<?php echo ($sf_request->getParameter("search") ? __("%c contacts correspondant à \"%term\"", array("%term" => $sf_request->getParameter("search"), "%c" => $total)) : __("%c contacts", array("%c" => $total))); ?>
		<div class="menu-feed">
			<form action="<?php echo $sf_request->getPathInfo(); ?>" method="get">
				<input type="text" placeholder="<?php echo __("Rechercher un contact"); ?>" class="search" name="search" value="<?php echo $sf_request->getParameter("search"); ?>">
				<input type="hidden" name="page" value="1">
			</form>
			<div class="clear"></div>
		</div>
	</div>

	<div class="padded">
		<?php foreach($pager->getResults("profile_light") as $item): ?>
		<div id="contact_<?php echo $item["id"]; ?>" class="entry">
			<div class="s-buttons">
				<a data-action="inbox" data-more="" data-to="<?php echo $item["id"]; ?>" class="live-action button"><span><?php echo __("Message"); ?></span></a>
				<a data-action="friend" data-more="direction=remove&rmv=1" data-to="<?php echo $item["id"]; ?>" class="live-action button"><span><?php echo __("Supprimer"); ?></span></a>
			</div>
			<a href="<?php echo $item["url"]; ?>">
				<?php echo image_tag($item["photo_mini"], array("alt" => __("Photo de profil de %name", array("%name" => $item["full_name"])), "class" => "user")); ?>
			</a>
			<a href="<?php echo $item["url"]; ?>">
				<div class="info">
					<h3><?php echo $item["full_name"]; ?></h3>
					<span><?php echo __("en contact depuis le %date", array("%date" => format_date($item["extraData"]["created_at"], "f"))); ?></span>
				</div>
			</a>
			<div class="clear"></div>
		</div>
		<?php endforeach; ?>
		<?php if(!$total): ?>
		<div class="no-results">
			<?php echo __("Vous n'avez pas encore de contacts..."); ?>
		</div>
		<?php endif; ?>
	</div>

	<?php if (isset($pager) && $pager->haveToPaginate()): ?>
	<div class="clear"></div>
	<div class="pagination bottom">
		<?php include_partial('templates/paginate', array('pager' => $pager)) ?>
		<div class="clear"></div>
	</div>
	<?php endif ?>
</div>