<div class="head">
	<?php
		if($term = $sf_request->getParameter("search"))
			echo ($total > 1 ? __("<b>%nb</b> projets correspondant à \"%term\"", array("%term" => $term, "%nb" => $total)) : __("<b>%nb</b> projet correspondant à \"%term\"", array("%term" => $term, "%nb" => $total)));
		else
			echo ($total > 1 ? __("<b>%nb</b> projets", array("%nb" => $total)) : __("<b>%nb</b> projet", array("%nb" => $total)));
	?>
	<div class="menu-feed">
		<form action="<?php echo $sf_request->getPathInfo(); ?>" method="get">
			<select alt="<?php echo __("Trier par"); ?>" onchange="form.submit()" name="activity">
				<option value="" disabled><?php echo __("Trier par :"); ?></option>
				<option value="0" <?php if(!$sf_request->getParameter("activity")) echo 'selected'; ?>><?php echo __("Date de création"); ?></option>
				<option value="1" <?php if($sf_request->getParameter("activity")) echo 'selected'; ?>><?php echo __("Activité"); ?></option>
			</select>
			<input placeholder="<?php echo __("Rechercher un projet"); ?>" type="text" class="search" name="search" value="<?php echo $sf_request->getParameter("search"); ?>" <?php if(isset($fixed)) echo 'style="display:none"'; ?>>
			<input type="hidden" name="page" value="1">
		</form>
		<div class="clear"></div>
	</div>
</div>
<?php $i=0; foreach((isset($pager) ? $pager->getResults("project") : $projects) as $project): ?>
<div class="entry-list">
	<div class="block-title">
		<a href="<?php echo $project["url"]; ?>">
			<span><?php echo ($project["Commune"]["Pays"]["nom"] ? $project["Commune"]["Pays"]["nom"] : __("Lieu inconnu")); ?></span>
			<h3><?php echo $project["nom"]; ?></h3>
		</a>
	</div>
	<div class="block-img">
		<a href="<?php echo $project["url"]; ?>">
			<?php echo image_tag($project["photo_mini"], array("alt" => __("Photo du projet %name", array("%name" => $project["nom"])), "class" => "ill")); ?>
		</a>
	</div>
	<div class="block-last">
		<div class="description">
			<?php echo ($project["objectifs_quantitatif"] ? $project["objectifs_quantitatif"] : __("Pas d'objectifs quantitatifs indiquées")); ?>
		</div>
		<div class="guests">
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
			<div class="progress pad">
				<span><?php echo __("Etat d'avancement : %c%", array("%c" => $project["avancement"])); ?></span>
			</div>
		</div>
		<div class="tags">
			<div class="pp">
			<?php foreach($project["Competence"] as $skill): ?>
				<?php echo link_to($skill["nom"], "@directory_act?type=competence&proute=project&slug=".$skill["slug"]); ?> ;
			<?php endforeach; ?>
			<?php if($project["Competence"]->count() == 0): ?>
				<?php echo __("Pas de compétences indiquées"); ?>
			<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="clear"></div>
</div>
<?php endforeach; ?>

<?php if(!$pager->getNbResults()): ?>
	<div class="no-results">
		<?php echo __("Il n'y pas encore de projets"); ?>
	</div>
<?php endif; ?>

<?php if (isset($pager) && $pager->haveToPaginate()): ?>
<div class="clear"></div>
<div class="pagination bottom">
	<?php include_partial('templates/paginate', array('pager' => $pager)) ?>
	<div class="clear"></div>
</div>
<?php endif ?>