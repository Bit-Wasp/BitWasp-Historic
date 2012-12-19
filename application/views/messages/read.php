        <div class="span9 mainContent" id="read-message">
          <h2>View Message</h2>
          <div class="container-fluid">
            <div class="row-fluid">
              <div class="span2"><strong>From</strong></div>
              <div class="span7"><?php echo anchor('user/'.$fromUser['userHash'], $fromUser['userName']);?></div>
            </div>
            <div class="row-fluid">
              <div class="span2"><strong>Subject</strong></div>
              <div class="span7"><?php echo $subject;?></div>
            </div>
            <div class="row-fluid">
              <div class="span2"><strong>Message</strong></div>
              <div class="span7"><?php if($isEncrypted){ echo '<pre>'; } ?><?php echo $message;?><?php if($isEncrypted){ echo '</pre>'; } ?></div>
            </div>
          </div>

          <div class="form-actions">
          <?php echo anchor('message/reply/'.$messageHash, "Reply", 'class="btn btn-primary"');?>
          <?php echo anchor('message/delete/'.$messageHash, 'Delete Message', 'class="btn btn-danger"');?>
          </div>
          <?php if (isset($theadMessages)&&($theadMessages!=NULL)&&(count($theadMessages)!=1)) { ?>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>From</th>
                <th>Subject</th>
                <th>Time</th>
                <th></th>                
              </tr>
            </thead>
	    <?php foreach ($theadMessages as $message):
	    if($message['messageHash']!=$messageHash) { // Don't show current message in the list ?>
            <tr>
		  <td><?php echo anchor('user/'.$message['fromUser']['userHash'], $message['fromUser']['userName']);?></td>
		  <td><?php if(!$message['viewed']){ echo '<span class="messageUnread">'; } ?><?php echo anchor('message/'.$message['messageHash'], $message['subject']);?> <?php if(!$message['viewed']){ echo '</span>'; } ?></td>
		  <td><?php echo date('d-m-Y h:i:s A', $message['time']);?></td>
	          <td>
                  <?php echo anchor('message/'.$message['messageHash'], 'View', 'class="btn btn-mini"');?>
                  <?php if($message['fromUser']['userHash']!=$userHash) {
                  echo anchor('message/reply/'.$message['messageHash'], 'Reply', 'class="btn btn-mini"'); } ?>
		  <!--<?php echo anchor('message/delete/'.$message['messageHash'], 'Delete', 'class="btn btn-danger btn-mini"');?>-->
              </td>
            </tr>
	    <?php } else { ?>
	    <!-- Current Message -->
	    <? } endforeach; ?>
          </table>
          <?php } ?>
          <div class="form-actions">
                <?php echo anchor('messages','Return to your inbox', array('class'=>'returnLink btn'));?>
                <?php echo anchor('messages', 'Delete Thread', 'class="btn btn-danger"');?>
          </div>
        </div>
