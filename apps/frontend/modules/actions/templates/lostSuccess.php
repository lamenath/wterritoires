<div id="content-centered">

	<?php echo form_tag('actions/lost', array("method" => "post")) ?>
		<div class="table">

			<div class="head">
				<h1><?php echo __("Réinitialisation de votre mot de passe"); ?></h1>
			</div>
			
			<?php if(isset($posted)): ?>
			<div class="super_saved">
				<?php echo __("OK! Si ces informations sont correctes, vous allez recevoir un email dans les secondes à venir !"); ?>
			</div>
			<div class="clear"> </div>
			<?php endif; ?>
			
			<div class="block">
				<div class="input">
					<input type="text" name="mail_login">
					<p>
						<?php echo __("Indiquez ci-dessus votre login (nom d'utilisateur) ou votre email utilisé lors de l'inscription à RRR."); ?>
						<?php echo __("Si les informations sont correctes, vous recevrez un email vous indiquant la procédure à suivre pour réinitialiser votre mot de passe."); ?>
						<br/>
						<?php echo __("Si vous avez oublié ces informations, prenez contact avec nous : "); ?>
						<a class="underline" href="<?php echo url_for("@legal"); ?>">cliquez-ici.</a>
					</p>
				</div>
				<div class="label">
					<?php echo __("Nom d'utilisateur ou email"); ?> :
				</div>
				<div class="clear"></div>
			</div>
			<div class="block">
				<div class="mega_input">
					<input type="submit" value="<?php echo __("Retrouver le mot de passe"); ?>" class="button">
					<div class="clear"></div>
					<div class="underw">
						<input type="hidden" name="goto" value="<?php echo $sf_request->getParameter("goto"); ?>">
						<p class="links"><?php echo __("Liens utiles"); ?></p>
						<p>- <a href="<?php echo url_for("subscribe/index"); ?>"><?php echo __("Pas encore inscrit ?"); ?></a></p>
						<p>- <a href="<?php echo url_for("actions/login"); ?>"><?php echo __("Connectez-vous"); ?></a></p>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</form>
</div>