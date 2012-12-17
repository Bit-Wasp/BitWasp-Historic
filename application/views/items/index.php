        <div class="span9 mainContent" id="item_view">
          <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>
          <?php if(!empty($items)) { ?>

	  	  <?php echo $pagination_links;?><?php echo form_open('items/item_count');?>
	  <select name='items_per_page' onchange='this.form.submit()'>
		<?php
		  $unit = 25;
		  for($i = 1; $i < 5; $i++){?>
	    <option value='<?php echo $unit*$i;?>' <?php if($items_per_page==($unit*$i)) echo "selected";?> /> <?php echo $unit*$i;?> </option>
		  <?php } ?>
          </select>
	  <noscript>
          <button type='submit' class="btn btn-primary">Go</button>
	  </noscript>
          </form>

          <ul id="item_listing" class="thumbnails">
            <?php foreach ($items as $item): ?>
              <li class="span2 productBox" id="prod_<?php echo $item['itemHash']; ?>">
                <div class="thumbnail">
                  <div class="itemImg">
                    <?php echo anchor('item/'.$item['itemHash'], "<img src='data:image/jpeg;base64,{$item['itemImgs']['encoded']}' title='{$item['name']}' width='200'>"); ?>
                  </div>
                  <div class="caption">
                    <h3><?php echo anchor('item/'.$item['itemHash'], $item['name']);?></h3>
                    <div class="price">Price: <span class="priceValue"><?php echo $item['price'];?><?php echo $item['symbol']?></span></div>
                    <div class="vendor"><?php echo anchor('user/'.$item['vendor']['userHash'],$item['vendor']['userName']); ?>
	                    <span class="rating">(<?php echo anchor('user/'.$item['vendor']['userHash'],$item['vendor']['rating']);?>)</span>
                    </div>
                    <!--<div class="rating">item Rating: <?php echo $item['rating'];?>/5</div>-->
                  </div>
                </div>
	            </li>
            <?php endforeach; ?>
          </ul>
	  <?php echo $pagination_links;?>
	  <?php echo form_open('items/item_count');?>
	  <select name='items_per_page' onchange='this.form.submit()'>
		<?php
		  $unit = 25;
		  for($i = 1; $i < 5; $i++){?>
	    <option value='<?php echo $unit*$i;?>' <?php if($items_per_page==($unit*$i)) echo "selected";?> /> <?php echo $unit*$i;?> </option>
		  <?php } ?>
          </select>
	  <noscript>
	  <input type='submit' value='Go' class="btn btn-primary" />
	  </noscript>
          </form>

          <?php } ?>
        </div>

