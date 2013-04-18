<?php if($sf_user->isAuthenticated()): ?>
	<?php if($project["ACL"]["read"] === true): ?>
	<div class="preblock">
		<div class="precontact">
			<?php if($sf_user->isInProjet($project["id"])): ?>
			<div data-to="<?php echo $project["id"]; ?>" data-action="joinp" data-type="part" data-role=""  class="black live-action button-135 big">
				<div><?php echo __("Quitter"); ?></div>
			</div>
			<?php else: ?>
			<div data-to="<?php echo $project["id"]; ?>" data-action="joinp" data-type="join" data-role="contributeur"  class="live-action button-135 big">
				<div><?php echo __("Participer"); ?></div>
			</div>
			<div data-to="<?php echo $project["id"]; ?>" data-action="joinp" data-type="join" data-role="observateur" class="live-action button-135 big orange">
				<div><?php echo __("Observer"); ?></div>
			</div>
			<?php endif; ?>
			<div class="clear"></div>
		</div>
		<div class="stats">
			<div class="stat">
				<?php echo __("<b>%n</b> Acteur(s)", array("%n" => $project["count_actors"])); ?>
			</div>
			<div class="stat">
				<?php echo __("<b>%n</b> Observateur(s)", array("%n" => $project["count_observers"])); ?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
		<?php if($project["ACL"]["write"] || $project["ACL"]["invite"]): ?>
		<div class="block">
			<h3 class="big"><?php echo __("Accès rapides"); ?></h3>
			<div class="clear"></div>
			<?php if($project["ACL"]["write"]): ?>
			<a href="<?php echo url_for("@projectedit?id=".$project["id"]);?>">
				<span class="more big"> > <?php echo __("éditer ce projet"); ?></span>
			</a>
			<div class="clear"></div>
			<?php endif; ?>
			<?php if($project["ACL"]["invite"]): ?>
			<a class="live-action" data-action="invite" data-more="pid=<?php echo $project["id"];?>">
				<span class="more big"> > <?php echo __("inviter des contacts"); ?></span>
			</a>
			<div class="clear"></div>
			<?php endif; ?>
			<?php if($project["ACL"]["write"]): ?>
			<a class="live-action" data-action="mailing" data-more="pid=<?php echo $project["id"];?>">
				<span class="more big"> > <?php echo __("envoyer un email aux membres"); ?></span>
			</a>
			<div class="clear"></div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	<?php endif; ?>
<?php endif;?>
	
<?php if($project["observers"]->count() || $project["referents"]->count() || $project["contributors"]->count()): ?>
<div class="block">
	<?php if($project["referents"]->count()): ?>
	<h3><?php echo __("Référent(s)"); ?></h3>
	<ul class="list big">
		<?php foreach($project["referents"] as $user): ?>
			<?php include_partial("profile/sbline", array("user" => $user)); ?>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	<?php if($project["contributors"]->count()): ?>
	<h3><?php echo __("Contributeur(s)"); ?></h3>
	<ul class="list mini">
		<?php foreach($project["contributors"] as $user): ?>
			<?php include_partial("profile/sbline", array("user" => $user)); ?>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	<?php if($project["observers"]->count()): ?>
	<h3><?php echo __("Observateurs(s)"); ?></h3>
	<ul class="list mini">
		<?php foreach($project["observers"] as $user): ?>
			<?php include_partial("profile/sbline", array("user" => $user)); ?>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	<div class="clear"></div>
</div>
<?php endif; ?>

<?php include_partial("galerie/render", array("type" => "pid", "item" => $project, "pictures" => $pictures)); ?>

<?php if($project["ACL"]["read"] === true): ?>
	<?php if($project["Commune"]): ?>
	<div class="block">
		<h2><?php echo __("Géolocalisation"); ?></h2>
		<h4><?php echo __("Implantation du projet: <b>%place</b>", array("%place" => $project["Commune"]["Pays"]["nom"])); ?></h4>
		<h4><?php echo __("Ce projet est à portée <b>%portee</b>", array("%portee" => $project["action"])); ?></h4>
		<?php echo image_tag("https://maps.google.com/maps/api/staticmap?center=".$project["Commune"]["latitude"].",".$project["Commune"]["longitude"]."&zoom=12&size=260x200&maptype=roadmap&sensor=false", array("alt" => __("Carte montrant le lieu du projet"), "class" => "map")); ?>
		<div class="clear"></div>
	</div>
	<?php endif; ?>
	<?php include_component("project", "similar", array("project" => $project)); ?>
<?php endif; ?>