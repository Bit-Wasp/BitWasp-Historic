        <div class="span9 mainContent" id="admin-panel">
          <h2>Review Order</h2>

          <?php echo form_open('orders/review/'.$order['id'], array('class' => 'form-horizontal')); ?>
            <fieldset>
              <?php if($returnMessage!="") echo '<div class="alert">' . $returnMessage . '</div>'; ?>

              <div class="container-fluid">
                <div class="row-fluid">
                  <div class="span2"><strong>Vendor</strong></div>
                  <div class="span7"><?php echo $order['seller']['userName'];?></div>
                </div>
                <div class="row-fluid">
                  <div class="span2"><strong>Order Number</strong></div>
                  <div class="span7"><?php echo $order['id'];?></div>
                </div>
                <div class="row-fluid">
                  <div class="span2"><strong>Total Price</strong></div>
                  <div class="span7"><?php echo $order['currencySymbol'].$order['totalPrice'];?></div>
                </div>
                <div class="row-fluid">
                  <div class="span2"><strong>Items</strong></div>
                  <div class="span7">
                    <ul id="items">
                      <?php foreach($order['items'] as $item):?>
                      <li><?php echo $item['quantity']." x ".$item['name'];?></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="rating">Rating</label>
                <div class="controls">
                	<select name='rating'>
	                  <option value='notset'>Rating</option>
	                  <option value='1'>1</option>
	                  <option value='2'>2</option>
	                  <option value='3'>3</option>
	                  <option value='4'>4</option>
	                  <option value='5'>5</option>
                  </select>
                  <span class="help-inline"><?php echo form_error('rating'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="comment">Comments</label>
                <div class="controls">
                  <textarea name='comment'></textarea>
                  <span class="help-inline"><?php echo form_error('comment'); ?></span>
                </div>
              </div>

              <div class="form-actions">
                <input type='submit' class="btn btn-primary" value="Submit Review" />
              </div>
            </fieldset>
          </form>
        </div>


