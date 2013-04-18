<div class="content-popin">
	<div class="generic">
		<h2 class="for"><?php if($form->getObject()->isNew()) echo __("Ouvrir une nouvelle discussion"); else echo __("Modifier une discussion"); ?></h2>
		<?php echo form_tag_for($form, 'ideas/add', array("class" => "ajaxForm")) ?>

			<?php include_component("templates", "form", array("ajax" => true, "form" => $form)); ?>

			<input type="hidden" name="pid" value="<?php echo $sf_request->getParameter("pid"); ?>">
			<input type="hidden" name="eid" value="<?php echo $sf_request->getParameter("eid"); ?>">
			<input type="hidden" name="iid" value="<?php echo $sf_request->getParameter("iid"); ?>">

			<div id="troubleshoot"> </div>
			<div id="form-buttons" class="">
				<input type="submit" class="button" value="<?php echo __("Publier"); ?>" id="bt_confirm">
				<button class="popin-close gray" onclick="return false;" id="bt_cancel" ><?php echo __("Annuler"); ?></button>
			</div>
		</form>
	</div>
	<script language="javascript"> $('#bt_confirm').focus() </script>
</div>