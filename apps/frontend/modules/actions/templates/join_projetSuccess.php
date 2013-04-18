<div class="content-popin">
	<div class="generic">
		<form action="<?php echo url_for("json/join_project"); ?>" method="post" class="ajaxForm">

			<input type="hidden" name="pid" value="<?php echo $sf_request->getParameter("pid"); ?>">
			<input type="hidden" name="role" value="<?php echo $sf_request->getParameter("role"); ?>">
			<input type="hidden" name="type" value="<?php echo $sf_request->getParameter("type"); ?>">

			<?php if($sf_request->getParameter("type") == "join"): ?>
				<h2><?php echo __( ($sf_request->getParameter("role") == Projet::ROLE_CONTRIBUTOR ? __("Contribuer au ") : __("Suivre les actualités du") ). " projet \"%1%\" ?", array("%1%" => $projet) ); ?></h2>
			<?php else: ?>
				<h2><?php echo __( "Voulez-vous quitter le projet \"%1%\" ?", array("%1%" => $projet) ); ?></h2>
			<?php endif; ?>

			<div id="troubleshoot"> </div>
			<div id="form-buttons" class="">
				<input type="submit" class="button" value="<?php echo __("Confirmer"); ?>" id="bt_confirm">
				<button class="popin-close gray" onclick="return false;" id="bt_cancel" ><?php echo __("Annuler"); ?></button>
			</div>
		</form>
	</div>
</div>