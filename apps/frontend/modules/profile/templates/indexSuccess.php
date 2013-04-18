<div class="profile">
	<div class="sidebar">
		<?php echo include_component("profile", "sidebar", array("user" => $user)); ?>
	</div>
	<div class="content">
		<div class="privacy">
			<?php echo ($user["privacy_type"] == "public" ? __("profil public") : __("profil privé")); ?>
		</div>
		<div class="title">
			<?php echo image_tag($user["photo_mini"], array("class" => "user", "alt" =>__("Photo de profil"))); ?>
			<div class="block">
				<h1><?php echo $user["full_name"]; ?></h1>
				<div class="entities">
					<?php $i = 0; foreach($user["Structure"] as $structure): if($i++ >= 3) break; ?>
					<a href="<?php echo url_for("@structure2?slug=".$structure["slug"]); ?>">
						<div class="ent">
							<?php echo image_tag("/uploads/structure/". ($structure["photo"] ? "normal_" . $structure["photo"] : "default.png"), array("alt" => __("Logo de la structure"))); ?>
							<span><?php echo $structure["nom"]; ?></span>
						</div>
					</a>
					<?php endforeach; ?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		<?php if($user["ACL"]["read"]): ?>
		<div class="clear"></div>
		<div class="cadre">
			<?php echo image_tag("new/shadow_650_top.png", array("class"=>"ctop")); ?>
			<div class="data">
				<h2><?php echo __("Présentation"); ?></h2>
				<p>
					<?php echo ($user["presentation"] ? nl2br($user["presentation"]) : __("%name n'a pas rempli sa présentation personnelle", array("%name" => $user["full_name"]))); ?>
				</p>
				<span><?php echo __("modifié le %date", array("%date" => format_date((strtotime($user["updated_at"]) ? $user["updated_at"] : $user["created_at"])))); ?></span>
				<?php if($user["Filiere"]->count() || $user["Theme"]->count()): ?>
					<h2 class="mar"><?php echo __("Intérêts"); ?></h2>
				<?php endif; ?>
				<?php if($user["Filiere"]->count()): ?>
				<span class="ast"><?php echo __("Filières"); ?> :</span>
				<div class="green tag-list">
					<?php foreach($user["Filiere"] as $filiere): ?>
					<label><?php echo link_to($filiere["nom"], "@directory_act?type=filiere&proute=user&slug=".$filiere["slug"]); ?></label>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
				<?php if($user["Theme"]->count()): ?>
				<span class="ast"><?php echo __("Thèmes"); ?> :</span>
				<div class="green tag-list">
					<?php foreach($user["Theme"] as $filiere): ?>
					<label><?php echo link_to($filiere["nom"], "@directory_act?type=theme&proute=project&slug=".$filiere["slug"]); ?></label>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>
			<div class="clear"></div>
			<?php echo image_tag("new/shadow_650_bottom.png", array("class"=>"cbot")); ?>
		</div>
		<?php else: ?>
		<div class="cadre">
		<?php echo image_tag("new/shadow_650_top.png", array("class"=>"ctop")); ?>
			<div class="data">
				<h2><?php echo __("Connectez-vous ou entrez en contact avec %name pour consulter son profil", array("%name" => $user["full_name"])); ?></h2>
			</div>
			<div class="clear"></div>
			<?php echo image_tag("new/shadow_650_bottom.png", array("class"=>"cbot")); ?>
		</div>
		<?php endif; ?>
	</div>
	<div class="clear"></div>
</div>