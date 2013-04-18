<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php include_title() ?>
<head>
<!-- Official Theme-->
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_javascripts() ?>
<?php include_stylesheets() ?>
</head>
<body class="page-<?php echo $sf_request->getParameter("module"); ?>">
	<?php if(sfContext::getInstance()->getRequest()->hasParameter("update") || sfContext::getInstance()->getRequest()->hasParameter("edit")): ?>
	<script language="javascript">
		$.humanize("<?php echo __("Les modifications apportées sont bien enregistrées !"); ?>");
	</script>
	<?php endif; ?>
	<?php if(sfContext::getInstance()->getRequest()->hasParameter("removed")): ?>
	<script language="javascript">
		$.humanize("<?php echo __("La suppression a été effectuée !"); ?>");
	</script>
	<?php endif; ?>
	<div class="loading-overlay">
		<?php echo __("chargement.."); ?>
	</div>
	<iframe name="downloadable" id="downloadable" style="display:none"></iframe>
	<div class="header" alt="<?php echo sfConfig::get("app_title_page"); ?>">
		<a alt="<?php echo __("Page d'accueil"); ?>" href="<?php echo url_for("@homepage"); ?>">
			<div class="image">
				<?php if($sf_user->isAuthenticated() && $sf_user->getObject()->get("is_admin")): ?>
				<div class="admin">
					<?php echo __("Pleins droits (Administrateur)"); ?>
				</div>
				<?php endif; ?>
				<div class="financeurs">
					<div class="imgs">
						<?php echo image_tag("new/engage.png"); ?>
						<?php echo image_tag("new/bmp_logo_unioneurop.png"); ?>
						<?php echo image_tag("new/bmp_logo_repfrancaise.png"); ?>
						<?php echo image_tag("new/bmp_logo_picardie.png"); ?>
					</div>
				</div>
				<?php echo image_tag("new/bmp_logo_rrp.png", array("alt" => __("Logo " . sfConfig::get("app_title_page") ), "class" => "logo")); ?>
			</div>
		</a>
	</div>
	<div class="first">
		<div class="inner">
			<?php if($sf_user->isLogged()): ?>
			<ul class="menu<?php if($sf_user->getObject()->get("is_admin")) echo " admin"; ?>">
				<a alt="<?php echo __("Page d'accueil"); ?>" href="<?php echo url_for("@homepage"); ?>">
					<li alt="<?php echo __("Page d'accueil"); ?>" class="home log"><?php echo image_tag("new/ico_16_home.png", array("alt" => __("Page d'accueil"))); ?></li>
				</a>
				<?php if($sf_user->getObject()->get("is_admin")):?>
				<a alt="<?php echo __("Dashboard Animateur"); ?>" href="<?php echo url_for("dashboard/index"); ?>">
					<li alt="<?php echo __("Dashboard Animateur"); ?>" title="<?php echo __("Dashboard Animateur"); ?>" class="home trigger-tipsy dash"><?php echo image_tag("new/ico_16_superadmin.png", array("alt" => __("Dashboard Animateur"))); ?></li>
				</a>
				<?php endif; ?>
				<li class="left name_of">
					<div class="sub">
						<a href="<?php echo url_for("profile/index?slug=".$sf_user->getObject()->getLogin()); ?>">
							<p><?php echo __("Voir/éditer mon profil"); ?></p>
						</a>
						<a href="<?php echo url_for("actions/logout"); ?>">
							<p><?php echo __("Fermer la session"); ?></p>
						</a>
					</div>
					<a href="<?php echo url_for("profile/index?slug=".$sf_user->getObject()->getLogin()); ?>">
					<p>
						<?php echo $sf_user->getObject()->getPrenom(); ?>
						<br/>
						<b><?php echo $sf_user->getObject()->getNom(); ?></b>
					</p>
					</a>
				</li>
				<li class="left full">
					<div class="big jspScrollable sub">
						<div class="container">
							<?php foreach(Doctrine_Query::create()->from("Filiere")->execute() as $fil): ?>
							<a href="<?php echo url_for("@directory?type=filiere&slug=".$fil->getSlug()); ?>">
								<p><?php echo $fil; ?></p>
							</a>
							<?php endforeach; ?>
						</div>
					</div>
					<a href="<?php echo url_for("@directory_index?type=filiere"); ?>">
					<div class="b">
						<?php echo __("Filières"); ?>
						<?php if($count = $sf_user->getNewMessagesCount()): ?>
							(<?php echo $count; ?>)
						<?php endif; ?>
					</div>
					</a>
				</li>
				<a href="<?php echo url_for("@projects"); ?>">
					<li class="left full">
						<div class="b"><?php echo __("Projets"); ?></div>
					</li>
				</a>
				<a href="<?php echo url_for("@event_page?proute=all"); ?>">
					<li class="left full">
						<div class="b"><?php echo __("Événements"); ?></div>
					</li>
				</a>
				<a href="<?php echo url_for("@inbox"); ?>">
					<li class="left full">
						<div class="b">
							<?php echo __("Messages"); ?>
							<?php if($count = $sf_user->getNewMessagesCount()): ?>
								(<?php echo $count; ?>)
							<?php endif; ?>
						</div>
					</li>
				</a>
				<li class="search">
					<form action="<?php echo url_for("@search"); ?>" method="get">
						<input placeholder="<?php echo __("Effectuer une recherche"); ?>" type="text" name="search">
						<input type="hidden" name="page" value="1">
					</form>
				</li>
				<!--<a href="<?php echo url_for("actions/logout"); ?>">
					<li class="right close-session">
						<p><?php echo __("Fermer la session"); ?></p>
					</li>
				</a>-->
			</ul>
			<?php else: ?>
			<ul class="menu">
				<a href="<?php echo url_for("@homepage"); ?>">
					<li class="home"><?php echo image_tag("new/ico_16_home.png"); ?></li>
				</a>
				<a href="<?php echo url_for("search/members"); ?>">
					<li class="count left">
						<span><?php echo RRR::getTotalMembers(); ?></span>
						<div class="b"><?php echo __("Acteurs"); ?></div>
					</li>
				</a>
				<a href="<?php echo url_for("search/project"); ?>">
					<li class="count left">
						<span><?php echo RRR::getTotalProjects(); ?></span>
						<div class="b"><?php echo __("Projets"); ?></div>
					</li>
				</a>
				<a href="<?php echo url_for("search/event"); ?>">
					<li class="count left">
						<span><?php echo RRR::getTotalEvents(); ?></span>
						<div class="b"><?php echo __("Événements"); ?></div>
					</li>
				</a>
				<a href="<?php echo url_for("search/ressources"); ?>">
					<li class="count left">
						<span><?php echo RRR::getTotalDocs(); ?></span>
						<div class="b"><?php echo __("Documents"); ?></div>
					</li>
				</a>
				<li class="search">
					<form action="<?php echo url_for("@search"); ?>" method="get">
						<input type="text" name="search">
						<input type="hidden" name="page" value="1">
					</form>
				</li>
				<a href="<?php echo url_for("actions/login"); ?>">
					<li class="right login">
						<p><?php echo __("Se Connecter"); ?></p>
					</li>
				</a>
				<a href="<?php echo url_for("subscribe/index"); ?>">
					<li class="right subscribe">
						<p><?php echo __("Inscription"); ?></p>
					</li>
				</a>
			</ul>
			<?php endif; ?>
		</div>
	</div>
	<div class="site">
		<div class="under">
			<?php if($sf_user->isAuthenticated() && sfContext::getInstance()->getRequest()->hasParameter("account_created")): ?>
			<div class="hoody confirmation">
				<div class="close">
					<a href="javascript:;" onclick="$(this).parent().parent().remove()"><img src="/images/new/mini-close.png"><b><?php echo __("fermer"); ?></b></a>
				</div>
				<?php if(RRR::$hod !== false): ?>
					<?php echo RRR::$hod; ?>
				<?php else: ?>
					<?php echo __("Bienvenue sur le Réseau Rural %name, votre compte a bien été créé !", array("%name" => $sf_user->getObject()->getPrenom())); ?> <br/>
					<?php echo __("Prenez quelques instants pour compléter votre profil, véritable carte de visite sur ce réseau."); ?>
				<?php endif; ?>
			</div>
			<?php elseif($sf_user->isAuthenticated()): ?>
				<?php include_component("profile", "reminder"); ?>
			<?php endif; ?>
			<div class="content">
				<?php echo $sf_content; ?>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<div class="footer">
		<div class="site">
			<div class="credits">
				<a href="http://www.wterritoires.fr/" target="_blank"><?php echo __("Réseau Rural de Picardie fonctionne grâce à wTerritoires, <br/>projet Open Source sous licence AGPL."); ?></a>
			</div>
			<ul>
				<li class="title">
					<?php echo __("Liens utiles"); ?>
				</li>
				<li class="lft">
					<a href="<?php echo url_for("@legal"); ?>"><?php echo __("Crédits"); ?></a>
				</li>
				<li>
					<a href="<?php echo url_for("@cgu"); ?>"><?php echo __("Conditions Générales d'Utilisation"); ?></a>
				</li>
			</ul>
			<ul>
				<li class="title">
					<?php echo __("Référentiel"); ?> 
				</li>
				<li class="lft">
					<?php echo link_to(__("Filières"), "@directory_index?type=filiere"); ?>
				</li>
				<li>
					<?php echo link_to(__("Métiers"), "@directory_index?type=metier"); ?>
				</li>
				<li>	
					<?php echo link_to(__("Thèmes"), "@directory_index?type=theme"); ?>
				</li>
				<li>
					<?php echo link_to(__("Compétences"), "@directory_index?type=competence"); ?>
				</li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', '<?php echo sfConfig::get("app_google_anal"); ?>']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
</body>
</html>