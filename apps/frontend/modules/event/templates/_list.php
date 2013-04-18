<div class="head">
	<?php
		if($term = $sf_request->getParameter("search"))
			echo ($total > 1 ? __("<b>%nb</b> événements correspondant à \"%term\"", array("%term" => $term, "%nb" => $total)) : __("<b>%nb</b> événement correspondant à \"%term\"", array("%term" => $term, "%nb" => $total)));
		else
			echo ($total > 1 ? __("<b>%nb</b> événements", array("%nb" => $total)) : __("<b>%nb</b> événement", array("%nb" => $total)));
	?>
	<div class="menu-feed">
		<form action="<?php echo $sf_request->getPathInfo(); ?>" method="get">
			<input type="text" placeholder="<?php echo __("Rechercher un événement"); ?>" class="search" name="search" value="<?php echo $sf_request->getParameter("search"); ?>" <?php if(isset($fixed)) echo 'style="display:none"'; ?>>
			<input type="hidden" name="page" value="1">
		</form>
		<div class="clear"></div>
	</div>
</div>
<?php $i=0; foreach( (isset($pager) ? $pager->getResults("event") : $events) as $event): ?>
<div class="entry-list">
	<div class="block-title">
		<a href="<?php echo $event["url"]; ?>">
			<span><?php echo $event["ville"]; ?></span>
			<h3><?php echo $event["titre"]; ?></h3>
			<h4><?php echo $event["lieu"]; ?></h4>
		</a>
	</div>
	<div class="block-img">
		<?php echo image_tag($event["photo_mini"], array("alt" => __("Photo de l'événement %name", array("%name" => $event["titre"])), "class" => "ill")); ?>
	</div>
	<div class="block-last">
		<div class="description">
			<?php echo ($event["description"] ? $event["description"] : __("Pas de description")); ?>
		</div>
		<div class="guests">
			<div class="open double">
				<div>
					<span><?php echo $event["guests"]->count(); ?></span>
					<?php echo __("Invités"); ?>
				</div>
				<div class="next">
					<span><?php echo $event["participants"]->count(); ?></span>
					<?php echo __("Participants"); ?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="progress pad">
				<span>
					<?php echo __("du %date", array("%date" => format_date($event["start_at"], "f"))); ?>
					<?php if($event["end_at"]) echo "<br>" . __("au %date", array("%date" => format_date($event["end_at"], "f"))); ?>
				</span>
			</div>
		</div>
		<div class="tags">
			<div class="pp">
			<?php foreach($event["Competence"] as $skill): ?>
				<?php echo link_to($skill["nom"], "@directory_act?type=competence&proute=event&slug=".$skill["slug"]); ?> ;
			<?php endforeach; ?>
			<?php if(!$event["Competence"]->count()) echo __("Pas de compétences associées"); ?>
			</div>
		</div>
	</div>

	<div class="clear"></div>
</div>
<?php endforeach; ?>

<?php if(!$total): ?>
	<div class="no-results">
		<?php echo __("Il n'y pas encore d'événements"); ?>
	</div>
<?php endif; ?>

<?php if (isset($pager) && $pager->haveToPaginate()): ?>
<div class="clear"></div>
<div class="pagination bottom">
	<?php include_partial('templates/paginate', array('pager' => $pager)) ?>
	<div class="clear"></div>
</div>
<?php endif ?>