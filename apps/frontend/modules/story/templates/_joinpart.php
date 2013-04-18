<?php if($params["etat"] == "yes"): ?>
	<h3><?php echo __("<a href='%url'>%name</a> participera à l'événement", array( "%url" => $item["url"],"%name" => $item["full_name"])); ?></h3>
<?php else: ?>
	<h3 class="less"><?php echo __("<a href='%url'>%name</a> ne pourra pas participer à l'événement", array( "%url" => $item["url"],"%name" => $item["full_name"])); ?></h3>
<?php endif; ?>
