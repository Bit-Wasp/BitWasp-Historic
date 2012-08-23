	<div id="itemDetail" class="mainContent">
		<div class="itemInfo" id="prod_<?=$item['itemHash']; ?>">
			<h2><?=$item['name'] ?></h2>
			<p class="vendor">
				Vendor: <?=anchor('user/'.$item['vendor']['userHash'],$item['vendor']['userName']); ?>
				<span class="rating">(<?=anchor('user/'.$item['vendor']['userHash'],$item['vendor']['rating']);?>)</span> | 
				<?=anchor('messages/send/'.$item['vendor']['userHash'],'Message this vendor');?>
			</p>
			<div id="main">
			<?php echo $item['description'] ?>
			</div>
			<div class="price">Price: <span class="priceValue"><?=$item['price'];?><?=$item['symbol']?></span> 
			<?php if($userRole == 'buyer'){ ?>
			| <?=anchor('order/'.$item['itemHash'], 'Purchase Item'); ?></div><?php } ?>
			<div class="clear"></div>
		</div>
		<ul class="itemImgs">
			<?php foreach ($item['itemImgs'] as $image): ?>
			  <li><img class="productImg" src="data:image/jpeg;base64,<?=$image['encoded'];?>" title="<?=$item['name']; ?>" width="<?=$image['width'];?>" /></li>
			<?php endforeach ?>
			<div class="clear"></div>
		</ul>
		<div class="clear"></div>
	</div>

