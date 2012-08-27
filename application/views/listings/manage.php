	<div id="item_view" class="mainContent">
	<h2>Listings</h2>
	<?php if(isset($returnMessage)) echo $returnMessage."<br />"; ?>



	<?=anchor("listings/create","Create a new listing"); ?>
	<br /><br />

	<?php
	if(count($items) > 0){
		 foreach ($items as $item): ?>
		<div class="productBox" id="prod_<?=$item['itemHash']; ?>">
			<h3><?=anchor('item/'.$item['itemHash'], $item['name']);?></h3><hr/>
			<?=anchor("listings/edit/".$item['itemHash'], 'Edit');?> | 
			<?=anchor("listings/remove/".$item['itemHash'], 'Remove');?> |
			<?=anchor("listings/images/".$item['itemHash'], 'Images');?><br />
			<!--<div class="rating">item Rating: <?=$item['rating'];?>/5</div>-->
			 <div class="itemImg">
			  <?=anchor('item/'.$item['itemHash'], "<img src='data:image/jpeg;base64,{$item['itemImgs']['encoded']}' title='{$item['name']}' height='70' width='100'>"); ?>
			 </div>
		</div>
		<?php endforeach;
	} else {
		echo "You have no listings!";
	} ?>
		<div class="clear"></div>

	</div>
