<?php if($type == "event"): ?>
	<?php echo __("%inviter vous a invité à l'événement \"<b>%name</b>\", vous avez la possibilité de répondre présent ou non.", array("%inviter" => $inviter, "%name" => $name)); ?><br/><br/>
<?php elseif($type == "project"): ?>
	<?php echo __("%inviter vous a invité à participer au projet \"<b>%name</b>\".", array("%inviter" => $inviter, "%name" => $name)); ?><br/><br/>
<?php endif; ?>
<?php if($message): ?>
	<?php echo __("Message personnel"); ?> : "<?php echo htmlentities($message, ENT_QUOTES, "UTF-8"); ?>"
<br/><br/>
<?php endif; ?>
<?php echo __("Suivez le lien ci-dessous :"); ?>