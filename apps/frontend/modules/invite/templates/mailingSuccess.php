<div class="content-popin">
	<div class="generic">
		<h2 class="for"><?php echo __("Envoyer un email aux membres de \"%name\"", array("%name" => $name)); ?></h2>
		<form action="<?php echo url_for("invite/mailing"); ?>" method="post" class="ajaxForm">

			<?php if($contacts->count()): ?>
				<div class="pool-operate">
					<a class="all"><?php echo __("Sélectionner tous"); ?></a> |
					<a class="none"><?php echo __("Sélectionner aucun"); ?></a>
				</div>
				<h3 class="boost"><?php echo __("Choisissez les membres à contacter :"); ?></h3>
				<div class="clear"></div>
				<div class="boost pool-select">
				<?php foreach($contacts as $contact): ?>
					<label class="buddy">
						<?php echo image_tag($contact["photo_mini"]); ?>
						<span><?php echo $contact["full_name"]; ?></span>
						<input type="checkbox" name="pool_friends[]" value="<?php echo $contact["id"]; ?>">
					</label>
				<?php endforeach; ?>
				<div class="clear"></div>
				</div>
			<?php endif; ?>

			<div class="pool-email">
				<h3><?php echo __("Ecrivez votre message ici :"); ?></h3>
				<textarea id="message" class="boost form-message big-message" name="message"></textarea>
				<div class="clear"></div>
			</div>

			<input type="hidden" name="pid" value="<?php echo $sf_request->getParameter("pid"); ?>">
			<input type="hidden" name="eid" value="<?php echo $sf_request->getParameter("eid"); ?>">

			<div id="troubleshoot"> </div>

			<div id="form-buttons" class="light center">
				<input type="submit" value="<?php echo __("Envoyer le message"); ?>" class="button" id="bt_confirm">
				<button class="popin-close gray" onclick="return false;" id="bt_cancel" ><?php echo __("Annuler"); ?></button>
			</div>
		</form>
	</div>
	<script language="javascript"> $(".pool-select").jScrollPane(); </script>
</div>
