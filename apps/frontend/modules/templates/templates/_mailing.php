<?php echo __("Message de la part de %you", array("%you" => $inviter)); ?> <br/>
<?php echo __("Aux membres de : '%name'", array("%name" => $name)); ?> <br/>
----------------------------------------------------------------------------------------
<br><br/>
<?php echo htmlentities($message, ENT_QUOTES, "UTF-8"); ?>
<br><br/>
----------------------------------------------------------------------------------------