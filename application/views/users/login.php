        <div id="login" class="mainContent">
<?php echo form_open('users/login'); ?>

<fieldset>
<?php if(isset($returnMessage)) echo $returnMessage; ?><br />
<?php echo validation_errors(); ?>
<label for="username">Username</label> <input type='text' name='username' value='<?php echo set_value('username'); ?>' size='12' /> <br />
<label for="password">Password</label> <input type='password' name='password' value='' size='12' /> <br />

<label for="captcha">Captcha</label> <input type="text" name='captcha' size='12'/><br />

<label for='image'>Image</label> <?=$captcha['image'];?>

<br /><br />
<label for="submit"><input type='submit' value='Login' /></label><br />
</form>
</fieldset>
</div>
