<div class="content-popin">
	<div class="generic">
	<h2 class="for"><?php echo __("Ils ont voté pour (%nb)", array("%nb" => $votes->count())); ?></h2>

	<div class="list-voted">
		<?php foreach($votes as $vote): ?>
		<a href="<?php echo $vote["url"]; ?>">
			<div class="buddy">
				<?php echo image_tag($vote["photo_mini"]); ?>
				<p>
					<b><?php echo $vote["full_name"] ?></b>
					<?php echo ucfirst($vote["ville"]); ?>
				</p>
				<div class="clear"></div>
			</div>
		</a>
		<?php endforeach; ?>
		<div class="clear"></div>
	</div>

<?php if($votes->count() == 0): ?>
Personne
<?php endif; ?>

<div class="clear"></div>
<div id="form-buttons" class="light center">
	<button class="popin-close gray" onclick="return false;" id="bt_cancel" ><?php echo __("Fermer"); ?></button>
</div>