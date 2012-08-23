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
<tr><td><?=anchor('message/reply/'.$messageHash, "Reply");?> <?=anchor('message/delete/'.$messageHash, 'Delete');?></td><td></td></tr>
</table>
</fieldset>

<?=anchor('messages','Return to your inbox', array('class'=>'returnLink'));?>
</div>
