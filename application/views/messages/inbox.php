	<div id="inbox" class="mainContent">
	<h2><?=$title;?></h2>
	<?php if(isset($returnMessage)) echo $returnMessage; ?><br />

	<?=anchor('messages/send','Compose message');?><br /><br />
	<?php
	if (isset($messages)&&($messages!=NULL)) {	
	foreach ($messages as $message): ?>
		<?=anchor('user/'.$message['fromUser']['userHash'], $message['fromUser']['userName']);?> - 
		<?php if(!$message['viewed']){ echo '<span class="messageUnread">'; } ?><?=anchor('message/'.$message['messageHash'], $message['subject']);?> <?php if(!$message['viewed']){ echo '</span>'; } ?> - 
		<?=date('d-m-Y h:i:s A', $message['time']);?> -
		<?=anchor('message/reply/'.$message['messageHash'], 'Reply');?> -
		<?=anchor('message/delete/'.$message['messageHash'], 'Delete');?>
		<br />
	<?php endforeach; } ?><br />
	<?=anchor('message/delete/all', 'Delete All!');?>
	<div class="clear"></div>
	</div>
