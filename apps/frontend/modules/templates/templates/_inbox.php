<?php echo __("%sender vous a envoyé un message privé", array("%sender" => $sender)); ?>,
<br/><br/>
<table cellpadding="10" cellspacing="0" width="100%">
	<tr>
		<td valign="top" style="border-bottom: 1px solid #BBB" bgcolor="#CCC" width="30%"><b><?php echo __("Sujet"); ?></b></td>
		<td valign="top" style="border-bottom: 1px solid #BBB" bgcolor="#FFF" width="70%"><?php echo $subject; ?></td>
	</tr>
	<tr>
		<td valign="top" style="border-bottom: 1px solid #BBB" bgcolor="#CCC" width="30%"><b><?php echo __("Message"); ?></b></td>
		<td valign="top" style="border-bottom: 1px solid #BBB" bgcolor="#FFF" width="70%"><?php echo  nl2br($message); ?></td>
	</tr>
</table>

<br/><br/>
<?php echo __("Suivez le lien ci-dessous :"); ?>