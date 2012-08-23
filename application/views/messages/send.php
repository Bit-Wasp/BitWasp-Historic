        <div id="sendMessage" class="mainContent">
	<h2>Create Message</h2>
<?php echo form_open('messages/send', array('name'=>'sendMessageForm'), $hiddenFields); ?>

<fieldset>
<?php if(isset($returnMessage)) echo $returnMessage; ?><br />
<?php echo validation_errors(); ?>
<label for="recipient">Recipient</label> 
<input type="text" name="recipient" value="<?=$to; ?>" size="12" /> <br />

<label for="subject">Subject</label> 
<input type="text" name="subject" value="<? if(isset($subject)){ echo $subject; } ?>" size='12' /> <br />

<label for="message">Message</label>
<textarea name="message">
<?=set_value('message'); ?>
</textarea><br />

<textarea style="display:none;" name="pubkey">
<?=$publickey; ?>
</textarea><br /

<br /><br />
<label for="submit"><input type='submit' value='Send' onclick='messageEncrypt()' /></label><br />
</form>
</fieldset>
</div>
