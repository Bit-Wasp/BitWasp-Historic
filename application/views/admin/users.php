        <div class="span9 mainContent" id="admin-users">
          <h2>Create Registration Token</h2>
	<div class="container-fluid">
	<?php echo anchor('admin/regTokens','Registration Tokens','class="btn btn-primary"');?>
	<?php echo anchor('admin','Cancel','class="btn"');?><br /><br />

	<?php
	if($userHash == NULL){
	  foreach($users as $user){ ?>
 	    <div class="row-fluid">    
  	      <div class="span2"><strong><?php echo anchor('user/'.$user['userHash'],$user['userName']);?></strong></div>
              <div class="span7"></div>
	    </div>	

	    <div class="row-fluid">
              <div class="span4">Role</div>
              <div class="span7"><?php echo $user['userRole'];?></div>
            </div>

	    <div class="row-fluid">
              <div class="span">	    <?php echo anchor('admin/user/'.$user['userHash'],'User Information');?></div>
	    </div>

	  <br />
	<?php } 
	} else {?>
 	    <div class="row-fluid">    
  	      <div class="span2"><strong><?php echo anchor('user/'.$users['userHash'],$users['userName']);?></strong></div>
              <div class="span7"></div>
	    </div>

	    <div class="row-fluid">
              <div class="span4"><strong>Role</strong></div>
              <div class="span7"><?php echo $users['userRole'];?></div>
            </div>

	    <div class="row-fluid">
              <div class="span4"><strong>Registered</strong></div>
              <div class="span7"><?php echo $users['timeRegistered'];?></div>
            </div>

	    <div class="row-fluid">
              <div class="span4"><strong>Last Activity</strong></div>
              <div class="span7"><?php echo $users['last_activity'];?></div>
            </div>
		
	<?php }	?>

	</div>
	</div>

