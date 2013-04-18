<div class="hoody">
</div>
<?php echo image_tag("new/shadow_940_bottom.png"); ?>
<ul class="switcher">
	<?php foreach($home as $line): ?>
	<li>
		<?php echo $line["titre_lien"]; ?>
		<div class="content-hoody">
			<?php echo image_tag("/uploads/home/".$line["photo"], array("class"=>"contribute")); ?>
			<div class="close">
				<a href="#">
					<?php echo image_tag("new/mini-close.png"); ?>
					<?php echo __("<b>fermer</b> la présentation"); ?>
				</a>
			</div>
			<div class="text">
				<h2><?php echo $line["titre"]; ?></h2>
				<h3><?php echo nl2br($line["text"]); ?></h3>
			</div>
		</div>
	</li>
	<?php endforeach; ?>
</ul>

<div class="clear"></div>