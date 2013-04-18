<div class="content-popin">
	<?php echo image_tag($event["photo_mini"]); ?>
	<div class="generic">
		<form action="<?php echo url_for("json/join_event"); ?>" method="post" class="ajaxForm">

			<div class="contacts">

				<input type="hidden" name="eid" value="<?php echo $sf_request->getParameter("eid"); ?>">
				<input type="hidden" name="direction" value="<?php echo $sf_request->getParameter("direction"); ?>">

				<?php if($sf_request->getParameter("direction") == "join"): ?>
					<h2><?php echo  __("Répondre présent à l'événement %name ?", array("%name" => $event["titre"])); ?></h2>
				<?php elseif($sf_request->getParameter("direction") == "erase"): ?>
					<h2><?php echo  __("Quitter définitivement %name ?", array("%name" => $event["titre"])); ?></h2>
				<?php else: ?>
					<h2><?php echo  __("Répondre absent à l'événement %name ?", array("%name" =>  $event["titre"])); ?></h2>
				<?php endif; ?>

			</div>

			<div class="clear"></div>

			<div id="troubleshoot"> </div>
			<div id="form-buttons" class="">
				<input type="submit" class="button" value="<?php echo __("Répondre"); ?>" id="bt_confirm">
				<button class="popin-close gray" onclick="return false;" id="bt_cancel" ><?php echo __("Annuler"); ?></button>
			</div>
		</form>
	</div>
</div>