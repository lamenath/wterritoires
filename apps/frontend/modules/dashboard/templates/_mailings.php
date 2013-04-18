<div class="head">
	<?php echo ($sf_request->getParameter("search") ? __("%c mailings correspondant à \"%term\"", array("%term" => $sf_request->getParameter("search"), "%c" => $total)) : __("%c mailings", array("%c" => $total))); ?>
	<div class="menu-feed">
		<form action="<?php echo $sf_request->getPathInfo(); ?>" method="get">
			<input type="text" class="search" name="search" value="<?php echo $sf_request->getParameter("search"); ?>">
			<input type="hidden" name="page" value="1">
		</form>
		<div class="clear"></div>
	</div>
</div>
<div class="common-feed contacts-corrector">
	<div class="padded">
		<?php foreach($pager->getResults() as $item): ?>
		<div class="entry">
			<div class="s-buttons">
				<a class="send-test button" href="<?php echo url_for("/dashboard/send?case=test&id=".$item["id"]); ?>"><span><?php echo __("Envoyer le message sur mon email"); ?></span></a>
				<a class="boxy-send button" href="<?php echo url_for("/dashboard/send?id=".$item["id"]); ?>"><span><?php echo __("Envoyer le mailing"); ?></span></a>
				<a class="button" href="<?php echo url_for("/dashboard/mailing?id=".$item["id"]); ?>"><span><?php echo __("Editer"); ?></span></a>
				<a class="boxy-confirm button" href="<?php echo url_for("/dashboard/remove_mailing?page=".$sf_request->getParameter("page")."&id=".$item["id"]); ?>"><span><?php echo __("Supprimer"); ?></span></a>
			</div>
			<div class="info">
				<h3><?php echo $item["sujet"]; ?></h3>
				<span><?php echo ($item["is_sent"] ? __("Envoyé") : __("Pas envoyé")); ?></span>
			</div>
			<div class="clear"></div>
		</div>
		<?php endforeach; ?>
		<?php if(!$total): ?>
		<div class="no-results">
			<?php echo __("Il n'y a pas de mailings..."); ?>
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