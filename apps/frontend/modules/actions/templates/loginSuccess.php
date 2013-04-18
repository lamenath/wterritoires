<div id="content-centered">

	<?php echo $form->renderGlobalErrors(); ?>
	<?php echo form_tag_for($form, 'actions/login') ?>
		<div class="table">

			<?php if($error_auth): ?>
				<div class="super_error">
					<?php echo __("Connexion refusée, veuillez vérifier login et mot de passe"); ?>
				</div>
				<div class="clear"> </div>
			<?php else: ?>
				<div class="head">
					<?php if($sf_request->getParameter("goto")): ?>
					<h1><?php echo __("Veuillez vous connecter pour consulter cette page"); ?></h1>
					<?php else: ?>
					<h1><?php echo __("Connexion au Réseau Rural Régional"); ?></h1>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			
			<div class="block">
				<div class="input">
					<?php echo $form['login']->render(); ?>
				</div>
				<div class="label">
					<?php echo __("Nom d'utilisateur ou email"); ?> :
				</div>
				<div class="clear"></div>
			</div>
			<div class="block">
				<div class="input">
					<?php echo $form['password']->render(); ?>
				</div>
				<div class="label">
					<?php echo __("Mot de passe"); ?> :
				</div>
				<div class="clear"></div>
			</div>
			<div class="block">
				<div class="mega_input">
					<input type="submit" value="<?php echo __("Connexion"); ?>" class="button">
					<div class="clear"></div>
					<div class="underw">
						<input type="hidden" name="goto" value="<?php echo $sf_request->getParameter("goto"); ?>">
						<p class="links"><?php echo __("Liens utiles"); ?></p>
						<p>- <a href="<?php echo url_for("subscribe/index"); ?>"><?php echo __("Pas encore inscrit ?"); ?></a></p>
						<p>- <a href="<?php echo url_for("actions/lost"); ?>"><?php echo __("Mot de passe oublié ?"); ?></a></p>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<?php echo $form->renderHiddenFields(); ?>
	</form>
</div>