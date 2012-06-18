
        <div id="login" class="mainContent">
<?php echo form_open('users/login'); ?>

<fieldset>
Your details were incorrect, please try again. <br /><br />
<label for="username">Username</label> <input type='text' name='username' value='<?php echo set_value('username'); ?>' size='10'/> <br />
<label for="password">Password</label>  <input type='password' name='password' value='' size='10'/> <br />


<label for="captcha">Captcha</label> <input name="captcha" type="text" size='10'/><br />

<label for='image'>Image</label> <?=$captcha['image'];?>
<br />

<label for="submit"><input type='submit' value='Login' /></label><br />
</fieldset>
</form>


</div>

