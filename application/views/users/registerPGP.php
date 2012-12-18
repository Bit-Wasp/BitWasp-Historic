          <div class="offset3 span6">
            <h2>Upload Public Key</h2>
            <?php echo form_open('users/registerPGP', array('class' => 'form-horizontal')); ?>
              <fieldset>
                <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>
		<p>For security reasons, you must upload your PGP public key to continue.</p>
		<textarea class="span12" name='pubKey' rows="10"></textarea><br />

                <div class="form-actions">
                  <button type='submit' class="btn btn-primary">Proceed</button>
                  <?php echo anchor('users/registerPGP', 'Cancel', 'title="Cancel" class="btn"');?>
                </div>
              <fieldset>
            </form>
          </div>
