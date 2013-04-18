<h1 class="uptitle mega solo-left"><?php echo __("Editer mon profil") ?></h1>
<div class="profile project solo-left">
	<div class="content">
		<div class="carousel-menu">
			<?php include_component("templates", "menu", array("module" => "profile", "load" => "profile_edit")); ?>
			<div class="clear"></div>
			<div class="carousel">
				<div class="content-fixed">
					<div class="form">
						<?php echo form_tag_for($form, $sf_request->getUri(), array("enctype" => "multipart/form-data", "class" => "ajaxForm")) ?>
							<input name="id" value="<?php echo $sf_request->getParameter("id"); ?>" type="hidden">
							<input name="scenario" value="<?php echo ( $sf_request->getParameter("account_created") ? "1" : 0); ?>" type="hidden">
							<?php include_component("templates", "form", array("form" => $form)); ?>
							<div class="block">
								<div id="form-buttons" class="">
									<input type="submit" class="button" value="<?php echo $sf_request->getParameter("account_created") ? ($sf_request->getParameter("proute") == "privacy" ? __("Enregistrer et accéder à mon espace") : __("Suivant")) : __("Enregistrer"); ?>" id="bt_confirm">
									<div class="clear"></div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>