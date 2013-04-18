<?php if($item["extraData"]["object_model"] == "Event"): ?>
	<h3><?php echo __("%name a créé l'événement", array("%name" => $item["full_name"])); ?></h3>
<?php elseif($item["extraData"]["object_model"] == "Projet"): ?>
	<h3><?php echo __("%name a créé le projet", array("%name" => $item["full_name"])); ?></h3>
<?php endif; ?>