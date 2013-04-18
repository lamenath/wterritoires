<div class="common-feed contacts-corrector">
	<div class="head">
		<?php echo  __("%c contact(s)", array("%c" => $total)); ?>
		<div class="menu-feed">
			<a href="<?php echo url_for("@structure2v?slug=".$sf_request->getParameter("slug")); ?>"><?php echo __("Créer un contact"); ?></a>
			<div class="clear"></div>
		</div>
	</div>
	
	<div class="padded">
		<?php foreach($pager->getResults() as $item): ?>
		<div id="contact_<?php echo $item["id"]; ?>" class="entry">
			<div class="s-buttons">
				<a class="button" href="<?php echo url_for("@structure2v?slug=".$item["Structure"]["slug"]); ?>?id=<?php echo $item["id"]; ?>"><span><?php echo __("Editer"); ?></span></a>
			</div>
			<?php echo image_tag("/uploads/profil/default.png", array("alt" => __("Photo de profil de %name", array("%name" => $item["nom"])), "class" => "user")); ?>
			<div class="info">
				<h3><?php echo $item["prenom"]; ?> <?php echo $item["nom"]; ?></h3>
				<span><?php echo $item["fonction"]; ?></span>
			</div>
			<div class="clear"></div>
		</div>
		<?php endforeach; ?>
		<?php if(!$total): ?>
		<div class="no-results">
			<?php echo __("Pas de contacts correspondant à votre recherche"); ?>
		</div>
		<?php endif; ?>
	</div>
	
	<?php if (isset($pager) && $pager->haveToPaginate()): ?>
	<div class="clear"></div>
	<div class="pagination bottom">
		<?php include_partial('templates/paginate', array('pager' => $pager)) ?>
		<div class="clear"></div>
	</div>
	<?php endif ?>
</div>