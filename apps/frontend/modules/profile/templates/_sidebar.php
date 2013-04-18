<?php if($user["ACL"]["read"]): ?>
	<?php if($sf_user->isAuthenticated()): ?>
	<?php $pending = $sf_user->hasPendingRequest($user["id"]); $friend = $sf_user->isFriendWith($user["id"]); ?>
	<div class="preblock">
		<div class="precontact">
			<?php if($user["id"] == $sf_user->getId()): ?>
			<a href="<?php echo url_for("@profileedit?proute=general") ;?>">
				<div class="button-135 big black">
					<div><?php echo __("Editer mon profil"); ?></div>
				</div>
			</a>
			<a href="<?php echo url_for("@profileedit?proute=privacy") ;?>">
				<div class="button-135 big orange">
					<div><?php echo __("Confidentialité"); ?></div>
				</div>
			</a>
			<?php else: ?>
			<?php if($pending && $pending->get("is_activated") != -1): ?>
			<div data-action="friend" data-more="direction=confirm" data-to="<?php echo $user["id"]; ?>" class="live-action button-135">
				<div><?php echo __("Confirmer la demande d'ajout", array("%name" => $name)); ?></div>
			</div>
			<?php elseif(($pending && $pending->get("is_activated") == -1) || ($friend && $friend->get("is_activated") == 0)): ?>
			<div class="live-action button-135">
				<div><?php echo __("Demande encore en attente"); ?></div>
			</div>
			<?php elseif(!$sf_user->isFriendWith($user["id"])): ?>
			<div data-action="friend" data-more="direction=add" data-to="<?php echo $user["id"]; ?>" class="live-action button-135">
				<div><?php echo __("Entrer en contact avec %name", array("%name" => $name)); ?></div>
			</div>
			<?php else: ?>
			<div data-action="friend" data-more="direction=remove" data-to="<?php echo $user["id"]; ?>" class="live-action black button-135">
				<div><?php echo __("Supprimer de mes contacts", array("%name" => $name)); ?></div>
			</div>

			<?php endif; ?>
			<div data-action="inbox" data-to="<?php echo $user["id"]; ?>" class="live-action button-135 orange">
				<div><?php echo __("Envoyer un message à %name", array("%name" => $name)); ?></div>
			</div>
			<?php endif; ?>
			<div class="clear"></div>
		</div>
		<div class="stats">
			<div class="stat">
				<?php echo __("Acteur sur <b>%n</b> projets", array("%n" => $user["count_actor"])); ?>
			</div>
			<div class="stat">
				<?php echo __("Observateur sur <b>%n</b> projets", array("%n" => $user["count_observer"])); ?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<?php endif; ?>
	<div class="block">
		<?php if($count = count($profilref)): ?>
		<h3><?php echo __("Référent dans %n projet(s)", array("%n" => $count)); ?></h3>
		<ul class="list big">
			<?php foreach($profilref as $relation): ?>
			<?php include_partial("project/sbline", array("relation" => $relation)); ?>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<?php if($count2 = count($profilcon)): ?>
		<h3><?php echo __("Contributeur dans %n projet(s)", array("%n" => $count2)); ?></h3>
		<ul class="list mini">
			<?php foreach($profilcon as $relation): ?>
			<?php include_partial("project/sbline", array("relation" => $relation)); ?>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<div class="clear"></div>
		<?php if($obserC): ?>
		<h3><?php echo __("Observateur dans %n projet(s)", array("%n" => $obserC)); ?></h3>
		<ul class="list mini">
			<?php foreach($profilobs as $relation): ?>
			<?php include_partial("project/sbline", array("relation" => $relation)); ?>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<div class="clear"></div>
		<?php if($eventsC = $events->count()): ?>
		<h3><?php echo __("Participe à %n événement(s)", array("%n" => $eventsC)); ?></h3>
		<ul class="list mini">
			<?php foreach($events as $relation): ?>
			<?php include_partial("event/sbline", array("event" => $relation)); ?>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<?php if($count == 0 && $obserC == 0 && $eventsC == 0 && $count2 == 0): ?>
			<?php echo __("%name ne participe à aucun projet", array("%name" => $user["full_name"])); ?>
		<?php endif; ?>
		<div class="clear"></div>
	</div>
	<?php if($user["ville"]): ?>
	<div class="block">
		<h3><?php echo __("%name habite à %place (%zip)", array("%zip" => $user["code_postal"], "%name" => $user["full_name"], "%place" => $user["ville"])); ?></h3>
		<?php echo image_tag("https://maps.google.com/maps/api/staticmap?center=".$user["latitude"].",".$user["longitude"]."&zoom=12&size=260x200&maptype=roadmap&sensor=false"); ?>
		<br/><br/>
		<a href="http://maps.google.fr/maps?q=<?php echo $user["latitude"].",".$user["longitude"]; ?>&um=1&ie=UTF-8&hl=fr&sa=N&tab=wl" target="_blank"><?php echo __("voir sur une carte"); ?></a>
		<div class="clear"></div>
	</div>
	<?php endif; ?>
<?php endif; ?>