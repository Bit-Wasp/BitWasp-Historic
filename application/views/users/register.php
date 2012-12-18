          <div class="offset3 span6">
            <h2>Register</h2>
            <?php 
	    $registerPage = 'users/register';
   	    if($token !== NULL)
		$registerPage .= "/$token";
	    echo form_open($registerPage, array('class' => 'form-horizontal')); ?>

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

		<?php
		if($tokenRole !== NULL){?>
	    <input type='hidden' name='usertype' value='<?php echo $tokenRole['int'];?>' />
	    <div class="control-group">
              <label class="control-label" for="usertype">Role</label>
	      <div class="controls">
		
		<?php echo $tokenRole['str'];?>
	        <?php if($force_vendor_PGP == 'Enabled' && $tokenRole == 'Vendor'){ ?>
	        <span class="span8">If you are registering as a vendor, it is required you upload a PGP public key. Please have one ready on your first login.</span>
	        <?php } ?>
                <span class="help-inline"><?php echo form_error('usertype'); ?><br />
	      </div>
	    </div>
	      <?php } else { ?>

            <div class="control-group">
              <label class="control-label" for="usertype">Role</label>
              <div class="controls">
                <select name='usertype' value='1'>
                  <option value='1'>Buyer</option>
                  <option value='2'>Seller</option>
                </select>
		<?php if($force_vendor_PGP == 'Enabled'){ ?>
		<span class="span7">If you are registering as a vendor, it is required to upload a PGP public key. Please have one ready on your first login.</span>
		<?php } ?>
                <span class="help-inline"><?php echo form_error('usertype'); ?></span>
              </div>
            </div>
		<?php } ?>

                <!-- Captcha -->
                <div class="control-group">
                  <label class="control-label" for="captcha">Captcha</label>
                  <div class="controls">
                    <div class="captcha-img"><?php echo $captcha['image'];?></div>
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
                  <?php echo anchor('users/login', 'Cancel', 'title="Cancel" class="btn"');?>
                </div>
              </fieldset>
            </form>
          </div>
