        <div class="span9 mainContent" id="send-message">

          <div class="container-fluid">
            <div class="row-fluid">
              <div class="span2"><strong>From</strong></div>
              <div class="span7"><?=anchor('user/'.$fromUser['userHash'], $fromUser['userName']);?></div>
            </div>
            <div class="row-fluid">
              <div class="span2"><strong>Subject</strong></div>
              <div class="span7"><?=$subject;?></div>
            </div>
            <div class="row-fluid"><div class="span2"><strong>Message</strong></div></div>
            <div class="row-fluid">
              <div class="span9"><?php if($isEncrypted){ echo '<pre>'; } ?><?=$message;?><?php if($isEncrypted){ echo '</pre>'; } ?></div>
            </div>
          </div>

          <div class="form-actions">
            <?=anchor('message/reply/'.$messageHash, "Reply", 'class="btn btn-primary"');?>
            <?=anchor('message/delete/'.$messageHash, 'Delete', 'class="btn btn-danger"');?>
          </div>

          <?=anchor('messages','Return to your inbox', array('class'=>'returnLink btn'));?>
        </div>
