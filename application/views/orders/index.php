        <div class="span9 mainContent" id="order_view">
          <h2>Orders</h2>
          <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>
          <?php  
          if(count($orders) > 0){?>
	        <?php echo form_open('order/recount'); ?>
	          <p>Review your current orders:</p>
	          <table class="table table-striped orderlist">
		          <thead>
                <tr>
			            <th>Seller</th>
			            <th>Quantity</th>
			            <th>Items</th>
			            <th>Price</th>
			            <th>Progress</th>
		            </tr>
              </thead>
		          <?php 
			          $recount = 0;			
			          foreach($orders as $order): ?>
		          <tr>
			          <td><?=anchor('user/'.$order['seller']['userHash'], $order['seller']['userName']);?></td>
			          <td><?php
				
				          if($order['step'] == '0'){
					          $recount = 1; ?>

					          <?php foreach($order['items'] as $item){
						          echo "<select name='quantity[{$order['seller']['userHash']}][{$item['itemHash']}]' autocomplete=\"off\">\n";
						          for($i = 0; $i < 11; $i++){?>
							          <option value="<?=$i;?>" <?php if($i == $item['quantity']){ echo "selected=\"selected\""; }?>><?=$i;?></option>
						          <?php }		
						          echo "</select><br/>";
					          }?>
					
				          <?php } else {
					          foreach($order['items'] as $item):?>
				
					          <?=$item['quantity'];?><br />
				
					          <?php endforeach;
				          } ?>
			          </td>
			
			          <td><ul><?php foreach($order['items'] as $item): ?>
				          <li>
					          <?php if($item['itemHash'] == 'removed'){?>
						          <?=$item['name'];?>
					          <?php } else { ?>
						          <?=anchor('item/'.$item['itemHash'], $item['name']);?>
					
						
					          <?php } ?>
				          </li>
			          <?php endforeach; ?></ul>
			          <td><?=$order['currencySymbol'].$order['totalPrice'];?></td>
			          <td><?=$order['progress']?></td>
		          </tr>
		          <?php endforeach; ?>
	          </table>
	          <?php if($recount == '1'){?>
            <div class="form-actions">
	            <input type='submit' class="btn btn-primary" value='Recount' />
            </div>
	        </form><?php } ?>
          <? } else { ?>
          <p>You have no orders at present.<p>
          <?php } ?>

        </div> <!-- \main_content -->
