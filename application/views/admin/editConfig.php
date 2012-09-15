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
                    <input type="text" name="login_timeout" value="<?=$config['login_timeout'];?>"><span class="add-on">minutes</span>
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
                <label class="control-label" for="index_page">Index Page</label>
                <div class="controls">
                  <input type='text' name='index_page' value="<?=$config['index_page'];?>" />
                  <span class="help-inline"><?php echo form_error('index_page'); ?></span>
                </div>
              </div>

              <div class="form-actions">
                <input type='submit' class="btn btn-primary" value="Update" />
                <?=anchor('admin/siteConfig', 'Cancel', 'class="btn"');?>
              </div>
            </fieldset>
          </form>
        </div>

