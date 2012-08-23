        <div class="mainContent" id="userPage">
                        <h3><?=$user['userName'] ?></h3>

                        <div id="main">
Date Registered: <?php echo date('j / F / Y ',$user['timeRegistered']); ?><br />
Rating: <?=$user['rating'] ?><br />
<?=anchor('messages/send/'.$user['userHash'],'Message this user');?>
                        </div>

			<?php if(isset($user['publicKey'])) { ?>
			<p>Public key for <?=$user['userName'] ?>:</p>
			<pre id="publicKeyBox"><?=$user['publicKey'] ?></pre>
			<?php } ?>
                        <div class="clear"></div>

                </div>



