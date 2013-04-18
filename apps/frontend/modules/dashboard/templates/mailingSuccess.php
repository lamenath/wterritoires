<h1 class="uptitle mega"><?php echo __("Dashboard Animateur"); ?></h1>
<div class="clear"></div>
<div class="carousel-menu">
	<div class="content">
		<div class="carousel-menu test">
			<?php include_component("templates", "menu", array("module" => "dashboard", "load" => "dash")); ?>
			<div class="clear"></div>
			<div class="carousel">
				<div class="content-fixed">
					<div class="form">
						<?php echo form_tag_for($form, "dashboard/mailing", array("class" => "ajaxForm")) ?>
							<input name="id" value="<?php echo $sf_request->getParameter("id"); ?>" type="hidden">
							<?php include_component("templates", "form", array("form" => $form)); ?>
							<div class="block">
								<div id="form-buttons" class="">
									<input type="submit" class="button" value="<?php echo __("Enregistrer"); ?>" id="bt_confirm">
									<button class="popin-close gray" onclick="return false;" id="bt_cancel" ><?php echo __("Annuler"); ?></button>
									<div class="clear"></div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<?php echo image_tag("new/shadow_650_bottom.png", array("class" => "shadow bottom")); ?>
		</div>
	</div>
</div>