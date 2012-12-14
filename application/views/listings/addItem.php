        <div class="span9 mainContent" id="add_item">
          <h2>Add Item</h2>
          <?php echo form_open('listings/create', array('class' => 'form-horizontal')); ?>
            <fieldset>
              <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>

              <div class="control-group">
                <label class="control-label" for="name">Name</label>
                <div class="controls">
                  <input type='text' name='name' value="<?php echo set_value('name'); ?>" />
                  <span class="help-inline"><?php echo form_error('name'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="description">Description</label>
                <div class="controls">
                  <textarea name='description' rows="10"><?php echo set_value('description'); ?></textarea>
                  <span class="help-inline"><?php echo form_error('description'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="categoryID">Category</label>
                <div class="controls">
                  <select name='categoryID'>
	                  <?php foreach ($categories as $subCat): ?>
		                  <option value='<?=$subCat['id'];?>'><?=$subCat['name'];?></option>
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
                    <input type='text' name='price' value="<?php echo set_value('price'); ?>" />
                  </div>
                  <span class="help-inline"><?php echo form_error('price'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="currency">Currency</label>
                <div class="controls">
                  <select name='currency'>
	                  <?php foreach ($currencies as $currency): ?>
		                  <option value='<?=$currency['id'];?>'><?=$currency['name'];?> (<?=$currency['symbol'];?>)</option>
	                  <?php endforeach ?>
                  </select>
                  <span class="help-inline"><?php echo form_error('currency'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="hidden">Private / Hidden Listing</label>
                <div class="controls">
                  <input name="hidden" type="checkbox" value='on' >
                  <span class="help-inline"><?php echo form_error('hidden'); ?></span>
                </div>
              </div>

	            <div class="form-actions">
                <input type="submit" value="Create" class="btn btn-primary" />
                <?=anchor("listings","Cancel", 'class="btn"'); ?>
              </div>
            </fieldset>
          </form>
        </div>

