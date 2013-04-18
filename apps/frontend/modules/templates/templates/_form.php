<div class="big-notice" <?php echo ($sf_request->isMethod("post") && ($form->hasErrors() || $form->hasGlobalErrors()) ? "style='display: block !important;'" : ""); ?>>
	<h1><?php echo __("Le formulaire et incomplet !"); ?></h1>
	<h2><?php echo __("Certains champs sont obligatoires ou incorrects, ils sont marqués en rouge."); ?></h2>
	<div class="clear"></div>
</div>
<?php if($sf_request->isMethod("post") && $form->hasGlobalErrors()): ?>
<ul class="big-errors">
	<?php foreach($form->getGlobalErrors() as $error): ?>
		<li>- <?php echo $error->__toString(); ?></li>
	<?php endforeach; ?>
<?php endif; ?>
</ul>
<div class="table">
	<?php foreach ($form as $widget): ?>
	<?php if (!$widget->isHidden()) { ?>
	<div class="block">

		<div class="input form-<?php echo $widget->renderId(); ?>" <?php if($widget->getWidget() instanceOf sfWidgetFormInputFileEditable && $widget->getWidget()->getOption("edit_mode") == true) echo "style='display:none'"; ?>>
			<?php echo $widget->render() ?>
			<?php if($widget->hasError()) echo $widget->renderError(); ?>
		</div>

		<?php if($widget->getWidget() instanceOf sfWidgetFormInputFileEditable && $widget->getWidget()->getOption("edit_mode") == true): ?>
		<div class="input show-before">
			<label class="padme"><input type="checkbox" class="standard" checked="checked"><?php echo __("Garder le fichier actuel"); ?></label>
		</div>
		<?php endif; ?>

		<?php if($widget->getWidget() instanceOf sfWidgetFormInputFileEditable): ?>
		<div class="clear"></div>
		<div class="input">
			<div class="clear"></div>
			<hr size=1 noshade>
			<?php echo __("La redimension est automatique. <br><i>Choisissez si possible une grande image, de bonne qualité.</i>"); ?>
		</div>
		<?php endif; ?>

		<div class="label">
			<?php echo $widget->renderLabel(); ?>
			<p class="hint">
				<?php echo $widget->renderHelp(); ?>
			</p>
		</div>
		<div class="clear"></div>
	</div>
	<?php } ?>
	<?php endforeach; ?>
</div>
<?php echo $form->renderHiddenFields(); ?>