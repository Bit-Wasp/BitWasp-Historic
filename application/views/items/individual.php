        <div class="span9 mainContent" id="item_detail">
          <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>
		      <div class="itemInfo" id="prod_<?php echo $item['itemHash']; ?>">
			      <h2><?php echo $item['name'] ?></h2>
			      <p class="vendor">
				      Vendor: <?php echo anchor('user/'.$item['vendor']['userHash'],$item['vendor']['userName']); ?>
				      <span class="rating">(<?php echo anchor('user/'.$item['vendor']['userHash'],$item['vendor']['rating']);?>)</span> | 
				      <?php echo anchor('messages/send/'.$item['vendor']['userHash'],'Message this vendor');?>
			      </p>
			      <div id="main">
			        <?php echo $item['description'] ?>
			      </div>
			      <div class="price">Price: <span class="priceValue"><?php echo $item['price'];?><?php echo $item['symbol']?></span></div>
			      <?php if($userRole == 'buyer'){ ?><div><?php echo anchor('order/'.$item['itemHash'], 'Purchase Item'); ?></div><?php } ?>
		      </div>
          <ul id="item_listing" class="thumbnails">
            <?php foreach ($item['itemImgs'] as $image): ?>
            <li class="span2 productBox" id="prod_<?php echo $item['itemHash']; ?>">
              <div class="thumbnail">
		            <img class="productImg" src="data:image/jpeg;base64,<?php echo $image['encoded'];?>" title="<?php echo $item['name']; ?>" width="500" />
              </div>
            </li>
			      <?php endforeach ?>
		      </ul>
	      </div>

