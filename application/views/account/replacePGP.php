        <div class="span9 mainContent" id="replacePGP">
          <h2>Replace Public Key</h2>

          <?php echo form_open('account/replacePGP', array('class' => 'form-horizontal')); ?>
            <fieldset>
              <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>

	      <div class="control-group">
                <label class="control-label" for="pubKey"><strong>Current Fingerprint</strong></label>
                <div class="span7"><?=$account['pubKeyFingerprint'];?></div>
              </div>

		<div class="control-group">
                <label class="control-label" for="pubKey">PGP Public Key</label>
                <div class="controls">
                    <textarea class="span10" name='pubKey' rows="10"></textarea><br />
                              <span class="help-inline"><?php echo form_error('pubKey'); ?></span>
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
                <?=anchor('account/replacePGP', 'Cancel', 'class="btn"');?>
              </div>
            </fieldset>
          </form>
        </div>
