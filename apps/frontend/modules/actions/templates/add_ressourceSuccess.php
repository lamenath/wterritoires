<?php if(!$sf_request->isXmlHttpRequest()) echo "<div id='content'>"; ?>

<h2><?php if($sf_request->getParameter("rid")) echo __("Modifier une ressource");  else echo __("Ajouter un document au projet '%1%'", array('%1%' => $projet)); ?></h2>

<br>

<form action="<?php echo url_for("actions/add_ressource?pid=".$sf_request->getParameter("pid")); ?>" onsubmit="<?php echo "$('input, button', '#form-buttons').each(function(){ \$(this).attr('disabled', 'disabled'); }); $('#form').hide(); $('#loading').show()"; ?>" method="post" enctype="multipart/form-data">

	<?php if($form->hasErrors()): ?>
	<div class="super_error">
		<?php echo image_tag("error.png"); ?> <?php echo __("Le formulaire contient des erreurs, veuillez vérifier !"); ?>
	</div>
	<div class="clear"> </div>
	<?php endif; ?>

	<?php if(!$sf_request->isXmlHttpRequest()) echo "<div class='table'>"; ?>

	<div id="loading" style="display:none">
		<?php echo image_tag("spinner.gif"); ?>
		<?php if($sf_request->getParameter("rid")): ?>
			modification en cours...
		<?php else: ?>
			téléchargement en cours...
		<?php endif; ?>
	</div>

	<div id="form">
		<div class="block2">
			<div class="libelle">
				<?php echo __("Fichier *"); ?> <?php if($sf_request->getParameter("rid")) echo "(facultatif)"; ?> <br>
				.pdf, .ppt, .xls ou .doc
			</div>
			<div class="input">
				<?php echo $form["fichier"]->render(array("size" => 10)); ?>
				<?php if($sf_request->isMethod('post') || $sf_request->isMethod('put')) echo $form["fichier"]->getError() || (!$sf_request->isMethod('put') && !$sf_request->isMethod('post')) ? image_tag("error.png") . '<p class="error">' . $form["fichier"]->getError() . '</p>' : image_tag("okay.png") ?>
			</div>
			<div class="clear"> </div>
		</div>
		<div class="block2">
			<div class="libelle">
				<?php echo __("Titre du document *"); ?>
			</div>
			<div class="input">
				<?php echo $form["nom"]->render(); ?>
				<?php if($sf_request->isMethod('post') || $sf_request->isMethod('put')) echo $form["nom"]->getError() || (!$sf_request->isMethod('put') && !$sf_request->isMethod('post')) ? image_tag("error.png") . '<p class="error">' . $form["nom"]->getError() . '</p>' : image_tag("okay.png") ?>
			</div>
			<div class="clear"> </div>
		</div>
		<div class="block2">
			<div class="libelle">
				<?php echo __("Source du document"); ?>
			</div>
			<div class="input">
				<?php echo $form["source"]->render(); ?>
				<?php if($sf_request->isMethod('post') || $sf_request->isMethod('put')) echo $form["source"]->getError() || (!$sf_request->isMethod('put') && !$sf_request->isMethod('post')) ? image_tag("error.png") . '<p class="error">' . $form["source"]->getError() . '</p>' : image_tag("okay.png") ?>
			</div>
			<div class="clear"> </div>
		</div>
		<?php echo $form->renderHiddenFields(); ?>

		<?php if($sf_request->getParameter("rid")): ?>
		<input type="hidden" name="rid" value="<?php echo $sf_request->getParameter("rid") ?>">
		<?php endif; ?>
	</div>

	<div class="clear"> </div>

	<div id="troubleshoot"> </div>

	<br>

	<div id="form-buttons">
		<?php if($sf_request->getParameter("rid")): ?>
		<button id="bt_confirm"><?php echo __("Modifier"); ?></button>
		<?php else: ?>
		<button id="bt_confirm"><?php echo __("Télécharger"); ?></button>
		<?php endif; ?>
		<button class="popin-close gray" onclick="window.open('<?php echo url_for('@projet?page=ressource&slug='.$projet->get('slug')); ?>', '_parent'); return false;" id="bt_cancel"><?php echo __("Annuler"); ?></button>
	</div>

	<script language="javascript"> $('.popin').focus() </script>
	<?php if(!$sf_request->isXmlHttpRequest()) echo "</div>"; ?>

</form>
<?php if(!$sf_request->isXmlHttpRequest()) echo "</div>"; ?>