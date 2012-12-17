        <div class="span9 mainContent" id="edit_item">
          <h2>Listings</h2>
          <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>
            <?php echo form_open('listings/edit/'.$item['itemHash'], array('class' => 'form-horizontal')); ?>
              <fieldset>

              <div class="control-group">
                <label class="control-label" for="name">Name</label>
                <div class="controls">
                  <input type='text' name='name' value="<?php echo $item['name'];?>" />
                  <span class="help-inline"><?php echo form_error('name'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="description">Description</label>
                <div class="controls">
                  <textarea name='description'><?php echo $item['description'];?></textarea>
                  <span class="help-inline"><?php echo form_error('description'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="categoryID">Name</label>
                <div class="controls">
                  <select name='categoryID' id='<?php echo $item['category'];?>'>
                    <?php foreach ($categories as $subCat): ?>
	                  <option value="<?php echo $subCat['id'];?>" <?php if($subCat['id'] == $item['category']) echo 'selected="selected"'; ?>><?php echo $subCat['name'];?></option>
                    <?php endforeach ?>
                  </select>
                  <span class="help-inline"><?php echo form_error('categoryID'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="price">Price</label>
                <div class="controls">
                  <div class="input-prepend">
                    <span class="add-on"><i>BTC</i></span>
                    <input type='text' name='price' value="<?php echo $item['price'];?>" />
                  </div>
                  <span class="help-inline"><?php echo form_error('price'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="currency">Currency</label>
                <div class="controls">
                  <select name='currency'>
                    <?php foreach ($currencies as $currency): ?>
	                    <option value='<?php echo $currency['id'];?>'><?php echo $currency['name'];?> (<?php echo $currency['symbol'];?>)</option>
                    <?php endforeach ?>
                  </select>
                  <span class="help-inline"><?php echo form_error('currency'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="hidden">Private / Hidden Listing</label>
                <div class="controls">
                  <input name="hidden" type="checkbox" value='on' <?php if($item['hidden']=='1') { echo 'checked="checked"'; } ?>>
                  <span class="help-inline"><?php echo form_error('hidden'); ?></span>
                </div>
              </div>

              <input type='hidden' name='itemHash'  value='<?php echo $item['itemHash'];?>' />

              <div class="form-actions">
                <input type="submit" value="Save" class="btn btn-primary" />
                <?php echo anchor("listings","Cancel", 'class="btn"'); ?>
              </div>
            </fieldset>
          </form>
        </div>

