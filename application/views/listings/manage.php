        <div class="span9 mainContent" id="manage_items">
          <h2>Listings</h2>
          <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>

	        <?php if(count($items) > 0){ ?>
          <ul id="item_listing" class="thumbnails">
		        <? foreach ($items as $item): ?>
            <li class="span2 productBox" id="prod_<?=$item['itemHash']; ?>">
              <div class="thumbnail">
	              <div class="itemImg">
	                <?=anchor('item/'.$item['itemHash'], "<img src='data:image/jpeg;base64,{$item['itemImgs']['encoded']}' title='{$item['name']}' height='{$item['itemImgs']['height']}' width='{$item['itemImgs']['width']}'>"); ?>
	              </div>
                <div class="caption">
			            <h3><?=anchor('item/'.$item['itemHash'], $item['name']);?></h3>
			            <?=anchor("listings/edit/".$item['itemHash'], 'Edit');?> | 
			            <?=anchor("listings/remove/".$item['itemHash'], 'Remove');?> |
			            <?=anchor("listings/images/".$item['itemHash'], 'Images');?>
			            <!--<div class="rating">item Rating: <?=$item['rating'];?>/5</div>-->
                </div>
              </div>
		        </li>
		        <?php endforeach; ?>
          </ul>
	        <? } else { ?>
		        You have no listings!
	        <? } ?>
	        <div class="form-actions">
            <?=anchor("listings/create","Create a new listing", 'class="btn btn-primary"'); ?>
          </div>
        </div>
