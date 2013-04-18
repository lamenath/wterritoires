<div class="comment" id="commentaire_n_<?php echo $commentaire["id"]; ?>">
	<?php echo image_tag($commentaire["Profil"]["photo_mini"]); ?>
	<div class="data">
		<div class="options">
			<?php if($commentaire["ACL"]["admin"] === true): ?>
				<a class="live-action" data-action="comment-remove" data-type="edit-pass" data-to="<?php echo $commentaire["id"]; ?>"><?php echo __("Supprimer"); ?></a>
			<?php endif; ?>
		</div>
		<h4><a href='<?php echo url_for("@profile?login=".$commentaire["Profil"]["slug"]); ?>'><?php echo $commentaire["Profil"]["full_name"] ?></a>, le <?php echo format_date($commentaire["created_at"]); ?></h4>
		<div class="text"><?php echo $commentaire["message"]; ?></div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>