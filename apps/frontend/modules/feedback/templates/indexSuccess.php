<div id="content">
	<div id="profil">

		<a href="<?php echo url_for("feedback/new"); ?>" class="confirm pops" style="float: right;"><?php echo __("Donner mon avis"); ?></a>

		<div id="feedback_list">
			<h1><?php echo __("Suggestions"); ?> (<p id="confirmed_count"><?php echo $total_feedbacks = $pager->getCountQuery()->count(); ?></p>)</h1>

			<div class="clear"> </div>

			<div class="feedbacks" id="projets_confirmed_slot">
			<?php $cr = count($pager->getResults()); $i=0; foreach($pager->getResults() as $feedback): ?>
				<?php echo include_partial("displayline", array("last"=>false, "feedback" => $feedback)); ?>
			<?php endforeach; ?>
			<?php if($cr == 0): ?>
				<?php echo __("Il n'y a pas encore d'avis sur RRR"); ?>
			<?php endif; ?>
			</div>
			<div class="clear up20"> </div>
		</div>

		<?php if ($pager->haveToPaginate()): ?>
		<div class="pagination">
		    <?php include_partial('profil/paginate', array('pager' => $pager)) ?>
		</div>
		<?php endif ?>

	</div>
</div>