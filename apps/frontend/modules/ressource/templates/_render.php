<div id="ressource-<?php echo $item["extraData"]["id"]; ?>" class="entry-list">
	<div class="block-title">
		<span>
			<?php if(RessourceACL::init($item["extraData"]["id"], "admin") === true): ?>
				<h4>
				<a class="live-action" data-action="ressource" data-more="rid=<?php echo $item["extraData"]["id"]; ?>" data-type="<?php echo $identifier; ?>" data-to="<?php echo $id; ?>"><?php echo __("Modifier"); ?></a>
				|
				<a class="live-action" data-action="ressource-remove" data-more="rid=<?php echo $item["extraData"]["id"]; ?>" data-type="<?php echo $identifier; ?>" data-to="<?php echo $id; ?>"><?php echo __("Supprimer"); ?></a>
				</h4>
			<?php endif; ?>
			<?php echo format_date($item["extraData"]["created_at"]);?>
		</span>
		<h3><?php echo $item["extraData"]["nom"]; ?> </h3>
		<p>
			<?php echo __("Ajouté par %name", array("%name" => $item["full_name"])); ?>
			<?php if($item["extraData"]["source"]): ?>
				<?php echo __("| Source: %src", array("%src" => $item["extraData"]["source"])); ?>
			<?php endif; ?>
		</p>
	</div>
	<div class="block-img">
		<?php if($item["extraData"]["fichier"]): ?>
		<a onclick="pageTracker._trackPageview('/downloads/ressource');" href="/uploads/ressource/<?php echo $item["extraData"]["fichier"]; ?>" target="_blank">
			<?php echo image_tag(RRR::getExtPic($item["extraData"]["fichier"]), array("title" => __("Télécharger"), "class" => "trigger-tipsy extension user")); ?>
		</a>
		<?php elseif($item["extraData"]["video"]): ?>
		<a class="live-action" data-action="youtube" data-to="<?php echo $item["extraData"]["video"]; ?>">
			<?php echo image_tag("video-icon.png", array("title" => __("Voir la vidéo"), "class" => "trigger-tipsy extension user")); ?>
		</a>
		<?php endif; ?>
	</div>
	<div class="block-last">
		<div class="description">
			<?php echo ($item["extraData"]["resume"] ? $item["extraData"]["resume"] : __("Pas de description")); ?>
		</div>
		<div class="tags">
			<div class="pp">
				<?php foreach($item["extraData"]["Theme"] as $f): ?>
					<?php echo $f["nom"]; ?> ;
				<?php endforeach; ?>
				<?php if(!isset($item["extraData"]["Theme"]) || !$item["extraData"]["Theme"]->count()) echo __("Pas de thèmes associés"); ?>
			</div>
		</div>
	</div>

	<div class="clear"></div>
</div>