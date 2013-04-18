<div class="head">
	<?php echo ($sf_request->getParameter("search") ? __("%c membres correspondant à \"%term\"", array("%term" => $sf_request->getParameter("search"), "%c" => $total)) : __("%c membres", array("%c" => $total))); ?>
	<div class="menu-feed">
		<form action="<?php echo $sf_request->getPathInfo(); ?>" method="get">
			<input placeholder="<?php echo __("Chercher un membre"); ?>" type="text" class="search" name="search" value="<?php echo $sf_request->getParameter("search"); ?>" <?php if(isset($fixed)) echo 'style="display:none"'; ?>>
			<input type="hidden" name="page" value="1">
		</form>
		<div class="clear"></div>
	</div>
</div>
<?php $i=0; foreach( (isset($pager) ? $pager->getResults("profile_light") : $profiles) as $profile): ?>
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
			<?php foreach($profile["Competence"] as $skill): ?>
				<?php echo link_to($skill["nom"], "@directory_act?type=competence&proute=user&slug=".$skill["slug"]); ?>
			<?php endforeach; ?>
			<?php if(!$profile["Competence"]->count()) echo __("Pas de compétences indiquées"); ?>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<?php endforeach; ?>

<?php if(!$total): ?>
	<div class="no-results">
		<?php echo __("Pas de membres correspondant à votre recherche"); ?>
	</div>
<?php endif; ?>

<?php if (isset($pager) && $pager->haveToPaginate()): ?>
<div class="clear"></div>
<div class="pagination bottom">
	<?php include_partial('templates/paginate', array('pager' => $pager)) ?>
	<div class="clear"></div>
</div>
<?php endif ?>