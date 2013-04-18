<h1 class="solo-left uptitle mega">
<?php if($sf_request->getParameter("type") == "public"): ?>
	<?php echo $form->isNew() ? __("Créer un nouveau projet") : __("Modifier le projet \"%name\"", array("%name" => $form->getObject())); ?>
<?php else: ?>
	<?php echo $form->isNew() ? __("Créer un nouveau groupe de travail") : __("Modifier le groupe \"%name\"", array("%name" => $form->getObject())); ?>
<?php endif; ?>
</h1>
<div class="profile project solo-left">
	<div class="content">
		<div class="carousel-menu">
			<div class="carousel">
				<div class="content-fixed">
					<div class="form">
						<?php echo form_tag_for($form, ($sf_request->getParameter("type")  == "public" ? 'project/edit' : 'group/edit'), array("enctype" => "multipart/form-data", "class" => "ajaxForm")) ?>
							<input name="id" value="<?php echo $sf_request->getParameter("id"); ?>" type="hidden">
							<?php include_component("templates", "form", array("form" => $form)); ?>
							<div class="block">
								<div class="form-left-bottom">
									<?php if(isset($acl) && $acl["admin"] === true): ?>
										<a class="boxy-confirm" href="<?php echo url_for("project/remove?id=".$form->getObject()->getId()); ?>"><?php echo __("Supprimer ce projet ?"); ?></a>
									<?php endif; ?>
								</div>
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
		</div>
	</div>
	<div class="clear"></div>
</div>