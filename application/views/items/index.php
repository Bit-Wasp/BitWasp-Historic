	<div id="item_view" class="mainContent">
	<?php if(isset($returnMessage)) echo $returnMessage; ?><br />

	<?php foreach ($items as $item): ?>
		<div class="productBox" id="prod_<?=$item['itemHash']; ?>">
			<h3><?=anchor('item/'.$item['itemHash'], $item['name']);?></h3>
			<div class="price">Price: <span class="priceValue"><?=$item['price'];?><?=$item['symbol']?></span></div>
			<div class="vendor"><?=anchor('user/'.$item['vendor']['userHash'],$item['vendor']['userName']); ?>
				<span class="rating">(<?=anchor('user/'.$item['vendor']['userHash'],$item['vendor']['rating']);?>)</span>
			</div>
			<!--<div class="rating">item Rating: <?=$item['rating'];?>/5</div>-->
			 <div class="itemImg">
			  <?=anchor('item/'.$item['itemHash'], "<img src='data:image/jpeg;base64,{$item['itemImgs']['encoded']}' title='{$item['name']}' height='{$item['itemImgs']['height']}' width='{$item['itemImgs']['width']}'>"); ?>
			 </div>
		</div>
	<?php endforeach ?>
		<div class="clear"></div>
	</div>
