<div class="content-popin">
	<div class="generic">
		<form action="<?php echo url_for("inbox/remove"); ?>" method="post" class="ajaxForm">

			<input type="hidden" name="mid" value="<?php echo $sf_request->getParameter("mid"); ?>">

			<h2><?php echo __("Souhaitez-vous réellement supprimer ce message ?"); ?></h2>

			<div id="troubleshoot"> </div>
			<div id="form-buttons" class="">
				<input type="submit" class="button" value="<?php echo __("Confirmer"); ?>" id="bt_confirm">
				<button class="popin-close gray" onclick="return false;" id="bt_cancel" ><?php echo __("Annuler"); ?></button>
			</div>
		</form>
	</div>
</div>