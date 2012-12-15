        <div class="span9 mainContent" id="admin-users">
	<?=anchor('admin/regTokens','Registration Tokens','class="btn btn-primary"');?><br /><br />
	<div class="container-fluid">
	<?php
	if($userHash == NULL){
	  foreach($users as $user){ ?>
 	    <div class="row-fluid">    
  	      <div class="span2"><strong><?=anchor('user/'.$user['userHash'],$user['userName']);?></strong></div>
              <div class="span7"></div>
	    </div>	

	    <div class="row-fluid">
              <div class="span4">Role</div>
              <div class="span7"><?=$user['userRole'];?></div>
            </div>

	    <div class="row-fluid">
              <div class="span">	    <?=anchor('admin/user/'.$user['userHash'],'User Information');?></div>
	    </div>

	  <br />
	<?php } 
	} else {?>
 	    <div class="row-fluid">    
  	      <div class="span2"><strong><?=anchor('user/'.$users['userHash'],$users['userName']);?></strong></div>
              <div class="span7"></div>
	    </div>

	    <div class="row-fluid">
              <div class="span4"><strong>Role</strong></div>
              <div class="span7"><?=$users['userRole'];?></div>
            </div>

	    <div class="row-fluid">
              <div class="span4"><strong>Registered</strong></div>
              <div class="span7"><?=$users['timeRegistered'];?></div>
            </div>

	    <div class="row-fluid">
              <div class="span4"><strong>Last Activity</strong></div>
              <div class="span7"><?=$users['last_activity'];?></div>
            </div>
		
	<?php }	?>

	</div>
	</div>

