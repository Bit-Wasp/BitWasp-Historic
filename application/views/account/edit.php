        <div class="span9 mainContent" id="edit-account">
          <h2>Edit Account</h2>

          <?php echo form_open('account/update', array('class' => 'form-horizontal')); ?>
            <fieldset>
              <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>

              <div class="control-group">
                <label class="control-label" for='profileMessage'>Profile Message</label>
                <div class="controls">
                  <textarea name='profileMessage' class="span10"><?php echo $account['profileMessage'];?></textarea>
                  <span class="help-inline"><?php echo form_error('profileMessage'); ?></span>
                </div>
              </div>
              <br />

              <div class="control-group">
                <label class="control-label" for="pubKey">PGP Public Key</label>
                <div class="controls">
                  <?php if($account['pubKey'] == 'No Public Key found.'){?>
                    <textarea class="span10" name='pubKey' rows="10"><?php echo $account['pubKey'];?></textarea><br />
                  <?php } else { ?>
                    <?php echo $account['displayFingerprint'];?>
                  <?php } ?>
                  <span class="help-inline"><?php echo form_error('pubKey'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="twoStep">Two-Step Login</label>
                <div class="controls">
                  <?php if($account['pubKey'] == 'No Public Key found.'){?>
                    Add a PGP public key first to enable this feature.<br />
                  <?php } else { ?>
		                <?php if($account['twoStepAuth'] === '1'){?>
                      <label class="radio inline">
                        <input type='radio' name='twoStep' value='0' /> Disabled
                      </label>
                      <label class="radio inline">
                        <input type='radio' name='twoStep' value='1' checked/> Enabled
                      </label>
                    <?php } else { ?>
                      <label class="radio inline">
	                      <input type='radio' name='twoStep' value='0' checked/> Disabled
                      </label>
                      <label class="radio inline">
	                      <input type='radio' name='twoStep' value='1' /> Enabled
                      </label>
	                  <?php } ?>
                  <? } ?>
                </div>
              </div>


              <div class="control-group">
                <label class="control-label" for="forcePGPmessage">Force PGP Messages</label>
                <div class="controls">
                  <?php if($account['pubKey'] == 'No Public Key found.'){?>
                    Add a PGP public key first to enable this feature.<br />
                  <?php } else { ?>
		                <?php if($account['forcePGPmessage'] === '1'){?>
                      <label class="radio inline">
                        <input type='radio' name='forcePGPmessage' value='0' /> Disabled
                      </label>
                      <label class="radio inline">
                        <input type='radio' name='forcePGPmessage' value='1' checked/> Enabled
                      </label>
                    <?php } else { ?>
                      <label class="radio inline">
	                      <input type='radio' name='forcePGPmessage' value='0' checked/> Disabled
                      </label>
                      <label class="radio inline">
	                      <input type='radio' name='forcePGPmessage' value='1' /> Enabled
                      </label>
	                  <?php } ?>
                  <? } ?>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="showActivity">Show latest activity?</label>
                <div class="controls">
                    <?php if($account['showActivity'] === '1'){?>
                      <label class="radio inline">
                        <input type='radio' name='showActivity' value='0' /> Disabled
                      </label>
                      <label class="radio inline">
                        <input type='radio' name='showActivity' value='1' checked/> Enabled
                      </label>
                    <?php } else { ?>
                      <label class="radio inline">
	                      <input type='radio' name='showActivity' value='0' checked/> Disabled
                      </label>
                      <label class="radio inline">
	                      <input type='radio' name='showActivity' value='1' /> Enabled
                      </label>
	            <?php } ?>
                </div>
              </div>

					<div class='control-group'>
						 <label class='control-label' for='items_per_page'>Items Per Page</label>
						 <div class='controls'>
							<?php
							$unit = 25;
							for($i = 1; $i < 5; $i++){?>
							<label class="radio inline">
								<input type='radio' name='items_per_page' value='<?php echo $unit*$i;?>' <?php if($account['items_per_page']==($unit*$i)) echo "CHECKED";?> /> <?php echo $unit*$i;?>
							</label>
							<?php } ?>
							<span class='help-inline'><?php echo form_error('items_per_page'); ?></span>
				  		</div>
					</div>

              <div class="control-group">
                <label class="control-label" for="password0">New Password</label>
                <div class="controls">
                  <input type='password' name='password0' value='' />
                  <span class="help-inline"><?php echo form_error('password0'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="password1">New Password (confirm)</label>
                <div class="controls">
                  <input type='password' name='password1' value='' />
                  <span class="help-inline"><?php echo form_error('password1'); ?></span>
                </div>
              </div>

              <hr>
              <p><strong>To make any changes to your account, you must enter your password:</strong></p>
              <div class="control-group">
                <label class="control-label" for='passwordConfirm'>Password:</label>
                <div class="controls">
                  <input type='password' name='passwordConfirm' value='' />
                  <span class="help-inline"><?php echo form_error('password'); ?></span>
                </div>
              </div>

              <div class="form-actions">
                <input type='submit' class="btn btn-primary" value="Update" />
                <?php echo anchor('account', 'Cancel', 'class="btn"');?>
              </div>
            </fieldset>
          </form>
        </div>
