<div class="padded">
	<?php foreach($stories as $item): ?>
	<div class="entry">
		<a href="<?php echo ($item["extraData"]["url"] !== null ? $item["extraData"]["url"] : "javascript:;"); ?>">
			<?php echo image_tag($item["photo_mini"], array("alt" => __("Illustration"), "class" => "big user")); ?>
			<div class="info big">
				<?php if(isset($item["extraData"]["in"])): ?>
					<h4><?php echo $item["extraData"]["in"]; ?></h4>
				<?php endif; ?>
				<?php echo include_partial("story/".$item["extraData"]["type"], array("full" => true, "params" => unserialize(html_entity_decode($item["extraData"]["params"])), "item" => $item)); ?>
				<span><?php echo __("le %date", array("%date" => format_date($item["extraData"]["updated_at"], "f"))); ?></span>
			</div>
		</a>
		<div class="clear"></div>
	</div>
	<?php endforeach; ?>
</div>
<?php if($stories->count() == 0): ?>
<div class="no-results">
	<?php echo __("Votre flux d'activité est encore vide..."); ?>
</div>
<?php endif; ?>
<script type="text/javascript">
Shadowbox.init({
	    handleOversize: "drag",
	    modal: true,
	    overlayOpacity: 0.7
	}, function(){
        Shadowbox.setup("a.mustang-gallery-home", {
        gallery:        "mustang",
        continuous:     false,
        counterType:    "skip"
       }
    );
});
</script>