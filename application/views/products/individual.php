	<div id="productDetail" class="mainContent">
		<div class="productInfo" id="prod_<?=$product['productHash']; ?>">
			<h2><?=$product['name'] ?></h2>
			<p class="vendor">Vendor: <?=anchor('user/'.$product['vendor']['userHash'],$product['vendor']['userName']); ?>
				<span class="rating">(<?=anchor('user/'.$product['vendor']['userHash'],$product['vendor']['rating']);?>)</span>
			</p>
			<div id="main">
			<?php echo $product['description'] ?>
			</div>
			<div class="price">Price: <span class="priceValue"><?=$product['price'];?><?=$product['symbol']?></span></div>
			<div class="clear"></div>
		</div>
		<div class="productImgs">
			<?php foreach ($product['productImgs'] as $image): ?>
			  <img src="data:image/jpeg;base64,<?=$image;?>" title="<?=$product['name']; ?>" width='230'>
			<?php endforeach ?>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>

