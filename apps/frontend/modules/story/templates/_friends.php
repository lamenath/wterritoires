<?php if($item["extraData"]["object_id"] == $sf_user->getId()): ?>
<h3><?php echo __("%name a accepté votre demande de mise en relation", array("%name" => $item["full_name"])); ?></h3>
<?php else: ?>
<h3><?php echo __("%name est désormais en contact avec %contact", array("%contact" => $item["extraData"]["obj"]["full_name_me"], "%name" => $item["full_name"])); ?></h3>
<?php endif; ?>