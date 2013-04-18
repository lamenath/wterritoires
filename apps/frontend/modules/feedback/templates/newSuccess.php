<?php echo use_helper('jQuery'); ?>

<div id="content">

	<?php if($sf_request->getParameter("id")) echo "<h1 style='margin-bottom: 20px'>".__("Edition de votre feedback")."</h1>";
			else echo "<h1 style='margin-bottom: 20px'>".__("Donner un nouvel avis sur RRR")."</h1>"; ?>

	<?php if($sf_request->getParameter("saved") == "true"): ?>
	<div class="super_saved">
		<?php echo image_tag("okay.png"); ?> <?php echo __("OK! Votre feedback été modifié !"); ?>
	</div>
	<?php endif; ?>

	<?php if($form->hasErrors()): ?>
	<div class="super_error">
		<?php echo image_tag("error.png"); ?> <?php echo __("Le formulaire contient des erreurs, veuillez vérifier !"); ?>
	</div>
	<div class="clear"> </div>
	<?php endif; ?>

	<?php echo $form->renderGlobalErrors(); ?>
	<form method="post" action="<?php echo url_for($editable ? 'feedback/edit?id=' . $editable : 'feedback/new'); ?>">
		<div class="table">
			<?php if($sf_user->isAdmin()): ?>
			<div class="block">
				<div class="input">
					<?php echo $form['status']->render(); ?>
					<?php if($sf_request->isMethod('post')) echo $form["status"]->getError() || !$sf_request->isMethod('post') ? image_tag("error.png") . '<p class="error">' . $form["status"]->getError() . '</p>' : image_tag("okay.png") ?>
				</div>
				<div class="label">
					<?php echo __("Statut (admin)"); ?> :
				</div>
				<div class="clear"></div>
			</div>
			<?php endif; ?>
			<div class="block">
				<div class="input">
					<?php echo $form['titre']->render(); ?>
					<?php if($sf_request->isMethod('post')) echo $form["titre"]->getError() || !$sf_request->isMethod('post') ? image_tag("error.png") . '<p class="error">' . $form["titre"]->getError() . '</p>' : image_tag("okay.png") ?>
				</div>
				<div class="label">
					<?php echo __("Titre"); ?> :
				</div>
				<div class="clear"></div>
			</div>
			<div class="block">
				<div class="input">
					<?php echo $form['message']->render(array("maxlength" => "700")); ?>
					<?php echo include_partial("subscribe/limitedGrow", array("size" => 700, "name" => "feedback_message")); ?>
					<?php if($sf_request->isMethod('post')) echo $form["message"]->getError() || !$sf_request->isMethod('post') ? '<p class="error">' . $form["message"]->getError() . '</p>' : '' ?>
				</div>
				<div class="label">
					<?php echo __("Un avis, un bug ?"); ?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="block">
				<div class="mega_input">
					<input class="pops" value="Enregistrer" type="submit"></input>
					<p style="text-decoration: underline; font-size: 12px; text-align: right; padding-right: 15px;">
						<a href="<?php echo url_for("feedback/index"); ?>">Retour aux feedbacks</a>
					</p>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<?php echo $form->renderHiddenFields(); ?>
	</form>
</div>