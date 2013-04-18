<?php echo __("Bonjour %name", array("%name" => $names)); ?>,

<?php echo __("%person vient de faire un commentaire sur votre %type intitulé(e) \"%title\".", array("%type" => $type, "%title" => $title, "%person" => $person)); ?>


"<?php echo RRR::cut_text($content, 700); ?>"


<?php echo __("Pour répondre à ce commentaire, connectez vous sur : %urls", array("%urls" => sfConfig::get("app_url") . $urlx)); ?>


<?php echo __("A bientôt sur le Réseau Rural Picardie"); ?>


<?php echo __("L'équipe RRR")?>