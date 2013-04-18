<div class="content-popin">
	<div class="generic">
		<h2 class="for"><?php echo __("Supprimer une ressource"); ?></h2>

		<form action="<?php echo url_for("ressource/remove"); ?>" method="post" class="ajaxForm">

			<input type="hidden" name="rid" value="<?php echo $sf_request->getParameter("rid"); ?>">

			<h3><?php echo __("Voulez-vous vraiment supprimer cette ressource ?"); ?></h3>

			<div id="troubleshoot"> </div>
			<div id="form-buttons" class="light center">
				<input type="submit" value="<?php echo __("Supprimer"); ?>" class="button" id="bt_confirm">
				<button class="popin-close gray" onclick="return false;" id="bt_cancel" ><?php echo __("Annuler"); ?></button>
			</div>
		</form>
	</div>
	<script language="javascript"> $('#bt_confirm').focus() </script>
</div>