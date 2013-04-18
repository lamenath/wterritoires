<?php if($event["ACL"]["read"] === true): ?>
	<?php // if($event["visibilite"] == "public"): ?>
	<?php if($sf_user->isAuthenticated()): ?>
		<div class="preblock">
		<div class="precontact">
			<div data-to="<?php echo $event["id"]; ?>" data-action="attending" data-more="join" class="<?php if($event["my_response"] == "yes") echo "disabled "; ?>live-action button-135 big">
				<div><?php echo __("Répondre Oui"); ?></div>
			</div>
			<div data-to="<?php echo $event["id"]; ?>" data-action="attending" data-more="part" class="<?php if($event["my_response"] == "no") echo "disabled "; ?>live-action button-135 big orange">
				<div><?php echo __("Répondre Non"); ?></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="stats">
			<div class="stat">
				<?php echo __("%n participant(s)", array("%n" => $event["participants"]->count() )); ?>
			</div>
			<div class="stat">
				<?php echo __("%n invité(s)", array("%n" => $event["guests"]->count() )); ?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<?php endif; ?>
	<?php if($event["ACL"]["write"] || $event["ACL"]["invite"]): ?>
	<div class="block">
		<h3 class="big"><?php echo __("Accès rapides"); ?></h3>
		<div class="clear"></div>
		<a href="<?php echo url_for("@eventedit?id=".$event["id"]);?>">
			<span class="more big"> > <?php echo __("éditer cet événement"); ?></span>
		</a>
		<div class="clear"></div>
		<a class="live-action" data-action="invite" data-more="eid=<?php echo $event["id"];?>">
			<span class="more big"> > <?php echo __("inviter des contacts"); ?></span>
		</a>
		<div class="clear"></div>
		<a class="live-action" data-action="mailing" data-more="eid=<?php echo $event["id"];?>">
			<span class="more big"> > <?php echo __("envoyer un email aux participants"); ?></span>
		</a>
		<div class="clear"></div>
	</div>
	<?php endif; ?>
	<?php if($event["participants"]->count() || $event["guests"]->count() || $event["nos"]->count()): ?>
	<div class="block">
		<?php if($event["participants"]->count()): ?>
		<h3><?php echo __("Participants (%count)", array("%count" => $event["participants"]->count()) ); ?></h3>
		<ul class="list big">
			<?php foreach($event["participants"] as $user): ?>
				<?php include_partial("profile/sbline", array("user" => $user)); ?>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<?php if($event["guests"]->count()): ?>
		<h3><?php echo __("En attente de réponse (%count)", array("%count" => $event["guests"]->count()) ); ?></h3>
		<ul class="list mini">
			<?php foreach($event["guests"] as $user): ?>
				<?php include_partial("profile/sbline", array("user" => $user)); ?>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<?php if($event["nos"]->count()): ?>
		<h3><?php echo __("Ne participeront pas (%count)", array("%count" => $event["nos"]->count()) ); ?></h3>
		<ul class="list mini">
			<?php foreach($event["nos"] as $user): ?>
				<?php include_partial("profile/sbline", array("user" => $user)); ?>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<div class="clear"></div>
	</div>
	<?php endif ;?>
	
	<?php include_partial("galerie/render", array("type" => "eid", "item" => $event, "pictures" => $pictures)); ?>
	
	<div class="block">
		<h3><?php echo __("<b>%place</b>", array("%place" => $event["lieu"])); ?></h3>
		<h3><?php echo __("%addr / %vill", array("%vill" => $event["ville"], "%addr" => $event["adresse"])); ?></h3>
		<?php echo image_tag("https://maps.google.com/maps/api/staticmap?center=".$event["ville"]."&zoom=14&size=260x200&maptype=roadmap&sensor=false"); ?>
		<div class="clear"></div>
	</div>
<?php endif; ?>