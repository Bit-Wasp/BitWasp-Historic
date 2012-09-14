<div class='mainContent'>
<?php if(isset($returnMessage)) echo $returnMessage.'<br />'; ?>

<?php echo form_open('admin/updateConfig'); ?>

<fieldset>
<label for='site_title'>Site title</label>
<input type='text' name='site_title' value='<?=$config['site_title'];?>' /><br />

<label for='login_timeout'>Login Timeout</label>
<input type='text' name='login_timeout' value='<?=$config['login_timeout'];?>' size='1' /> minutes<br />

<label for='base_url'>Base URL</label>
<input type='text' name='base_url' value='<?=$config['base_url'];?>' /><br />

<label for='index_page'>Index Page</label>
<input type='text' name='index_page' value='<?=$config['index_page'];?>' /><br />

<label for='submit'><input type='submit' value='Update' /></label>
</fieldset>
</form>
</div>

