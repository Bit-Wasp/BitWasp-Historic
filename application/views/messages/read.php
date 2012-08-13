        <div id="readMessage" class="mainContent">
<fieldset>
<table>
<tr><td><label for='from'>From</label></td><td><?=anchor('user/'.$fromUser['userHash'], $fromUser['userName']);?></td></tr>
<tr><td><label for="subject">Subject</label></td><td><?=$subject;?></td></tr>
<tr><td valign="top">
<label for="message">Message</label></td><td>
<?php if($isEncrypted){ echo '<pre>'; } ?>
<?=$message;?>
<?php if($isEncrypted){ echo '</pre>'; } ?>
</td></tr>
</table>
</fieldset>

<?php echo form_open('messages/send'); ?>

<?php if(isset($returnMessage)) echo $returnMessage; ?><br />

<input type="hidden" name="recipient" value="<?=$fromUser['userName'];?>"  /> <br />
<input type="hidden" name="subject" value="<?=$subject;?>"  /> <br />

<label for="message">Message</label>
<textarea name="message">
</textarea><br />

<br /><br />
<label for="submit"><input type='submit' value='Send' /></label><br />
</form>

</div>
