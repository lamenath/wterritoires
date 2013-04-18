<div class="jCarousel">
	<ul class="projects-home <?php if(isset($homepage)) echo 'homepage '; if(isset($jcarousel)) echo 'no'; ?>">
		<?php $i=0; foreach($projects as $project): ?>
		<a href="<?php echo $project["url"]; ?>">
		<li <?php if(++$i%4==0 && !isset($jcarousel)) echo "class='last'"; ?>>
			<?php echo image_tag("new/shadow_card-top.png", array("class" => "card-top")); ?>
			<h3 class="filiere"><?php echo (isset($project["Filiere"][0]) ? $project["Filiere"][0]["nom"] : __("Filière inconnue")); ?></h3>
			<div class="clear"></div>
			<div class="cartouche">
				<h2 class="title"><?php echo $project["nom"]; ?></h2>
				<span class="pays">
					<?php echo image_tag("new/ico_16_map.png", array("alt" => __("Lieu"))); ?>
					<?php echo ($project["Commune"]["Pays"]["nom"] ? $project["Commune"]["Pays"]["nom"] : __("Lieu inconnu")); ?>
				</span>
				<?php echo image_tag($project["photo_max"], array("alt" => __("Photo du projet %name", array("%name" => $project["nom"])), "class" => "ill")); ?>
				<div class="description">
					<?php echo ($project["objectifs_quantitatif"] ? $project["objectifs_quantitatif"] : __("Pas d'objectifs quantitatifs indiquées")); ?>
				</div>
				<div class="open">
					<?php echo image_tag("new/ico_16_people.png", array("alt" => __("Nom du meneur de projet"))); ?>
					<div class="cont"><?php echo $project["creator"]["full_name"]; ?></div>
					<div class="clear"></div>
				</div>
				<div class="open skill">
					<?php echo image_tag("new/ico_16_tag.png", array("alt" => __("Liste des tags"))); ?>
					<div class="cont">
						<?php foreach($project["Competence"] as $skill): ?>
							<?php echo link_to($skill["nom"], "@directory_act?type=competence&proute=project&slug=".$skill["slug"]); ?> ;
						<?php endforeach; ?>
						<?php if($project["Competence"]->count() == 0): ?>
							<?php echo __("Pas de compétences indiquées"); ?>
						<?php endif; ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="open double">
					<div>
						<span><?php echo $project["count_actors"]; ?></span>
						<?php echo __("Acteurs"); ?>
					</div>
					<div class="next">
						<span><?php echo $project["count_observers"]; ?></span>
						<?php echo __("Observateurs"); ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="progress">
					<?php echo image_tag("new/percent-home.png", array("style" => "height: 10px; width: ".(int)$project["avancement"]."%")); ?>
				</div>
				<div class="progress">
					<span><?php echo __("Etat d'avancement : %c%", array("%c" => $project["avancement"])); ?></span>
				</div>
				<div class="clear"></div>
			</div>
			<?php echo image_tag("new/shadow_card-bottom.png", array("class" => "card")); ?>
			<div class="clear"></div>
		</li>
		</a>
		<?php endforeach; ?>
		<?php if(isset($homepage)): ?>
		<li class="last">
			<div class="add">
				<a href="<?php echo url_for("@projectadd"); ?>">
				<span>
					<?php echo image_tag("new/ico_26_plus.png"); ?>
					<div><?php echo __("Ajouter <b>Votre Projet</b>"); ?></div>
				</span>
				</a>
			</div>
			<div class="add">
				<a href="<?php echo url_for("projects/list"); ?>">
				<span>
					<?php echo image_tag("new/ico_26_folder.png"); ?>
					<div><?php echo __("Voir <b>tous les projets</b>"); ?></div>
				</span>
				</a>
			</div>
			<div class="add">
				<a href="<?php echo url_for("default/map"); ?>">
				<span>
					<?php echo image_tag("new/ico_26_map.png"); ?>
					<div><?php echo __("Près de <b>chez Vous</b>"); ?></div>
				</span>
				</a>
			</div>
		</li>
		<?php endif; ?>
	</ul>
</div>