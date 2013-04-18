<div id="content-centered">

	<?php echo form_tag('actions/retrieve?ticket='. $sf_request->getParameter("ticket"), array("method" => "post")) ?>
		<div class="table">

			<div class="head">
				<h1><?php echo __("Réinitialisation de votre mot de passe"); ?></h1>
			</div>
			
			<?php if(isset($posted)): ?>
			<div class="super_saved">
				<?php echo __("OK! Votre changement de mot de passe est effectué, vous pouvez dès à présent vous connecter avec votre nouveau mot de passe !"); ?>
			</div>
			<div class="clear"> </div>
			<?php endif; ?>
	
			<?php if(isset($err)): ?>
			<div class="super_error">
				<?php echo $err; ?>
			</div>
			<div class="clear"> </div>
			<?php endif; ?>

			<?php if(!isset($posted)): ?>
			
			<div class="block-quick">
				<?php echo image_tag("/uploads/profil/".$tick->getProfil()->getPicture(true)); ?>
				<div class="txt"><?php echo __("<b>%name</b> : remplissez ce formulaire rapide pour terminer la changement de votre mot de passe !", array("%name"=> $tick->getProfil()->__toString() )); ?></div>
				<div class="clear"> </div>
			</div>

			<div class="block">
				<div class="input">
					<input type="text" name="mail" value="<?php echo $sf_request->getParameter("mail"); ?>">
					<p>Pour des raisons de sécurité, veuillez indiquer ci-dessus l'email utilisé lors de l'inscription</p>
				</div>
				<div class="label">
					<?php echo __("Votre email"); ?> :
				</div>
				<div class="clear"></div>
			</div>
			<div class="block">
				<div class="input">
					<input type="password" name="pass1" value="<?php echo $sf_request->getParameter("pass1"); ?>">
					<p>6 caractères minimum</p>
				</div>
				<div class="label">
					<?php echo __("Nouveau mot de passe"); ?> :
				</div>
				<div class="clear"></div>
			</div>
			<div class="block">
				<div class="input">
					<input type="password" name="pass2" value="<?php echo $sf_request->getParameter("pass2"); ?>">
				</div>
				<div class="label">
					<?php echo __("Retapez ce mot de passe"); ?> :
				</div>
				<div class="clear"></div>
			</div>
			<div class="block">
				<div class="mega_input">
					<input type="submit" value="<?php echo __("Retrouver !"); ?>" class="pops">
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>
	<?php endif; ?>
</div>