<div class="content-popin">
	<div class="generic">
		<h2 class="for"><?php echo __("Supprimer une discussion"); ?></h2>

		<form action="<?php echo url_for("ideas/remove"); ?>" method="post" class="ajaxForm">

			<input type="hidden" name="iid" value="<?php echo $sf_request->getParameter("iid"); ?>">

			<h3><?php echo __("Voulez-vous vraiment supprimer cette discussion ?"); ?></h3>

			<div id="troubleshoot"> </div>
			<div id="form-buttons" class="light center">
				<input type="submit" value="<?php echo __("Supprimer"); ?>" class="button" id="bt_confirm">
				<button class="popin-close gray" onclick="return false;" id="bt_cancel" ><?php echo __("Annuler"); ?></button>
			</div>
		</form>
	</div>
	<script language="javascript"> $('#bt_confirm').focus() </script>
</div>