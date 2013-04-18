<?php if($params["role"] == "referent"): ?>
	<h3><?php echo __("<a href='%url'>%name</a> est désormais référent du projet", array("%url" => $item["url"], "%name" => $item["full_name"])); ?></h3>
<?php elseif($params["role"] == "contributeur"): ?>
	<h3><?php echo __("<a href='%url'>%name</a> contribue désormais au projet", array("%url" => $item["url"], "%name" => $item["full_name"])); ?></h3>
<?php else: ?>
	<h3 class="less"><?php echo __("<a href='%url'>%name</a> observe désormais au projet", array("%url" => $item["url"], "%name" => $item["full_name"])); ?></h3>
<?php endif; ?>