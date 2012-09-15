        <div class="span9 mainContent" id="inbox">
          <h2><?=$title;?></h2>
          <?php if(isset($returnMessage)) { echo '<div class="alert'; if(isset($sentSuccess)){ echo ' alert-success'; } echo '">'.$returnMessage.'</div>'; } ?>	

	        <?php
	        if (isset($messages)&&($messages!=NULL)) { ?>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>From</th>
                <th>Subject</th>
                <th>Time</th>
                <th></th>                
              </tr>
            </thead>
	        <? foreach ($messages as $message): ?>
            <tr<? if(!$message['viewed']){?> class="info"<?}?>>
		          <td><?=anchor('user/'.$message['fromUser']['userHash'], $message['fromUser']['userName']);?></td>
		          <td><?php if(!$message['viewed']){ echo '<span class="messageUnread">'; } ?><?=anchor('message/'.$message['messageHash'], $message['subject']);?> <?php if(!$message['viewed']){ echo '</span>'; } ?></td>
		          <td><?=date('d-m-Y h:i:s A', $message['time']);?></td>
		          <td>
                  <?=anchor('message/'.$message['messageHash'], 'View', 'class="btn btn-mini"');?>
                  <?=anchor('message/reply/'.$message['messageHash'], 'Reply', 'class="btn btn-mini"');?>
		              <?=anchor('message/delete/'.$message['messageHash'], 'Delete', 'class="btn btn-danger btn-mini"');?>
              </td>
		        </tr>
	        <?php endforeach; ?>
          </table>
          <? } ?>

          <div class="form-actions">
	          <?=anchor('messages/send','Compose message', 'class="btn btn-primary"');?>
            <?=anchor('messages/#','Mark all read', 'class="btn"');?>
	          <?php	if(isset($messages)) { echo anchor('message/delete/all', 'Delete All!', 'class="btn btn-danger"'); }?>
          </div>
        </div>
