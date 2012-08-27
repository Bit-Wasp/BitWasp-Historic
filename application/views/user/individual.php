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

		<div class='reviews'>
			<?php 
			if(count($reviews) > 0){?>
			<table class="orderlist">
			<tr class="orderHeader">
				<td>Rating</td>
				<td>Comments</td>
				<td>Time</td>
			</tr>
			
			<?php foreach($reviews as $review):?>
			<tr>
				<td><?=$review['rating'];?>/5</td>
				<td><?=$review['reviewText'];?></td>
				<td><?=$review['time'];?></td>
			</tr>
			<?php endforeach; ?>
			</table/>
			<?php } else { ?>
			This item has no reviews at present.
			<?php } ?>		


		</div>
	


                </div>



