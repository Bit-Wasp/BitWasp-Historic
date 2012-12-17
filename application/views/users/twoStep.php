          <div class="offset3 span6">
            <h2>2 Factor Authentication</h2>
            <?php echo form_open('users/twoStep', array('class' => 'form-horizontal')); ?>
              <fieldset>
                <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>
                <p>Decrypt the following PGP text and enter it below:</p>
                <pre class="well"><?php echo $challenge;?></pre>

                <div class="control-group">
                  <label class="control-label" for="solution">Token</label>
                  <div class="controls">
                    <input type="text" name='solution' size='12'/>
                    <span class="help-inline"><?php echo form_error('solution'); ?></span>
                  </div>
                </div>

                <div class="form-actions">
                  <button type='submit' class="btn btn-primary">Proceed</button>
                  <?php echo anchor('users/login', 'Cancel', 'title="Cancel" class="btn"');?>
                </div>
              <fieldset>
            </form>
          </div>
