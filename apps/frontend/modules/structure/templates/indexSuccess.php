<div class="profile project">
	<div class="sidebar">
		<?php echo include_component("structure", "sidebar", array("structure" => $structure)); ?>
	</div>
	<div class="content">
		<div class="title">
			<?php echo image_tag($structure["photo_std"], array("class" => "user")); ?>
			<div class="block">
				<h1><?php echo $structure["nom"]; ?></h1>
				<div class="entities">
					<?php $i = 0; foreach((array)$structure["Structure"] as $structure): if($i++ >= 3) break; ?>
					<a href="<?php echo url_for("@structure2?slug=".$structure["slug"]); ?>">
						<div class="ent">
							<?php echo $structure["photo_std"]; ?>
							<span><?php echo $structure["nom"]; ?></span>
						</div>
					</a>
					<?php endforeach; ?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		<div class="cadre">
			<?php echo image_tag("new/shadow_650_top.png", array("class"=>"ctop")); ?>
			<div class="data">
				<h2><?php echo __("Présentation"); ?></h2>
				<p>
					<?php echo ($structure["presentation"] ? nl2br($structure["presentation"]) : __("%name n'a pas de présentation", array("%name" => $structure["nom"]))); ?>
				</p>
				<?php if($structure["but"]): ?>
				<h2><?php echo __("But"); ?></h2>
				<p>
					<?php echo nl2br($structure["but"]); ?>
				</p>
				<?php endif; ?>
				<?php if($structure["strategie"]): ?>
				<h2><?php echo __("Stratégie"); ?></h2>
				<p>
					<?php echo nl2br($structure["strategie"]); ?>
				</p>
				<?php endif; ?>
				<?php if($structure["missions"]): ?>
				<h2><?php echo __("Missions"); ?></h2>
				<p>
					<?php echo nl2br($structure["missions"]); ?>
				</p>
				<?php endif; ?>
				<span><?php echo __("modifié le %date", array("%date" => format_date((strtotime($structure["updated_at"]) ? $structure["updated_at"] : $structure["created_at"])))); ?></span>
				<?php if($structure["Metier"]->count() || $structure["Competence"]->count() || $structure["Filiere"]->count() || $structure["Theme"]->count()): ?>
					<h2 class="mar"><?php echo __("Intérêts"); ?></h2>
				<?php endif; ?>
				<?php if($structure["Filiere"]->count()): ?>
				<span class="ast"><?php echo __("Filières"); ?> :</span>
				<div class="green tag-list">
					<?php foreach($structure["Filiere"] as $filiere): ?>
					<label><?php echo link_to($filiere["nom"], "@directory_act?type=filiere&proute=project&slug=".$filiere["slug"]); ?></label>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
				<?php if($structure["Theme"]->count()): ?>
				<span class="ast"><?php echo __("Thèmes"); ?> :</span>
				<div class="green tag-list">
					<?php foreach($structure["Theme"] as $filiere): ?>
					<label><?php echo link_to($filiere["nom"], "@directory_act?type=theme&proute=project&slug=".$filiere["slug"]); ?></label>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
				<?php if($structure["Competence"]->count()): ?>
				<span class="ast"><?php echo __("Compétences recherchées"); ?> :</span>
				<div class="green tag-list">
					<?php foreach($structure["Competence"] as $filiere): ?>
					<label><?php echo link_to($filiere["nom"], "@directory_act?type=competence&proute=project&slug=".$filiere["slug"]); ?></label>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
				<?php if($structure["Metier"]->count()): ?>
				<span class="ast"><?php echo __("Métiers recherchés"); ?> :</span>
				<div class="green tag-list">
					<?php foreach($structure["Metier"] as $filiere): ?>
					<label><?php echo link_to($filiere["nom"], "@directory_act?type=metier&proute=project&slug=".$filiere["slug"]); ?></label>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>
			<div class="clear"></div>
			<?php echo image_tag("new/shadow_650_bottom.png", array("class"=>"cbot")); ?>
		</div>

		<div class="clear"></div>
		<?php if($structure["StructureContact"]->count()): ?>
		<div class="cadre">
			<?php echo image_tag("new/shadow_650_top.png", array("class"=>"ctop")); ?>
			<div class="data">
				<h2><?php echo __("Interlocuteurs"); ?></h2>
				<?php foreach($structure["StructureContact"] as $sc): ?>
				<p class="contact">
					<?php echo image_tag("/uploads/profil/default.png"); ?>
					<span>
						<b><?php echo $sc["prenom"]; ?> <?php echo $sc["nom"]; ?></b> <br/>
						<?php echo $sc["fonction"]; ?>
						<?php if($sf_user->isAuthenticated()): ?>
							<?php if($sc["mail"]) echo "<br/>" . $sc["mail"]; ?>
							<?php if($sc["phone"]) echo "<br/>". $sc["phone"]; ?>
						<?php else: ?>
							<br/> <i><?php echo __("Vous devez être membre pour visualiser les coordonnées."); ?></i>
						<?php endif; ?>
					</span>
					<div class="clear"></div>
				</p>
				<?php endforeach; ?>
			</div>
			<div class="clear"></div>
			<?php echo image_tag("new/shadow_650_bottom.png", array("class"=>"cbot")); ?>
		</div>
		<?php endif; ?>
	</div>
	<div class="clear"></div>
</div>