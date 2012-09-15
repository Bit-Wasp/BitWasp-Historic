          <div class="offset3 span6">
            <h2>Register</h2>
            <?php echo form_open('users/register', array('class' => 'form-horizontal')); ?>
              <fieldset>
                <?php if(isset($returnMessage)) echo $returnMessage; ?>
                <div class="control-group">
                  <label class="control-label" for="username">Username</label>
                  <div class="controls">
                    <input type='text' name='username' value="<?php echo set_value('username'); ?>" size='12' />
                    <span class="help-inline"><?php echo form_error('username'); ?></span>
                  </div>
                </div> 

                <div class="control-group">
                  <label class="control-label" for="password0">Password</label>
                  <div class="controls">
                    <input type='password' name='password0' value='' size='12' />
                    <span class="help-inline"><?php echo form_error('password0'); ?></span>
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label" for="password1">Password (confirm)</label>
                  <div class="controls">
                    <input type='password' name='password1' value='' size='12' />
                    <span class="help-inline"><?php echo form_error('password1'); ?></span>
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label" for="usertype">Role</label>
                  <div class="controls">
                    <select name='usertype' value='1'>
                      <option value='1'>Buyer</option>
                      <option value='2'>Seller</option>
                    </select>
                    <span class="help-inline"><?php echo form_error('usertype'); ?></span>
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
                  <button type='submit' class="btn btn-primary">Register</button>
                  <?=anchor('users/login', 'Cancel', 'title="Cancel" class="btn"');?>
                </div>
              </fieldset>
            </form>
          </div>
