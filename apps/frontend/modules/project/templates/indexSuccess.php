<div class="profile project">
	<div class="sidebar">
		<?php echo include_component("project", "sidebar", array("project" => $project)); ?>
	</div>
	<div class="content">
		<div class="privacy">
			<?php if($project["type"] == "public"): ?>
				<?php echo __("projet public"); ?>
			<?php else: ?>
				<?php echo __("groupe de travail (privé)"); ?>
			<?php endif; ?>
		</div>
		<div class="green tag-list">
			<?php foreach($project["Filiere"] as $pf): ?>
			<label><?php echo link_to($pf["nom"], "@directory_act?type=filiere&proute=project&slug=".$pf["slug"]); ?></label>
			<?php endforeach; ?>
		</div>
		<h1 class="head">
			<?php echo $project["nom"]; ?>
		</h1>
		<div class="title">
			<?php echo image_tag($project["photo_std"], array("alt" => __("Photo du projet %name", array("%name" => $project["nom"])), "class" => "user")); ?>
			<div class="block">
				<div class="tags">
					<?php foreach($project["Theme"] as $f): ?>
						<?php echo link_to($f["nom"], "@directory_act?type=theme&proute=project&slug=".$f["slug"]); ?> ;
					<?php endforeach; ?>
				</div>
				<div class="descr">
					<?php if($project["besoins"]): ?>
					<p>
						<b><?php echo __("Besoins"); ?> :</b> <?php echo $project["besoins"]; ?>
					</p>
					<?php endif; ?>
					<?php if($project["objectifs_qualitatif"]): ?>
					<p>
						<b><?php echo __("Objectifs Qualitatifs"); ?> :</b> <?php echo $project["objectifs_qualitatif"]; ?>
					</p>
					<?php endif; ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<?php if($project["ACL"]["read"] === true): ?>
		<div class="clear"></div>
		<div class="carousel-menu">
			<?php include_component("templates", "menu", array("object" => $project, "module" => "project", "load" => "project_profile")); ?>
			<div class="clear"></div>
			<div class="carousel">
				<div class="content-fixed">
					<div class="common-feed">
					<?php include_component((isset($moduleRoute) ? $moduleRoute : "project"), $proute, array("model" => "Projet", "acl" => $project["ACL"], "identifier" => "project", "project" => $project, "id" => $project["id"])); ?>
					</div>
				</div>
				<div class="clear"></div>
				<?php echo image_tag("new/shadow_650_bottom.png", array("class" => "shadow bottom")); ?>
			</div>
		</div>
		<?php else: ?>
			<div class="clear"></div>
			<h3 class="no-rights"><?php echo __("Pour avoir la possibilité de consulter et de rejoindre ce groupe de travail, un administrateur doit vous y avoir invité."); ?></h3>
			<div class="no-rights-wish">
				<?php if($sf_user->isAuthenticated()): ?>
					<a data-to="<?php echo $project["id"]; ?>" data-action="wish" class="live-action button"><span><?php echo __("Demander l'accès au groupe"); ?></span></a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="clear"></div>
</div>