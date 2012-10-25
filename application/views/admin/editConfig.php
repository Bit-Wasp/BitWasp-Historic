        <div class="span9 mainContent" id="admin-panel">
          <h2>Edit Configuration</h2>

          <?php echo form_open('admin/updateConfig', array('class' => 'form-horizontal')); ?>
            <fieldset>
              <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>

              <div class="control-group">
                <label class="control-label" for="site_title">Site Title</label>
                <div class="controls">
                  <input type='text' name='site_title' value="<?=$config['site_title'];?>" />
                  <span class="help-inline"><?php echo form_error('site_title'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="login_timeout">Login Timeout</label>
                <div class="controls">
                  <div class="input-append">
                    <input type="text" name="login_timeout" value="<?=$config['login_timeout'];?>">
		    <span class="add-on">minute<?php if($config['login_timeout'] > 1)echo "s";?></span>
                  </div>
                  <span class="help-inline"><?php echo form_error('login_timeout'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="base_url">Base URL</label>
                <div class="controls">
                  <input type='text' name='base_url' value="<?=$config['base_url'];?>" />
                  <span class="help-inline"><?php echo form_error('base_url'); ?></span>
                </div>
              </div>

             <div class="control-group">
                <label class="control-label" for="captcha_length">Captcha Length</label>
                <div class="controls">
                  <div class="input-append">
                    <input type="text" name="captcha_length" value="<?=$config['captcha_length'];?>">
		    <span class="add-on">character<?php if($config['captcha_length'] > 1) echo "s"; ?></span>
                  </div>
                  <span class="help-inline"><?php echo form_error('captcha_length'); ?></span>
                </div>
              </div>


              <div class="control-group">
                <label class="control-label" for="index_page">Index Page</label>
                <div class="controls">
                  <input type='text' name='index_page' value="<?=$config['index_page'];?>" />
                  <span class="help-inline"><?php echo form_error('index_page'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="registration_allowed">Registration Allowed</label>
                <div class="controls">
                  <select name='registration_allowed' autocomplete="off">
                   <option value='Enabled' <?php if($config['registration_allowed'] == 'Enabled') echo 'selected'; ?>>Enabled</option>
                   <option value='Disabled' <?php if($config['registration_allowed'] == 'Disabled') echo 'selected'; ?>>Disabled</option>
                  </select>
                  <span class="help-inline"><?php echo form_error('registration_allowed'); ?></span>
                </div>
              </div>

	      <div class="control-group">
	        <label class="control-label" for="force_vendor_PGP">Force Vendor PGP</label>
	        <div class='controls'>
		  <select name='force_vendor_PGP' autocomplete="off">
		    <option value='Enabled' <?php if($config['force_vendor_PGP'] == 'Enabled') echo "selected";?>>Enabled</option>
		    <option value='Disabled' <?php if($config['force_vendor_PGP'] == 'Disabled') echo "selected";?>>Disabled</option>
		  </select>
	        </div>
	      </div>

	      <div class="control-group">
		<label class="control-label" for="categories">Categories</label>
		<div class='controls'>
		  <?=anchor('admin/category/add', 'Add Category', 'class="btn"');?>
		  <?=anchor('admin/category/remove', 'Remove Category', 'class="btn"');?>
		</div>
	      </div>


              <div class="form-actions">
                <input type='submit' class="btn btn-primary" value="Update" />
                <?=anchor('admin/siteConfig', 'Cancel', 'class="btn"');?>
              </div>
            </fieldset>
          </form>
        </div>

