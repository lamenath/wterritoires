<div class="comment-block">
	<?php if($sf_user->isAuthenticated()): ?>
	<div data-identifier="<?php echo $identifier; ?>" data-cid="<?php echo $cid; ?>" data-ctype="<?php echo $ctype; ?>" class="comment-it">
		<a class="comment-for"><?php echo image_tag("comment.gif"); ?><?php echo __("Commenter"); ?></a>
		<a data-direction="1" class="vote-for<?php if($voted > 0) echo ' hide'; ?>"><?php echo image_tag("vote_yes.gif"); ?><?php echo __("Voter pour"); ?></a>
		<a data-direction="0" class="vote-for<?php if($voted <= 0) echo ' hide'; ?>"><?php echo image_tag("vote_no.gif"); ?><?php echo __("Retirer mon vote"); ?></a>
	</div>
	<?php endif; ?>
	<div class="comment-list">
		<?php foreach($comments as $comment): ?>
			<?php echo include_partial("commentaire/displaycomment", array("commentaire" => $comment)); ?>
		<?php endforeach; ?>
	</div>
	<div class="new-comment-template">
		<form method="post" action="/commentaire/add?ctype=<?php echo $ctype; ?>&cid=<?php echo $cid; ?>" class="comment ajaxForm new" data-cid="<?php echo $cid; ?>" data-ctype="<?php echo $ctype; ?>">
			<?php echo image_tag("/uploads/profil/default.png"); ?>
			<div class="data">
				<div class="text">
					<textarea id="message" name="commentaire[message]" class="message"></textarea>
				</div>
				<input value="<?php echo __("Publier"); ?>" type="submit">
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</form>
	</div>
</div>