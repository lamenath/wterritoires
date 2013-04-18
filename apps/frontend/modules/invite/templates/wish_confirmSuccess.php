<div class="content-popin">
	<div class="generic">
		<form action="<?php echo url_for("json/wish_confirm"); ?>" method="post" class="ajaxForm">
			<div class="contacts">
				<input type="hidden" value="<?php echo $sf_request->getParameter("wid"); ?>" name="wid">
				<input type="hidden" id="choice" value="1" name="choice">

				<h2 class="up"><?php
					echo __("Accepter cette demande de rejoindre votre groupe de travail ?")
				?></h2>
			</div>
			<div class="clear"></div>
			<div id="form-buttons" class="center">
				<button onclick="$('#choice').attr('value', '0');" id="bt_confirm"><?php echo __("Confirmer"); ?></button>
				<button class="gray" onclick="$('#choice').attr('value', '1');" id="bt_confirm" ><?php echo __("Ignorer"); ?></button>
				<button class="popin-close gray" onclick="return false;" id="bt_cancel" ><?php echo __("Décider plus tard"); ?></button>
			</div>
		</form>
	</div>
</div>