<center>
	<table width="600px" cellpadding="5" cellspacing="0" border="0" borderColor="#333333">
		<tr>
			<td>
				<img src="<?php echo $logo; ?>">
			</td>
			<td>
				<p style="font-size: 14px; font-family: Arial; margin: 0; margin-left: 3px;"><?php echo sfConfig::get("app_email_header"); ?></p>
			</td>
		</tr>
		<tr>
			<td width="600px" colspan=2>
				<center>
					<table cellpadding="14" cellspacing="0" width="600px" style="background: #F1F1F1; margin-left: 3px; margin-top: 6px;  border-right: 1px solid #CCC; border-left: 1px solid #CCC; border-bottom: 1px solid #777; border-top: 1px solid #777">
						<tr>
							<td width="600px" valign="top">
								<p style="font-size: 15px; font-family: Arial; margin-bottom: 0px;"><b><?php echo __("Bonjour %fullname !", array("%fullname" => $name)); ?></b></p>
								<p style="font-size: 14px; font-family: Arial; margin-bottom: 0px">
									<?php if(isset($content)) echo html_entity_decode($content, ENT_QUOTES, "UTF-8"); ?>
									<?php if(trim($link)): ?><br/><br>
									<a href='<?php echo $link; ?>'><?php echo $link_text; ?></a>
									<?php endif; ?>
								</p>
							</td>
						</tr>
						<?php if($disable_signature === false): ?>
						<tr>
							<td width="600px" valign="top">
								<p style="font-size: 13px; font-family: Arial; margin: 0px;">
									<hr size="1" color="#555" noshade>
									<b><?php echo sfConfig::get("app_email_signature_1"); ?></b> <br>
									<?php echo sfConfig::get("app_email_signature_2"); ?> <br>
									<a href="mailto:<?php echo sfConfig::get("app_email_signature_contact"); ?>"><?php echo sfConfig::get("app_email_signature_contact"); ?></a>
								</p>
							</td>
						</tr>
						<?php endif; ?>
					</table>
				</center>
			</td>
		</tr>
		<tr>
			<td colspan=2>
				<p style="margin-left: 3px; font-size: 11px; font-family: Arial; margin-top: 0px;">
					wTerritories (Réseau Rural Régional) est un outil créé par <b>Worketer SARL</b><br>
					pour activer ou désactiver vos notifications par e-mail <a href="<?php echo sfConfig::get("app_url"); ?>profil/edit/privacy"><?php echo sfConfig::get("app_url"); ?>profil/edit/privacy</a> <br>
					pour modifier votre adresse e-mail <a href="<?php echo sfConfig::get("app_url"); ?>profil/edit/misc"><?php echo sfConfig::get("app_url"); ?>profil/edit/misc</a> <br>
					pour nous signaler un problème ou soumettre une suggestion <a href="<?php echo sfConfig::get("app_url"); ?>feedback"><?php echo sfConfig::get("app_url"); ?>feedback</a> <br>
				</p>
			</td>
		</tr>
	</table>
</center>