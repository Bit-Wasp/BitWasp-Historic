        <div class="span9 mainContent" id="add_Listing_Image">
          <h2>Add Category</h2>
          <p>Complete the form to add a new category.</p>
          <?php echo form_open_multipart('admin/category/add', array('class' => 'form-horizontal')); ?>
            <fieldset>
              <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>

              <div class="control-group">
                <label class="control-label" for="name">Name</label>
                <div class="controls">
                  <input type='text' name='name' value="<?php echo set_value('name'); ?>" />
                  <span class="help-inline"><?php echo form_error('password'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="parentID">Parent Category</label>
                <div class="controls">
                  <select name='parentID'>
		                <option value='0'>Root Category</option>
	                  <?php foreach ($subCats as $subCat): ?>
		                <option value='<?=$subCat['id'];?>'><?=$subCat['name'];?></option>
	                  <?php endforeach ?>
                  </select>
                  <span class="help-inline"><?php echo form_error('parentID'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="description">Description</label>
                <div class="controls">
                  <textarea name='description' height='30' width='100'><?php echo set_value('description'); ?></textarea>
                  <span class="help-inline"><?php echo form_error('description'); ?></span>
                </div>
              </div>

              <div class="form-actions">
                <input type='submit' class="btn btn-primary" value="Add" />
                <?=anchor('admin', 'Cancel', 'class="btn"');?>
              </div>
            </fieldset>
          </form>
        </div>
