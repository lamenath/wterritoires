<?php if($structure["ACL"]["write"]): ?>
<div class="block">
	<h3 class="big"><?php echo __("Accès rapides"); ?></h3>
	<div class="clear"></div>
	<a href="<?php echo url_for("structure/edit?id=".$structure["id"]);?>">
		<span class="more big"> > <?php echo __("éditer cette structure"); ?></span>
	</a>
	<div class="clear"></div>
	<a href="<?php echo url_for("@structure2m?slug=".$structure["slug"]);?>">
		<span class="more big"> > <?php echo __("gérer les membres"); ?></span>
	</a>
	<div class="clear"></div>
	<a href="<?php echo url_for("@structure2c?slug=".$structure["slug"]);?>">
		<span class="more big"> > <?php echo __("gérer les contacts"); ?></span>
	</a>
	<div class="clear"></div>
</div>
<?php endif; ?>

<div class="block">
	<?php if($structure["ville"]): ?>
		<h3><?php echo __("%name est implantée à %place", array("%name" => $structure["nom"], "%place" => $structure["ville"])); ?></h3>
		<?php echo image_tag("https://maps.google.com/maps/api/staticmap?center=".$structure["ville"]."&zoom=14&size=260x200&maptype=roadmap&sensor=false", array("alt" => __("Carte de localisation de la structure"))); ?>
	<?php endif; ?>
	<p>
		<b><?php echo $structure["nom"]; ?></b>
		<br/>
		<?php echo $structure["adresse"]; ?><br/>
		<?php if($structure["adresse2"]) echo $structure["adresse2"] . "<br/>"; ?>
		<?php echo $structure["code_postal"] . " " .  $structure["ville"]; ?>
	</p>
	<?php if($structure["tel"]): ?>
	<p>
		<b><?php echo __("Téléphone"); ?></b>
		<br/>
		<?php echo $structure["tel"]; ?>
	</p>
	<?php endif; ?>
	<?php if($structure["mail"]): ?>
	<p>
		<b><?php echo __("Email"); ?></b>
		<br/>
		<?php echo $structure["mail"]; ?>
	</p>
	<?php endif; ?>
	<?php if($structure["website"]): ?>
	<p>
		<b><?php echo __("Site Internet"); ?></b>
		<br/>
		<a href='<?php echo $structure["website"]; ?>' target='_blank'><?php echo $structure["website"]; ?></a>
	</p>
	<?php endif; ?>
	<div class="clear"></div>
</div>

<div class="block">
	<?php if($structure["admins"]->count()): ?>
	<h3><?php echo __("Référent(s)"); ?></h3>
	<ul class="list big">
		<?php foreach($structure["admins"] as $user): ?>
			<?php include_partial("profile/sbline", array("user" => $user)); ?>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	<?php if($structure["members"]->count()): ?>
	<h3><?php echo __("Membre(s)"); ?></h3>
	<ul class="list mini">
		<?php foreach($structure["members"] as $user): ?>
			<?php include_partial("profile/sbline", array("user" => $user)); ?>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	<div class="clear"></div>
</div>