<div class="common-feed contacts-corrector">
	<div class="padded">
		<?php if(!isset($public)): ?>
		<div style="float:right">
			<a class="button" href="/json/tendance?type=Filiere&format=csv&sortname=nom"><span><?php echo __("Export Filières"); ?></span></a>
			<a class="button" href="/json/tendance?type=Competence&format=csv&sortname=nom"><span><?php echo __("Export Compétences"); ?></span></a>
			<a class="button" href="/json/tendance?type=Theme&format=csv&sortname=nom"><span><?php echo __("Export Thèmes"); ?></span></a>
			<a class="button" href="/json/tendance?type=Metier&format=csv&sortname=nom"><span><?php echo __("Export Métiers"); ?></span></a>
		</div>
		
		<a class="button" href="?type=Filiere"><span><?php echo __("Filières"); ?></span></a>
		<a class="button" href="?type=Competence"><span><?php echo __("Compétences"); ?></span></a>
		<a class="button" href="?type=Theme"><span><?php echo __("Thèmes"); ?></span></a>
		<a class="button" href="?type=Metier"><span><?php echo __("Métiers"); ?></span></a>
		<br/><br/><br/>
		<div class="clear"></div>
		<?php endif; ?>
		<table class="flexme3" style="display: none"></table>
	</div>
</div>

<script type="text/javascript">
	$(".flexme3").flexigrid({
		url : '/json/tendance?type=<?php echo ( $sf_request->getParameter("type") ? $sf_request->getParameter("type") : "Filiere"); ?>',
		dataType : 'json',
		colModel : [ {
			display : 'Mot clé',
			name : 'nom',
			width : 300,
			sortable : true,
			align : 'left'
		}, {
			display : 'Membres',
			name : 'user',
			width : 100,
			sortable : true,
			align : 'center'
		}, {
			display : 'Structures',
			name : 'structure',
			width : 100,
			sortable : true,
			align : 'center'
		}, {
			display : 'Projets',
			name : 'project',
			width : 100,
			sortable : true,
			align : 'center'
		}, {
			display : 'Evénements',
			name : 'event',
			width : 100,
			sortable : true,
			align : 'center'
		},
		{
			display : 'Ressources',
			name : 'ressource',
			width : 100,
			sortable : true,
			align : 'center'
		} ],
		buttons : [ ],
		searchitems : [ {
			display : 'ISO',
			name : 'iso'
		}, {
			display : 'Name',
			name : 'name',
			isdefault : true
		} ],
		sortname : "nom",
		sortorder : "ASC",
		<?php if($sf_request->getParameter("type")): ?>title : '<?php echo $sf_request->getParameter("type"); ?> - <?php echo __("Tendances"); ?>',<?php endif; ?>
		width : 927,
		height : 380
	});
</script>