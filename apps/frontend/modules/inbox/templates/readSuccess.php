<div class="inbox inbox-<?php echo $message["extraData"]["id"]; ?>">
	<div class="tab">
		<div class="left">
			<?php echo __("De"); ?> :
		</div>
		<div class="right">
			<a href="<?php echo $message["extraData"]["Sender"]["url"]; ?>" target="_blank">
				<?php echo image_tag($message["extraData"]["Sender"]["photo_mini"], array("alt" => $message["extraData"]["Sender"]["full_name"])); ?>
				<span><?php echo $message["extraData"]["Sender"]["full_name"]; ?></span>
			</a>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="tab">
		<div class="left">
			<?php echo __("A"); ?> :
		</div>
		<div class="right">
			<a href="<?php echo $message["url"]; ?>" target="_blank">
				<?php echo image_tag($message["photo_mini"], array("alt" => $message["full_name"])); ?>
				<span><?php echo $message["full_name"]; ?></span>
			</a>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="tab">
		<div class="left">
			<?php echo __("Date"); ?> :
		</div>
		<div class="right">
			<div><?php echo format_date($message["extraData"]["created_at"], "U"); ?></div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="tab">
		<div class="left">
			<?php echo __("Sujet"); ?> :
		</div>
		<div class="right">
			<div><?php echo ($message["extraData"]["sujet"]?$message["extraData"]["sujet"]:__("sans objet")); ?></div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="block-text">
		<?php echo nl2br($message["extraData"]["message"]); ?>
	</div>
	<div class="block-buttons">
		
		<a href="javascript:;" data-action="inbox" data-more="mid=<?php echo $message["extraData"]["id"]; ?>" data-to="<?php echo ($message["id"] == $sf_user->getId() ? $message["extraData"]["Sender"]["id"] : $message["id"]); ?>" class="live-action button"><span><?php echo __("Répondre"); ?></span></a>
		<a href="javascript:;" data-action="inbox-remove" data-to="<?php echo $message["extraData"]["id"]; ?>" class="live-action button"><span><?php echo __("Supprimer"); ?></span></a>
		
		
	</div>
</div>