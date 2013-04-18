<?php $hash = md5($feedback->getId()."feedback"); ?>
<a name="feedback_line_<?php echo $feedback->getId(); ?>"> </a>
<div class="line<?php if($last) echo ' last'; ?>" id="feedback_line_<?php echo $feedback->getId(); ?>">
	<a href='<?php echo url_for("@profile?login=".$feedback->getProfil()->getLogin()); ?>'>
		<?php echo image_tag("/uploads/profil/" . $feedback->getProfil()->getMiniPicture()); ?>
	</a>
	<div class="cadre">
		<div class="tools">
			<?php if($sf_user->isAdmin() ||  $sf_user->getId() == $feedback->getProfilId()): ?>
			<a href="<?php echo url_for("feedback/edit?id=".$feedback->getId()); ?>" class="pops blue">Editer</a>
				<a onclick="return confirm('<?php echo __("Etes-vous sûr de vouloir supprimer votre feedback ?"); ?>');" href="<?php echo url_for("feedback/delete?id=".$feedback->getId()); ?>" class="pops orange">Supprimer</a>
			<?php endif; ?>
		</div>
		<h2>
			<?php echo $feedback->getTitre(); ?>
		</h2>
		<h4>
			<a href='<?php echo url_for("@profile?login=".$feedback->getProfil()->getLogin()); ?>'>
				par <?php echo $feedback->getProfil(); ?>
			</a>,
			le <?php echo date("d/m/Y", strtotime($feedback->getCreatedAt())); ?> - <?php $cc = $feedback->getCountComment(); echo ($cc > 1 ? $cc . " commentaires" : $cc . " commentaire"); ?>
			- <?php $vc = $feedback->getCountVote(); echo ($vc > 1 ? "<a class='votes popin-friend' href='".url_for("commentaire/listvote?cid=".$feedback->getId()."&ctype=feedback")."' id='votes_".$hash."'>".$vc . " votes</a>" : "<a class='votes popin-friend' href='".url_for("commentaire/listvote?cid=".$feedback->getId()."&ctype=feedback")."' id='votes_".$hash."'>". $vc . " vote</a>"); ?>
		</h4>
		<hr>
		<p class="commentaire_perso"><?php echo $feedback->getMessage(); ?></p>
		<div class="clear"> </div>
		<?php echo include_partial("commentaire/addcomment", array("content_type" => "feedback", "content_id" => $feedback->getId())); ?>
	</div>
	<div class="clear"> </div>
</div>