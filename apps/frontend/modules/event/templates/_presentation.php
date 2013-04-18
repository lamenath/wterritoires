<div class="common-feed">
	<div class="padded">
		<div class="table-presentation">

			<div class="tab">
				<div class="label">
					<?php echo __("Date de début"); ?>
				</div>
				<div class="label-right">
					<?php if($event["start_at"]) echo format_date($event["start_at"], "U"); ?>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="tab">
				<div class="label">
					<?php echo __("Date de fin"); ?>
				</div>
				<div class="label-right">
					<?php if($event["end_at"]) echo format_date($event["end_at"], "U"); else echo __("Date non déterminée"); ?>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="tab">
				<div class="label">
					<?php echo __("Lieu de l'événement"); ?>
				</div>
				<div class="label-right">
					<b><?php echo $event["lieu"]; ?></b> <br/>
					<?php echo $event["adresse"]; ?> <br/>
					<?php echo $event["ville"]; ?> <br/>
					<a target="_blank" href="http://maps.google.fr/maps?gcx=c&q=<?php echo $event["latitude"]; ?>,<?php echo $event["longitude"]; ?>&um=1&ie=UTF-8&hl=fr&sa=N&tab=wl"><?php echo __("voir sur une carte"); ?></a>
				</div>
				<div class="clear"></div>
			</div>

		</div>
	</div>
</div>