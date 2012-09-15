        <div class="span9 mainContent" id="edit-account">
          <h2>Edit Account</h2>

          <?php echo form_open('account/update', array('class' => 'form-horizontal')); ?>
            <fieldset>
              <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>
              <div class="control-group">
                <label class="control-label" for="pubKey">PGP Public Key</label>
                <div class="controls">
                  <?php if($account['pubKey'] == 'No Public Key found.'){?>
                    <textarea name='pubKey'><?=$account['pubKey'];?></textarea><br />
                  <?php } else { ?>
                    <?=$account['displayFingerprint'];?>
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

              <div class="control-group">
                <label class="control-label" for='profileMessage'>Profile Message</label>
                <div class="controls">
                  <textarea name='profileMessage' cols='50'><?=$account['profileMessage'];?></textarea>
                  <span class="help-inline"><?php echo form_error('profileMessage'); ?></span>
                </div>
              </div>

              <hr>
              <p>To make any changes to your account, you must enter your password:</p>
              <div class="control-group">
                <label class="control-label" for='passwordConfirm'>Password:</label>
                <div class="controls">
                  <input type='password' name='passwordConfirm' value='' />
                  <span class="help-inline"><?php echo form_error('password'); ?></span>
                </div>
              </div>

              <div class="form-actions">
                <input type='submit' class="btn btn-primary" value="Update" />
                <?=anchor('account', 'Cancel', 'class="btn"');?>
              </div>
            </fieldset>
          </form>
        </div>
