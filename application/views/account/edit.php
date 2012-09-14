<div class='mainContent'><br />
<?php echo form_open('account/update'); ?>

<fieldset>
<?php if(isset($returnMessage)){ echo $returnMessage.'<br />'; }?>

<label for='pubKey'>PGP Public Key</label>
<?php if($account['pubKey'] == 'No Public Key found.'){?>
<textarea name='pubKey'><?=$account['pubKey'];?></textarea><br />
<?php } else { ?>
<?=$account['pubKeyFingerprint'];?><br />
<?php } ?><br />

<label for='twoStep'>Two-Step Login</label>
<?php if($account['pubKey'] == 'No Public Key found.'){?>
Add a PGP public key to enable this feature.<br />
<?php } else { 
		if($account['twoStepAuth'] === '1'){?>
<input type='radio' name='twoStep' value='0' /> Disabled
<input type='radio' name='twoStep' value='1' checked/> Enabled
	<?php } else { ?>
	<input type='radio' name='twoStep' value='0' checked/> Disabled
	<input type='radio' name='twoStep' value='1' /> Enabled
	<?php } 
} ?><br />

<label for='password0'>New Password</label><input type='password' name='password0' value='' /><br />
<label for='password1'>New Password (confirm)</label><input type='password' name='password1' value='' /><Br /><Br />
<br />
<hr>
To make any changes to your account, you must enter your password:<br />
<label for='passwordConfirm'>Password:</label><input type='password' name='passwordConfirm' value='' /><Br />
<label for="submit"><input type='submit' value='Update' /></label><br />
</fieldset>

</form>
</div>
