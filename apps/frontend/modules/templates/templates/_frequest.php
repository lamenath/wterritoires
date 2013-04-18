<?php if($direction == "notify"): ?>
	<?php echo __("<b>%inviter</b> vous invite à entrer en contact sur <b>%he</b>.", array("%he" => sfConfig::get('app_email_header'), "%inviter" => $automatic_sender["full_name"], "%name" => $name)); ?><br/><br/>
	<?php echo __("Suivez le lien ci-dessous :"); ?>
<?php else: ?>
	<?php echo __("<b>%inviter</b> a accepté votre demande de mise en relation sur <b>%he</b>.", array("%he" => sfConfig::get('app_email_header'), "%inviter" => $automatic_sender["full_name"], "%name" => $name)); ?><br/><br/>
	<?php echo __("Pour consulter son profil :"); ?>
<?php endif; ?>