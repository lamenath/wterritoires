<?php if($pictures->count() || $item["ACL"]["write"]): ?>
<div class="block">
	<?php if($item["ACL"]["write"]): ?>
		<a class="live-action btr" data-action="add-photo" data-type="<?php echo $type; ?>" data-to="<?php echo $item["id"]; ?>" href="javascript:;"><?php echo __("ajouter une photo"); ?></a>
	<?php endif; ?>
	<h3><?php echo __("Galerie photo"); ?></h3>
	<?php if($pictures->count()): ?>
	<div data-id="<?php echo $item["id"]; ?>" class="slideshow">
		<?php foreach($pictures as $pic): ?><div class="pic"><a title="<?php echo $pic["nom"]; ?>" class="gal-<?php echo $pic["id"]; ?> mustang-gallery" href='<?php echo $pic["photo_max"]; ?>'><?php echo image_tag($pic["photo_mini"], array("title" => $pic["nom"], "rel" => "shadowbox", "class" => "img_gal")); ?></a></div><?php endforeach; ?>
		<div class="clear"></div>
	</div>
	<?php else: ?>
		<?php echo __("Ce projet ne possède pas encore de photographies."); ?>
	<?php endif; ?>
</div>
<script type="text/javascript">
Shadowbox.init({
	    handleOversize: "drag",
	    modal: true,
	    overlayOpacity: 0.7
	}, function(){
        Shadowbox.setup("a.mustang-gallery", {
        gallery:        "mustang",
        continuous:     false,
        counterType:    "skip"
       }
    );
});
</script>
<?php endif; ?>