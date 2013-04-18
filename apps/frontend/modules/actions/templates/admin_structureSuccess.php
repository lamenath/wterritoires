<div class="content-popin">
	<?php echo image_tag($profil["photo_mini"]); ?>
	<div class="generic">
		<form action="<?php echo url_for("json/admin_structure"); ?>" method="post" class="ajaxForm">
			<div class="contacts">
				<input type="hidden" value="<?php echo $sf_request->getParameter("uid"); ?>" name="uid">
				<input type="hidden" value="<?php echo $sf_request->getParameter("pid"); ?>" name="pid">
				<input type="hidden" value="<?php echo $sf_request->getParameter("direction"); ?>" name="direction">

				<h2 class="up"><?php

					if($sf_request->getParameter("direction") == "kick")
						echo __("Exclure %1% de la structure %project?", array("%project" => $project["nom"], "%1%" => $profil["full_name"]) );
					elseif($sf_request->getParameter("direction") == "referent")
						echo __("Souhaitez-vous vraiment nommer %1% comme référent de la structure %project?", array("%project" => $project["nom"], "%1%" => $profil["full_name"]) );
					elseif($sf_request->getParameter("direction") == "notreferent")
						echo __("Souhaitez-vous réellement retirer le rôle de référent à %1% ?", array("%1%" => $profil["full_name"]) );

				?></h2>
			</div>
			<div class="clear"></div>
			<div id="form-buttons" class="center">
				<button id="bt_confirm"><?php echo __("Confirmer"); ?></button>
				<button class="popin-close gray" onclick="return false;" id="bt_cancel" ><?php echo __("Annuler"); ?></button>
			</div>
		</form>
	</div>
</div>