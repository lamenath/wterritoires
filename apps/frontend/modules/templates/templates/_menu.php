<ul class="menu<?php if($mini === true) echo " mini"; ?>">
	<?php foreach($tree as $action => $data): ?>
	<a href="<?php echo $data["url"] ?>">
		<li <?php if(sfContext::getInstance()->getRequest()->getParameter("proute") == $action || (!$use_proute && sfContext::getInstance()->getRequest()->getParameter("action") == $action)) echo 'class="active"'; ?>>
			<?php echo image_tag("new/btn_tab_shadow.png"); ?>
			<?php echo __($data["title"]); ?>
		</li>
	</a>
	<?php endforeach; ?>
</ul>