	<div id="inbox" class="mainContent">
	<h2>Message Inbox</h2>
	<?php if(isset($returnMessage)) echo $returnMessage; ?><br />

	<?=anchor('messages/send','Compose message');?><br /><br />
	<?php
	if (isset($messages)&&($messages!=NULL)) {	
	foreach ($messages as $message): ?>
		<?=anchor('user/'.$message['fromUser']['userHash'], $message['fromUser']['userName']);?> - 
		<?=anchor('message/'.$message['messageHash'], $message['subject']);?> - 
		<?=date('d-m-Y', $message['time']);?><br />
	<?php endforeach; } ?>
	<div class="clear"></div>
	</div>
