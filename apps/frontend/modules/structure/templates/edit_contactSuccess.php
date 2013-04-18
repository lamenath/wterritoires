<h1 class="uptitle solo-left mega"><?php echo $form->isNew() ? __("Créer un contact dans une structure") : __("Modifier un contact"); ?></h1>
<div class="profile project solo-left">
	<div class="content">
		<div class="carousel-menu">
			<div class="carousel">
				<div class="content-fixed">
					<div class="form">
						<?php echo preg_replace("/\/update|\/create/", "", form_tag_for($form, $sf_request->getUri(), array("enctype" => "multipart/form-data", "class" => "ajaxForm"))); ?>
							<input name="id" value="<?php echo $sf_request->getParameter("id"); ?>" type="hidden">
							<?php include_component("templates", "form", array("form" => $form)); ?>
							<div class="block">
								<div class="form-left-bottom">
									<?php if(!$form->isNew() && isset($acl) && $acl["admin"] === true): ?>
										<a class="boxy-confirm" href="<?php echo url_for("structure/remove_contact?id=".$form->getObject()->getId()); ?>"><?php echo __("Supprimer ce contact?"); ?></a>
									<?php endif; ?>
								</div>
								<div id="form-buttons" class="">
									<input type="submit" class="button" value="<?php echo __("Enregistrer"); ?>" id="bt_confirm">
									<a class="button" style="float:right" href='<?php echo url_for("@structure2c?slug=".$sf_request->getParameter("slug")); ?>'>
										<span><?php echo __("Annuler"); ?></span>
									</a>
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