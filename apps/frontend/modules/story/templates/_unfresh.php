<?php /* if($item["type"] == "join"): ?>

				<?php if($item["data"]->count() == 1): $item = $item["data"][0];  ?>
					<?php echo image_tag($item["data"]["photo_mini"], array("class" => "user")); ?>
					<div class="info">
					<?php if($item["data"]["extraData"]["etat"] == "pending"): ?>
						<h3 class="less"><?php echo __("%name a été invité à l'événement", array("%name" => $item["data"]["full_name"])); ?></h3>
					<?php elseif($item["data"]["extraData"]["etat"] == "yes"): ?>
						<h3><?php echo __("%name participera à l'événement", array("%name" => $item["data"]["full_name"])); ?></h3>
					<?php endif; ?>
					<span><?php echo __("le %date", array("%date" => format_date($item["data"]["extraData"]["created_at"]))); ?></span>
				<?php else: ?>
					<?php echo image_tag($item["data"][0]["data"]["photo_mini"], array("class" => "user")); ?>
					<div class="info">
						<h3 class="less"><?php echo __("%first, et %nb personnes ont été invitées", array("%first" => $item["data"][0]["data"]["full_name"], "%nb" => $item["data"]->count())); ?></h3>
						<div class="buddies">
							<?php foreach($item["data"] as $data): ?>
								<?php echo image_tag($data["data"]["photo_mini"], array("class" => "trigger-tipsy", "title" => $data["data"]["full_name"])); ?>
							<?php endforeach; ?>
							<div class="clear"></div>
						</div>
						<span><?php echo __("le %date", array("%date" => format_date($item["data"][0]["data"]["extraData"]["created_at"]))); ?></span>
				<?php endif; ?>
			</div>

		<?php else: */ ?>



<?php echo image_tag($item["photo_mini"], array("class" => "user")); ?>
		<div class="info">
			<?php if($item["extraData"]["type"] == "join"): ?>
				<?php if($item["data"]->count() == 1): ?>
					<?php $item = $item["data"][0]; if($item["data"]["extraData"]["etat"] == "pending"): ?>
						<h3 class="less"><?php echo __("%name a été invité à l'événement", array("%name" => $item["data"]["full_name"])); ?></h3>
					<?php elseif($item["data"]["extraData"]["etat"] == "yes"): ?>
						<h3><?php echo __("%name participera à l'événement", array("%name" => $item["data"]["full_name"])); ?></h3>
					<?php endif; ?>
					<span><?php echo __("le %date", array("%date" => format_date($item["data"]["extraData"]["created_at"]))); ?></span>
				<?php else: ?>
					<?php if($item["data"]["extraData"]["etat"] == "pending"): ?>
						<h3 class="less"><?php echo __("%name a été invité à l'événement", array("%name" => $item["data"]["full_name"])); ?></h3>
					<?php elseif($item["data"]["extraData"]["etat"] == "yes"): ?>
						<h3><?php echo __("%name participera à l'événement", array("%name" => $item["data"]["full_name"])); ?></h3>
					<?php endif; ?>
					<span><?php echo __("le %date", array("%date" => format_date($item["data"]["extraData"]["created_at"]))); ?></span>
				<?php endif; ?>
			<?php /*elseif($item["type"] == "ressource"): ?>
				<?php if($item["data"]["extraData"]["fichier"]): ?>
					<h3><?php echo __("%name a publié le document <u>%doc_name</u>", array("%doc_name" => $item["data"]["extraData"]["nom"], "%name" => $item["data"]["full_name"])); ?></h3>
				<?php else: ?>
					<h3><?php echo __("%name a publié la vidéo <u>%doc_name</u>", array("%doc_name" => $item["data"]["extraData"]["nom"], "%name" => $item["data"]["full_name"])); ?></h3>
				<?php endif; ?>
				<span><?php echo __("le %date", array("%date" => format_date($item["data"]["extraData"]["created_at"]))); ?></span>
			<?php elseif($item["type"] == "idea"): ?>
				<h3><?php echo __("%name a lancé la discussion <u>%idea</u>", array("%idea" => $item["data"]["extraData"]["titre"], "%name" => $item["data"]["full_name"])); ?></h3>
				<span><?php echo __("le %date", array("%date" => format_date($item["data"]["extraData"]["created_at"]))); ?></span>
			<?php  */ endif; ?>