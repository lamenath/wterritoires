<div class="head">
	<?php $count=($profiles ? $profiles->count() : $pager->getNbResults()); echo ($count > 1 ? __("<b>%nb</b> participants", array("%nb" => $count)) : __("<b>%nb</b> participant", array("%nb" => $count))); ?>
	<div class="menu-feed">
		<div class="clear"></div>
	</div>
</div>
<?php $i=0; foreach( (isset($pager) ? $pager->getResults("profile") : $profiles) as $profile): ?>
<div class="entry-list">
	<div class="block-title">
		<a href="<?php echo $profile["url"] ?>">
			<span><?php echo $profile["ville"]; ?></span>
			<h3><?php echo $profile["full_name"]; ?></h3>
		</a>
	</div>
	<div class="block-img">
		<a href="<?php echo $profile["url"] ?>">
			<?php echo image_tag($profile["photo_mini"], array("alt" => __("Photo de %name", array("%name" => $profile["full_name"])), "class" => "ill")); ?>
		</a>
	</div>
	<div class="block-last">
		<div class="description">
			<?php echo $profile["presentation"]; ?>
		</div>
		<div class="tags">
			<div class="pp">
			<?php foreach($profile["ProfilCompetence"] as $skill): ?>
				<?php echo link_to($skill["Competence"]["nom"], "@directory_act?type=competence&proute=user&slug=".$skill["Competence"]["slug"]); ?>
			<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="clear"></div>
</div>
<?php endforeach; ?>
<?php if (isset($pager) && $pager->haveToPaginate()): ?>
<div class="clear"></div>
<div class="pagination bottom">
	<?php include_partial('templates/paginate', array('pager' => $pager)) ?>
	<div class="clear"></div>
</div>
<?php endif ?>