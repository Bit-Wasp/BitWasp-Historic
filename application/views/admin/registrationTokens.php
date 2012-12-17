        <div class="span9 mainContent" id="create_registration_token">
          <h2>Create Registration Token</h2>
          <?php echo form_open('admin/regTokens/create', array('class' => 'form-horizontal')); ?>
              <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>

                New Token? <input type='submit' class="btn btn-primary" name='newToken' value="Generate" /><br /><br />
<pre>
		<?php if(count($tokens) > 0) { 
			foreach ($tokens as $token): ?>
			<br /><?php echo 	anchor('users/register/'.$token['content'],$token['content']).'  '.
					anchor('admin/regTokens/delete/'.$token['hash'], 'Delete'); ?>
		<?php 	endforeach; } ?>
</pre>
          </form>
        </div>
