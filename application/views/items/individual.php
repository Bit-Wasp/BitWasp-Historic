        <div class="span9 mainContent" id="item_detail">
          <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>
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
          <ul id="item_listing" class="thumbnails">
            <?php foreach ($item['itemImgs'] as $image): ?>
            <li class="span2 productBox" id="prod_<?=$item['itemHash']; ?>">
              <div class="thumbnail">
		            <img class="productImg" src="data:image/jpeg;base64,<?=$image['encoded'];?>" title="<?=$item['name']; ?>" width="<?=$image['width'];?>" />
              </div>
            </li>
			      <?php endforeach ?>
		      </ul>
	      </div>

