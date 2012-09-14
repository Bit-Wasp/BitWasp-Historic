<div class='mainContent'>
<?php echo form_open('users/twoStep'); ?>
<?php if(isset($returnMessage)) echo $returnMessage.'<br />'; ?>
Decrypt the following PGP text and enter it here:<br />
<input type='text' name='solution' value='' /><input type='submit' value='Submit' />
<pre><?=$challenge;?></pre>
</form>
</div>
