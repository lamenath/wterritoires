<?php if($tests->count()): ?>
	<?php if(!$sf_request->getCookie("hide_reminder")): ?>
	<div class="hoody reminder">
		<div class="close">
			<a href="javascript:;" onclick="$.cookie('hide_reminder', true, 60*60*24*7); $(this).parent().parent().remove()"><img src="/images/new/mini-close.png"><b><?php echo __("fermer"); ?></b></a>
		</div>
		<h2><?php echo __("Rappel : enrichissez votre profil et accélérez les connexions"); ?></h2>
		
		<ul class="suggestion">
		<?php foreach($tests as $t): ?>
			<li><a href='<?php echo $t[1]; ?>'><?php echo html_entity_decode($t[2]); ?></a></li>
		<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>
<?php endif; ?>