<div class="content-popin">
	<div class="generic">
		<h2 class="for"><?php echo __("Inviter à rejoindre \"%name\"", array("%name" => $name)); ?></h2>
		<form action="<?php echo url_for("invite/index"); ?>" method="post" class="ajaxForm">

			<?php if($contacts->count()): ?>
				<div class="pool-operate">
					<a class="all"><?php echo __("Sélectionner tous"); ?></a> |
					<a class="none"><?php echo __("Sélectionner aucun"); ?></a>
				</div>
				<h3><?php echo __("Choisissez des contacts à inviter :"); ?></h3>
				<div class="clear"></div>
				<div class="pool-select">
				<?php foreach($contacts as $contact): ?>
					<label class="buddy<?php if($controller->isInvited($contact["id"], $sf_request)) echo " disabled"; ?>">
						<?php echo image_tag($contact["photo_mini"]); ?>
						<span><?php echo $contact["full_name"]; ?></span>
						<input type="checkbox" name="pool_friends[]" value="<?php echo $contact["id"]; ?>">
					</label>
				<?php endforeach; ?>
				<div class="clear"></div>
				</div>
			<?php endif; ?>

			<div class="pool-email">
				<h3><?php echo __("Inviter des connaissances extérieures (facultatif) :"); ?></h3>
				<h4><?php echo __("Entrez un email par ligne"); ?></h4>
				<textarea id="pooled_emails" name="pooled_emails"></textarea>
				<div class="clear"></div>
			</div>

			<div class="pool-email">
				<h3><?php echo __("Ajoutez un message personnel (facultatif) :"); ?></h3>
				<textarea id="message" name="message"></textarea>
				<div class="clear"></div>
			</div>

			<input type="hidden" name="pid" value="<?php echo $sf_request->getParameter("pid"); ?>">
			<input type="hidden" name="eid" value="<?php echo $sf_request->getParameter("eid"); ?>">
			<input type="hidden" name="gid" value="<?php echo $sf_request->getParameter("gid"); ?>">

			<div id="troubleshoot"> </div>

			<div id="form-buttons" class="light center">
				<input type="submit" value="<?php echo __("Inviter"); ?>" class="button" id="bt_confirm">
				<button class="popin-close gray" onclick="return false;" id="bt_cancel" ><?php echo __("Annuler"); ?></button>
			</div>
		</form>
	</div>
	<script language="javascript"> $(".pool-select").jScrollPane(); </script>
</div>
