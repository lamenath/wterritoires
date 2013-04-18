<div class="profile project event">
	<div class="sidebar">
		<?php echo include_component("event", "sidebar", array("event" => $event)); ?>
	</div>
	<div class="content">
		<div class="privacy">
			<?php if($event["visibilite"] == "public"): ?>
				<?php echo __("événement public"); ?>
			<?php else: ?>
				<span class="private"><?php echo __("événement privé"); ?></span>
			<?php endif;?>
		</div>
		<div class="top-tag green tag-list">
			<?php foreach($event["Filiere"] as $pf): ?>
			<label><?php echo link_to($pf["nom"], "@directory_act?type=filiere&proute=event&slug=".$pf["slug"]); ?></label>
			<?php endforeach; ?>
		</div>
		<div class="title">
			<div class="calendate">
				<p class="day">
					<?php echo $event["date"]["day"]; ?>
				</p>
				<p class="num">
					<?php echo $event["date"]["num"]; ?>
				</p>
				<p class="month">
					<?php echo $event["date"]["month"]; ?>
				</p>
			</div>
			<?php echo image_tag($event["photo_std"], array("class" => "user")); ?>
			<div class="block">
				<h1><?php echo $event["titre"]; ?></h1>
				<div class="block">
					<div class="tags">
						<?php foreach($event["Theme"] as $f): ?>
							<?php echo link_to($f["nom"], "@directory_act?type=theme&proute=event&slug=".$f["slug"]); ?>
						<?php endforeach; ?>
					</div>
					<div class="descr">
						<?php echo $event["description"]; ?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		<?php if($event["ACL"]["read"] === true): ?>
		<div class="clear"></div>
		<div class="carousel-menu">
			<?php include_component("templates", "menu", array("object" => $event, "module" => "event", "load" => "event_profile")); ?>
			<div class="clear"></div>
			<div class="carousel">
				<div class="content-fixed">
					<div class="common-feed">
						<?php include_component((isset($moduleRoute) ? $moduleRoute : "event"), $proute, array("model" => "Event", "identifier" => "event", "acl" => $event["ACL"], "event" => $event, "id" => $event["id"])); ?>
					</div>
				</div>
				<div class="clear"></div>
				<?php echo image_tag("new/shadow_650_bottom.png", array("class" => "shadow bottom")); ?>
			</div>
		</div>
		<?php else: ?>
			<h3 class="no-rights"><?php echo __("Cet événement est privé, pour le rejoindre et le consulter, un administrateur doit vous y inviter."); ?></h3>
		<?php endif; ?>
	</div>
	<div class="clear"></div>
</div>