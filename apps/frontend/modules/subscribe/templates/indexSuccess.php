<h1 class="uptitle solo-left mega">
	<?php echo __("Rejoindre le Réseau Rural de Picardie"); ?>
</h1>
<div class="profile project solo-left">
	<div class="content">
		<div class="carousel-menu">
			<div class="carousel">
				<div class="content-fixed">
					<?php echo form_tag_for($form, 'subscribe/index') ?>
						<div class="form">
							<?php include_component("templates", "form", array("form" => $form)); ?>
							<div id="form-buttons" class="light center">
								<input type="submit" value="<?php echo __("Créer mon compte"); ?>" class="button" id="bt_confirm">
								<div class="clear"></div>
							</div>
						</div>
					</form>
				</div>
				<div class="clear"></div>
				<?php echo image_tag("new/shadow_650_bottom.png", array("class" => "shadow bottom")); ?>
			</div>
		</div>
	</div>
</div>