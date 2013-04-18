<div class="common-feed">
	<div class="padded">
		<div class="table-presentation">

			<?php if($project["date_debut"]): ?>
			<div class="tab">
				<div class="label">
					<?php echo __("Période"); ?>
				</div>
				<div class="label-right">
					<?php if($project["date_debut"]) echo format_date($project["date_debut"], "P") . "<br/>"; ?>
					<?php if($project["date_echeance"]) echo format_date($project["date_echeance"], "P"); ?>
				</div>
				<div class="clear"></div>
			</div>
			<?php endif; ?>

			<div class="tab">
				<div class="label">
					<?php echo __("Avancement"); ?>
				</div>
				<div class="label-right">
					<div class="percent">
						<p class="txt"><?php echo $project["avancement"]; ?> %</p>
						<div class="percented" style="width: <?php echo $project["avancement"]; ?>%"></div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			
			<?php if($project["besoins"]): ?>
			<div class="tab">
				<div class="label">
					<?php echo __("Besoins"); ?>
				</div>
				<div class="label-right">
					<?php echo ($project["besoins"] ? nl2br($project["besoins"]) : __("Pas d'informations")); ?>
				</div>
				<div class="clear"></div>
			</div>
			<?php endif; ?>
			
			<?php if($project["objectifs_quantitatif"]): ?>
			<div class="tab">
				<div class="label">
					<?php echo __("Objectifs Quantitatifs"); ?>
				</div>
				<div class="label-right">
					<?php echo ($project["objectifs_quantitatif"] ? nl2br($project["objectifs_quantitatif"]) : __("Pas d'informations")); ?>
				</div>
				<div class="clear"></div>
			</div>
			<?php endif; ?>
			
			<?php if($project["objectifs_qualitatif"]): ?>
			<div class="tab">
				<div class="label">
					<?php echo __("Objectifs Qualitatif"); ?>
				</div>
				<div class="label-right">
					<?php echo ($project["objectifs_qualitatif"] ? nl2br($project["objectifs_qualitatif"]) : __("Pas d'informations")); ?>
				</div>
				<div class="clear"></div>
			</div>
			<?php endif; ?>

			<?php if($project["lecons"]): ?>
			<div class="tab">
				<div class="label">
					<?php echo __("Leçons"); ?>
				</div>
				<div class="label-right">
					<?php echo ($project["lecons"] ? nl2br($project["lecons"]) : __("Pas d'informations")); ?>
				</div>
				<div class="clear"></div>
			</div>
			<?php endif; ?>
			
			<?php if($project["strategie"]): ?>
			<div class="tab">
				<div class="label">
					<?php echo __("Stratégie"); ?>
				</div>
				<div class="label-right">
					<?php echo ($project["strategie"] ? nl2br($project["strategie"]) : __("Pas d'informations")); ?>
				</div>
				<div class="clear"></div>
			</div>
			<?php endif; ?>
			
			<?php if($project["resultats"]): ?>
			<div class="tab">
				<div class="label">
					<?php echo __("Résultats"); ?>
				</div>
				<div class="label-right">
					<?php echo ($project["resultats"] ? nl2br($project["resultats"]) : __("Pas d'informations")); ?>
				</div>
				<div class="clear"></div>
			</div>
			<?php endif; ?>
			
		</div>
	</div>
</div>