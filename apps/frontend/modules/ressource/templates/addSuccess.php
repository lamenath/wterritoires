<div class="content-popin">
	<div class="generic">
		<h2 class="for"><?php if($form->getObject()->isNew()) echo __("Télécharger une nouvelle ressource"); else echo __("Modifier une ressource"); ?></h2>
		<?php echo form_tag_for($form, 'ressource/add', array("class" => "ajaxForm", "enctype" => "multipart/form-data")) ?>

			<?php include_component("templates", "form", array("form" => $form)); ?>

			<input type="hidden" name="pid" value="<?php echo $sf_request->getParameter("pid"); ?>">
			<input type="hidden" name="eid" value="<?php echo $sf_request->getParameter("eid"); ?>">
			<input type="hidden" name="rid" value="<?php echo $sf_request->getParameter("rid"); ?>">

			<div id="troubleshoot"> </div>
			<div id="form-buttons" class="light center">
				<input type="submit" value="<?php echo __("Télécharger"); ?>" class="button" id="bt_confirm">
				<button class="popin-close gray" onclick="return false;" id="bt_cancel" ><?php echo __("Annuler"); ?></button>
			</div>
		</form>
	</div>
	<script language="javascript"> $('#bt_confirm').focus() </script>
</div>