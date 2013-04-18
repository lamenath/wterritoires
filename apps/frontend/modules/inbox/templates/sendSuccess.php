<div class="content-popin">
	<div class="generic">
		<h2 class="for"><?php echo __("Envoyer un message"); ?></h2>
		<?php echo form_tag_for($form, 'inbox/send', array("class" => "ajaxForm", "enctype" => "multipart/form-data")) ?>

			<div class="table">
				<div class="block">
					<div class="label">
						<?php echo __("Destinataire"); ?>
					</div>
					<div class="input">
						<div class="contact">
							<?php echo image_tag($profil["photo_mini"]); ?>
							<span><?php echo $profil["full_name"]; ?></span>
							<div class="clear"></div>
						</div>
					</div>
					<div class="clear"> </div>
				</div>
			</div>
			
			<?php include_component("templates", "form", array("form" => $form)); ?>

			<input type="hidden" name="did" value="<?php echo $sf_request->getParameter("did"); ?>">

			<div id="troubleshoot"> </div>
			<div id="form-buttons" class="light center">
				<input type="submit" value="<?php echo __("Envoyer"); ?>" class="button" id="bt_confirm">
				<button class="popin-close gray" onclick="return false;" id="bt_cancel" ><?php echo __("Annuler"); ?></button>
			</div>
		</form>
	</div>
	<script language="javascript"> $('#bt_confirm').focus() </script>
</div>