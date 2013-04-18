<div class="common-feed contacts-corrector">
	<div class="head">
		<?php echo ($sf_request->getParameter("search") ? __("%c structure(s) correspondant à \"%term\"", array("%term" => $sf_request->getParameter("search"), "%c" => $total)) : __("%c structure(s)", array("%c" => $total))); ?>
		<div class="menu-feed">
			<a href="<?php echo url_for("structure/edit"); ?>"><?php echo __("Créer une structure"); ?></a>
			<form action="<?php echo $sf_request->getPathInfo(); ?>" method="get">
				<input type="text" placeholder="<?php echo __("Chercher une structure"); ?>" class="search" name="search" value="<?php echo $sf_request->getParameter("search"); ?>"  <?php if(isset($fixed)) echo 'style="display:none"'; ?>>
				<input type="hidden" name="page" value="1">
			</form>
			<div class="clear"></div>
		</div>
	</div>

	<div class="padded">
		<?php foreach($pager->getResults("structure") as $item): ?>
		<div id="contact_<?php echo $item["id"]; ?>" class="entry">
			<div class="s-buttons">
				<a class="button" href="<?php echo url_for("structure/edit?id=" . $item["id"]); ?>"><span><?php echo __("Editer"); ?></span></a>
			</div>
			<a href="<?php echo $item["url"]; ?>">
				<?php echo image_tag($item["photo_mini"], array("alt" => $item["nom"], "class" => "user")); ?>
			</a>
			<a href="<?php echo $item["url"]; ?>">
				<div class="info">
					<h3><?php echo $item["nom"]; ?></h3>
					<span><?php echo $item["ville"]; ?></span>
				</div>
			</a>
			<div class="clear"></div>
		</div>
		<?php endforeach; ?>
		<?php if(!$total): ?>
		<div class="no-results">
			<?php echo __("Pas de structures correspondant à votre recherche"); ?>
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