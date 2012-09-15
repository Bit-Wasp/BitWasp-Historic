        <div class="span9 mainContent" id="item_view">
          <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>
          <?php if(!empty($items)) { ?>
          <ul id="item_listing" class="thumbnails">
            <?php foreach ($items as $item): ?>
              <li class="span2 productBox" id="prod_<?=$item['itemHash']; ?>">
                <div class="thumbnail">
                  <div class="itemImg">
                    <?=anchor('item/'.$item['itemHash'], "<img src='data:image/jpeg;base64,{$item['itemImgs']['encoded']}' title='{$item['name']}' height='{$item['itemImgs']['height']}' width='{$item['itemImgs']['width']}'>"); ?>
                  </div>
                  <div class="caption">
                    <h3><?=anchor('item/'.$item['itemHash'], $item['name']);?></h3>
                    <div class="price">Price: <span class="priceValue"><?=$item['price'];?><?=$item['symbol']?></span></div>
                    <div class="vendor"><?=anchor('user/'.$item['vendor']['userHash'],$item['vendor']['userName']); ?>
	                    <span class="rating">(<?=anchor('user/'.$item['vendor']['userHash'],$item['vendor']['rating']);?>)</span>
                    </div>
                    <!--<div class="rating">item Rating: <?=$item['rating'];?>/5</div>-->
                  </div>
                </div>
	            </li>
            <?php endforeach; ?>
          </ul>
          <?php } ?>
        </div>

