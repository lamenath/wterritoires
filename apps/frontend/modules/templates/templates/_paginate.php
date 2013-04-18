<?php $routeName = sfContext::getInstance()->getRequest()->getUri(); ?>
<?php $search = (sfContext::getInstance()->getRequest()->hasParameter("search") ? "&search=" . sfContext::getInstance()->getRequest()->getParameter("search") : "") .  (sfContext::getInstance()->getRequest()->hasParameter("activity") ? "&activity=" . sfContext::getInstance()->getRequest()->getParameter("activity") : ""); ?>
<?php $routeName = explode('?', $routeName); $routeName = $routeName[0]; ?>

<?php foreach ($pager->getLinks() as $page): ?>
	<?php if ($pager->getPage() == $page): ?>
		<p><?php echo $page ?></p>
	<?php else: ?>
		<?php echo link_to($page, $routeName."?page=$page".$search) ?>
	<?php endif; ?>
<?php endforeach; ?>

<?php if($pager->getPage() != 1) echo link_to('Première page', $routeName.'?page=1'.$search, array("class" => "last") ) ?>
<?php if($pager->getPage() != $pager->getLastPage()) echo link_to('Dernière page', $routeName.'?page='.$pager->getLastPage().$search, array("class" => "last") ) ?>