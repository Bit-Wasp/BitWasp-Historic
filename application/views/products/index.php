	<div id="product_view" class="mainContent">
	<?php foreach ($products as $product): ?>
		<div class="productBox" id="prod_<?=$product['productHash']; ?>">
			<h3><?=anchor('product/'.$product['productHash'], $product['name']);?></h3>
			<div class="price">Price: <span class="priceValue"><?=$product['price'];?><?=$product['symbol']?></span></div>
			<div class="vendor"><?=anchor('user/'.$product['vendor']['userHash'],$product['vendor']['userName']); ?>
				<span class="rating">(<?=anchor('user/'.$product['vendor']['userHash'],$product['vendor']['rating']);?>)</span>
			</div>
			<!--<div class="rating">Product Rating: <?=$product['rating'];?>/5</div>-->
			 <div class="productImg">
			  <?=anchor('product/'.$product['productHash'], "<img src='data:image/jpeg;base64,{$product['productImgs']}' title='{$product['name']}' width='150'>"); ?>
			 </div>
		</div>
	<?php endforeach ?>
		<div class="clear"></div>
	</div>
