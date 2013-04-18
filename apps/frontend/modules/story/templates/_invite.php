<h3 class="less"><?php echo __("<a href='%url'>%name</a> a invité %count personnes", array( "%url" => $item["url"], "%count" => $item["extraData"]["Buddies"]->count(), "%name" => $item["full_name"])); ?></h3>
<div class="buddies">
	<?php $i=0; foreach($item["extraData"]["Buddies"] as $data): ?>
		<?php if(++$i > 32) break; echo image_tag($data["photo_mini"], array("alt" => $data["full_name"], "class" => "trigger-tipsy", "title" => $data["full_name"])); ?>
	<?php endforeach; ?>
	<div class="clear"></div>
</div>