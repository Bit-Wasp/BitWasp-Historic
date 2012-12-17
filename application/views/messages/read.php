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
            <?php echo anchor('message/delete/'.$messageHash, 'Delete', 'class="btn btn-danger"');?>
          </div>

          <?php echo anchor('messages','Return to your inbox', array('class'=>'returnLink btn'));?>
        </div>
