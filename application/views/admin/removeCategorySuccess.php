      <div class="span9 mainContent" id="fix_orphan_categories">
          <h2>Category Removed</h2>
              <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>
		<?php if($countSpareItems > 0){ ?>
	  <p>Some items were orphaned as a result, you need to move them to a new category.</p>
	  <?php echo form_open('admin/category/fixOrphans'); ?>
	  <input type='hidden' name='oldCat' value='<?php echo $oldCat;?>' />
          <fieldset>

              <div class="control-group">
                <label class="control-label" for="parent">Category</label>
                <div class="controls">
		  <select name='categoryID'>
		  <?php foreach ($currentCats as $subCat): ?>
		    <option value="<?php echo $subCat['id'];?>"><?php echo $subCat['name'];?></option>
		<?php endforeach ?>
		  </select><br /><br />

                  <span class="help-inline"><?php echo form_error('categoryID'); ?></span>
                </div>
              </div>

              <div class="form-actions">
                <input type='submit' class="btn btn-primary" name='move_items' value="Move" />
                <?php echo anchor('admin', 'Cancel', 'class="btn"');?>
              </div>
            </fieldset>
          </form>

	  <?php } else if($countSpareCats > 0){?>


          <p>Several categories were orphaned as a result, you need to define a new parent.</p>
          <?php echo form_open('admin/category/fixOrphans'); ?>
          <input type='hidden' name='oldCat' value='<?php echo $oldCat;?>' />
          <fieldset>
              <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>

              <div class="control-group">
                <label class="control-label" for="parent">Category</label>
                <div class="controls">
                  <select name='categoryID'>
                  <?php foreach ($currentCats as $subCat): ?>
                    <option value='<?php echo $subCat['id'];?>'><?php echo $subCat['name'];?></option>
                <?php endforeach ?>
                  </select><br /><br />

                  <span class="help-inline"><?php echo form_error('categoryID'); ?></span>
                </div>
              </div>

              <div class="form-actions">
                <input type='submit' class="btn btn-primary" name='move_cats' value="Move" />
                <?php echo anchor('admin', 'Cancel', 'class="btn"');?>
              </div>
            </fieldset>
          </form>



	  <?php } ?>
        </div>

