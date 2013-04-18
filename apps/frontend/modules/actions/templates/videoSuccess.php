<div class="content-popin">
	<div class="generic">
		<h2 class="for"><?php echo __("Lire la vidéo"); ?></h2>

		<iframe class="boxy-remove" width="500" height="315" src="http://www.youtube.com/embed/<?php echo $sf_request->getParameter("id"); ?>?autoplay=1" frameborder="0" allowfullscreen></iframe>

		<div id="troubleshoot"> </div>
		<div id="form-buttons" class="">
			<button class="popin-close gray" onclick="return false;" id="bt_cancel" ><?php echo __("Fermer"); ?></button>
		</div>
	</div>
</div>
