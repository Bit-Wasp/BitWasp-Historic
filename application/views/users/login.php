        <div class="row-fluid">
          <div class="offset3 span6">
            <h2>Login</h2>
            <?php echo form_open('users/login', array('class' => 'form-horizontal')); ?>
            <fieldset>
              <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>
              <div class="control-group">
                <label class="control-label" for="username">Username</label>
                <div class="controls">
                  <input type='text' name='username' value="<?php echo set_value('username'); ?>" size='12' />
                  <span class="help-inline"><?php echo form_error('username'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="password">Password</label>
                <div class="controls">
                  <input type='password' name='password' value='' size='12' />
                  <span class="help-inline"><?php echo form_error('password'); ?></span>
                </div>
              </div>

             <!-- Captcha -->
             <div class="control-group">
                <label class="control-label" for="captcha">Captcha</label>
                <div class="controls">
                  <div class="captcha-img"><?=$captcha['image'];?></div>
                </div>
              </div>
              <div class="control-group">
                <div class="controls">
                  <input type="text" name='captcha' size='12'/>
                  <span class="help-inline"><?php echo form_error('captcha'); ?></span>
                </div>
              </div>
              <!-- /Captcha -->

              <div class="form-actions">
                <button type='submit' class="btn btn-primary">Login</button>
                <?=anchor('users/register', 'Register?', 'title="Register" class="btn"');?>
              </div>
            </fieldset>
          </form>
        </div>
      </div>
