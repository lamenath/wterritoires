<?php if(isset($home)): $msgc = $sf_user->getNewMessagesCount(); ?>
	<?php if($total || $wish || $msgc): ?>
	<div class="invitations">
		<?php if($total): ?>
		<div class="invitation">
			<h2><?php echo __("%count invitation(s) à confirmer", array("%count" => $total)); ?></h2>
			<a href="<?php echo url_for("home/invitations"); ?>"> <?php echo __("Répondre aux invitations"); ?> </a>
		</div>
		<?php endif; ?>
		
		<?php if($wish): ?>
		<div class="invitation">
			<h2><?php echo __("%count demande(s) à confirmer", array("%count" => $wish)); ?></h2>
			<a href="<?php echo url_for("home/invitations"); ?>"> <?php echo __("Consulter les demandes"); ?> </a>
		</div>
		<?php endif; ?>
		
		<?php if($msgc): ?>
		<div class="invitation">
			<h2><?php echo __("%count message(s) à lire", array("%count" => $msgc)); ?></h2>
			<a href="<?php echo url_for("inbox/in"); ?>"> <?php echo __("Lire vos messages"); ?> </a>
		</div>
		<?php endif; ?>
	</div>
	<?php endif; ?>
<?php else: ?>
<div class="head">
	<?php echo __("%c invitation(s) en attente", array("%c" => $total)); ?>
	<div class="menu-feed">
		<div class="clear"></div>
	</div>
</div>
<div class="common-feed">
	<div class="padded">
		<?php foreach($wish as $item): $pro = Doctrine::getTable("Projet")->find($item["extraData"]["projet_id"]); ?>
		<div id="wish_<?php echo $item["extraData"]["id"]; ?>" class="entry">
			<?php echo image_tag($item["photo_mini"], array("class" => "user")); ?>
			<div class="s-buttons">
				<a data-action="wishco" data-more="direction=confirm" data-to="<?php echo $item["extraData"]["id"]; ?>" class="live-action button"><span><?php echo __("Accepter ou Ignorer"); ?></span></a>
			</div>
			<div class="info">
				<h3><?php echo __("%name aimerait rejoindre le groupe de travail \"%gname\"", array("%gname" => $pro->getNom(), "%name" => $item["full_name"])); ?></h3>
				<span><?php echo __("le %date", array("%date" => format_date($item["extraData"]["created_at"], "f"))); ?></span>
			</div>
		</div>
		<?php endforeach; ?>
		<?php foreach($frequests as $item): ?>
		<div class="entry">
			<?php echo image_tag($item["photo_mini"], array("class" => "user")); ?>
			<div class="s-buttons">
				<a data-action="friend" data-more="direction=confirm" data-to="<?php echo $item["id"]; ?>" class="live-action button"><span><?php echo __("Accepter ou Ignorer"); ?></span></a>
			</div>
			<div class="info">
				<h3><?php echo __("%name souhaite entrer en contact avec vous", array("%name" => $item["full_name"])); ?></h3>
				<span><?php echo __("le %date", array("%date" => format_date($item["extraData"]["created_at"], "f"))); ?></span>
			</div>
		</div>
		<?php endforeach; ?>
		<?php foreach($erequests as $item): ?>
		<div id="invitation_<?php echo $item["extraData"]["id"]; ?>" class="entry">
			<?php echo image_tag($item["photo_mini"], array("class" => "user")); ?>
			<div class="s-buttons">
				<a data-to="<?php echo $item["id"]; ?>" data-action="attending" data-more="join" class="live-action button"><span><?php echo __("Oui"); ?></span></a>
				<a data-to="<?php echo $item["id"]; ?>" data-action="attending" data-more="part" class="live-action button"><span><?php echo __("Non"); ?></span></a>
				<a data-action="invitation" data-more="direction=hide" data-to="<?php echo $item["extraData"]["id"]; ?>" class="live-action button"><span><?php echo __("Cacher l'invitation"); ?></span></a>
			</div>
			<a href="<?php echo $item["url"]; ?>">
			<div class="info">
				<h3><?php echo __("Invitation à rejoindre l'événement \"%name\"", array("%name" => $item["titre"])); ?></h3>
				<span><?php echo __("le %date", array("%date" => format_date($item["extraData"]["created_at"], "f"))); ?></span>
			</div>
			</a>
		</div>
		<?php endforeach; ?>
		<?php foreach($prequests as $item): ?>
			<div id="invitation_<?php echo $item["extraData"]["id"]; ?>" class="entry">
				<?php echo image_tag($item["photo_mini"], array("class" => "user")); ?>
				<div class="s-buttons">
					<a data-to="<?php echo $item["id"]; ?>" data-action="joinp" data-type="join" data-role="contributeur" class="live-action button"><span><?php echo __("Participer"); ?></span></a>
					<a data-to="<?php echo $item["id"]; ?>" data-action="joinp" data-type="join" data-role="observateur" class="live-action button"><span><?php echo __("Observer"); ?></span></a>
					<a data-action="invitation" data-more="direction=hide" data-to="<?php echo $item["extraData"]["id"]; ?>" class="live-action button"><span><?php echo __("Cacher l'invitation"); ?></span></a>
				</div>
				<a href="<?php echo $item["url"]; ?>">
				<div class="info">
					<h3><?php echo __("Invitation à rejoindre le projet \"%name\"", array("%name" => $item["nom"])); ?></h3>
					<span><?php echo __("le %date", array("%date" => format_date($item["extraData"]["created_at"], "f"))); ?></span>
				</div>
				</a>
			</div>
		<?php endforeach; ?>
		<?php if(!$total): ?>
		<div class="no-results">
			<?php echo __("Vous n'avez pas d'invitations pour le moment..."); ?>
		</div>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>