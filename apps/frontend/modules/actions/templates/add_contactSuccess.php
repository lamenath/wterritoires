<div class="content-popin">
	<?php echo image_tag($profil["photo_mini"]); ?>
	<div class="generic">
		<form action="<?php echo url_for("json/add_contact"); ?>" method="post" class="ajaxForm">
			<div class="contacts">
				<input type="hidden" value="<?php echo $sf_request->getParameter("uid"); ?>" name="uid">
				<input type="hidden" value="<?php echo $sf_request->getParameter("direction"); ?>" name="direction">
				<input type="hidden" value="<?php echo $sf_request->getParameter("rmv"); ?>" name="rmv">
				<input type="hidden" id="frequest_choice" value="1" name="frequest_choice">

				<h2 class="up"><?php

					if($sf_request->getParameter("direction") == "add")
						echo __("Voulez-vous entrer en contact avec %1%?", array("%1%" => $profil["full_name"]) );
					elseif($sf_request->getParameter("direction") == "remove")
						echo __("Souhaitez-vous vraiment supprimer %1% de vos contacts?", array("%1%" => $profil["full_name"]) );
					elseif($sf_request->getParameter("direction") == "confirm")
						echo __("%1% vous propose d'entrer en contact. Vous pouvez confirmer ou ignorer ci-dessous.", array("%1%" => $profil["full_name"]) );

				?></h2>
			</div>
			<div class="clear"></div>
			<div id="form-buttons" class="center">
				<button onclick="$('#frequest_choice').attr('value', '1');" id="bt_confirm"><?php echo __("Confirmer"); ?></button>
				<?php if($sf_request->getParameter("direction") != "confirm"): ?>
				<button class="popin-close gray" onclick="return false;" id="bt_cancel" ><?php echo __("Annuler"); ?></button>
				<?php else: ?>
				<button class="gray" onclick="$('#frequest_choice').attr('value', '-1');" id="bt_confirm" ><?php echo __("Ignorer"); ?></button>
				<button class="popin-close gray" onclick="return false;" id="bt_cancel" ><?php echo __("Décider plus tard"); ?></button>
				<?php endif; ?>
			</div>
		</form>
	</div>
</div>