        <div class="span9 mainContent" id="create_registration_token">
          <h2>Create Registration Token</h2>
          <?php echo form_open('admin/regTokens/create', array('class' => 'form-horizontal')); ?>
              <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>

	      <div class="control-group">
                <label class="control-label" for="newRegistrationToken">New Token?</label>
                <div class="controls">
		  <select name='role'>
		    <option value='1'>Buyer</option>
		    <option value='2'>Vendor</option>
		    <option value='3'>Admin</option>
		  </select>
		  <span class="help-inline"><?php echo form_error('role'); ?></span>
                </div>
              </div>

              <div class="form-actions">
                <input type='submit' class="btn btn-primary" name='newToken' value="Generate" />
  	        <?php echo anchor('admin', 'Cancel', 'class="btn"');?>
	      </div>
            </form>

	      <?php if(count($tokens['Buyer']) > 0) { ?>
            <div class="row-fluid">
              <div class="span2"><strong>Buyer Tokens</strong></div>
              <div id="buyerTokens" class="well">
		<?php	foreach ($tokens['Buyer'] as $token): ?>
			<br /><?php echo 	anchor('admin/regTokens/delete/'.$token['hash'], 'Delete').' | '.anchor('users/register/'.$token['content'],$token['content']);?>
		<?php 	endforeach; ?>
	      </div>
	    </div>
	    <?php } ?>

	      <?php if(count($tokens['Vendor']) > 0) { ?>
            <div class="row-fluid">
              <div class="span2"><strong>Vendor Tokens</strong></div>
              <div id="vendorTokens" class="well">
		<?php	foreach ($tokens['Vendor'] as $token): ?>
			<br /><?php echo 	anchor('admin/regTokens/delete/'.$token['hash'], 'Delete').' | '.anchor('users/register/'.$token['content'],$token['content']);?>
		<?php 	endforeach; ?>
	      </div>
	    </div>
	    <?php } ?>

	      <?php if(count($tokens['Admin']) > 0) { ?>
            <div class="row-fluid">
              <div class="span2"><strong>Admin Tokens</strong></div>
              <div id="adminTokens" class="well">
		<?php	foreach ($tokens['Admin'] as $token): ?>
			<br /><?php echo 	anchor('admin/regTokens/delete/'.$token['hash'], 'Delete').' | '.anchor('users/register/'.$token['content'],$token['content']);?>
		<?php 	endforeach; ?>
	      </div>
	    </div>
	    <?php } ?>

        </div>
