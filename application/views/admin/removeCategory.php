        <div class="span9 mainContent" id="remove_Menu_Category">
          <h2>Remove Category</h2>
          <p>Complete the form to remove a category.</p>
          <?php echo form_open('admin/category/remove', array('class' => 'form-horizontal')); ?>
            <fieldset>
              <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>

              <div class="control-group">
                <label class="control-label" for="category">Category</label>
                <div class="controls">
		  <select name='categoryID'>
        	  <?php foreach ($subCats as $subCat): ?>
                    <option value='<?=$subCat['id'];?>'><?=$subCat['name'];?></option>
        	  <?php endforeach ?>
		  </select><br />

                  <span class="help-inline"><?php echo form_error('catID'); ?></span>
		</div>
	      </div>

              <div class="form-actions">
                <input type='submit' class="btn btn-primary" value="Remove" />
                <?=anchor('admin', 'Cancel', 'class="btn"');?>
              </div>
            </fieldset>
          </form>
        </div>



