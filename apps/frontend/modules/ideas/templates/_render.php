<div id="<?php echo $identifier = md5($item["id"]); ?>" class="entry-list idea">
	<div class="block-img">
		<?php echo image_tag($item["Profil"]["photo_mini"], array("alt" => __("Photo de %name", array("%name" => $item["Profil"]["full_name"])), "class" => "user")); ?>
	</div>
	<div class="block-all">
		<div class="block-title">
			<span>
				<?php if($item["ACL"]["admin"] === true): ?>
					<h4>
					<a class="live-action" data-action="idea" data-more="iid=<?php echo $item["id"]; ?>" data-type="edit-pass" data-to="<?php echo $item["id"]; ?>"><?php echo __("Modifier"); ?></a>
					|
					<a class="live-action" data-action="idea-remove" data-type="edit-pass" data-to="<?php echo $item["id"]; ?>"><?php echo __("Supprimer"); ?></a>
					</h4>
				<?php endif; ?>
				<?php echo format_date($item["created_at"]);?>
			</span>
			<h3><?php echo $item["titre"]; ?></h3>
			<h4><?php echo __("par %name", array("%name" => $item["Profil"]["full_name"])); ?> | <div data-cid="<?php echo $item["id"]; ?>" data-ctype="idea" class="voters"><?php echo __("%nb votant(s)", array("%nb" => $item["nb_vote"])); ?></div></h4>
		</div>
		<div class="block-last">
			<div class="description">
				<?php echo $item["message"]; ?>
			</div>
			<div class="clear"></div>
			<div class="comments">
				<?php include_component("commentaire", "list", array("identifier" => $identifier, "voted" => $item["did_i_vote"], "cid" => $item["id"], "ctype" => "idea")); ?>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>