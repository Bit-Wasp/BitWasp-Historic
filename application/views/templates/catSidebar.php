	<div id="catSidebar" class="leftSide Sidebar">
		Categories will go here.
		<ul>
		<?php foreach ($cats as $category): ?>
		<li><a href="<?=base_url(); ?>cat/<?=$category['slug']; ?>"><?=$category['name']; ?></a></li>
		<?php endforeach ?>
		</ul>
		<div class="clear"></div>
	</div>
