<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>RRR Feader</title>
    <?php use_stylesheet('admin.css') ?>
    <?php include_javascripts() ?>
    <?php include_stylesheets() ?>
  </head>
  <body>
    <div id="container">
      <div id="header">
        <h1>
          <a href="<?php echo url_for('homepage') ?>">
            <img src="/images/new/bmp_logo_rrp.png" alt="RRR FEADER PICARDIE" />
          </a>
        </h1>
      </div>

      <div id="menu">
        <ul>
          <li>
            <?php echo link_to('Accueil', 'homepage') ?>
          </li>
          <?php if ($sf_user->isAuthenticated()): ?>
          <li>
            <?php echo link_to('Profils', 'profil') ?>
          </li>
           <li>
            <?php echo link_to('Home', 'home_news') ?>
          </li>
          <li>
            <?php echo link_to('Projets', 'projet') ?>
          </li>
          <li>
            <?php echo link_to('Structures', 'structure') ?>
          </li>
          <li>
            <?php echo link_to('Métiers', 'metier') ?>
          </li>
          <li>
            <?php echo link_to('Filières', 'filiere') ?>
          </li>
          <li>
            <?php echo link_to('Compétences', 'competence') ?>
          </li>
          <li>
            <?php echo link_to('Thèmes', 'theme') ?>
          </li>
          <li>
            <?php echo link_to('Communes', 'commune') ?>
          </li>
          <li>
            <?php echo link_to('Contacts', 'structure_contact') ?>
          </li>
          <li>
            <?php echo link_to('Pays', 'pays') ?>
          </li>
          <li><?php echo link_to('Gestion Users BO', 'sf_guard_user') ?></li>
          <li><?php echo link_to('Logout', 'sf_guard_signout') ?></li>
          <?php endif; ?>
        </ul>
      </div>

      <div id="content">
        <?php echo $sf_content ?>
      </div>

      <div id="footer">
        Simon Lamellière / slamelliere@worketer.fr
      </div>
    </div>
  </body>
</html>