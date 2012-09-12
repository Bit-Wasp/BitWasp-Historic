        <div class="mainContent" id="userPage">
                        <h3><?=$user['userName'] ?></h3>

                        <div id="main">
Date Registered: <?=$user['dispTime'];?><br />
<?=anchor('messages/send/'.$user['userHash'],'Message this user');?>
                        <div class="clear"></div>
                        </div>

<br />
		<div class='reviews'>
			Rating: <?=$reviews['AvgRating'];?><br />
			<?php 
			if(count($reviews['reviews']) > 0){?>
			<table class="orderlist">
			<tr class="orderHeader">
				<td>Rating</td>
				<td>Comments</td>
				<td>Time</td>
			</tr>
			
			<?php foreach($reviews['reviews'] as $review):?>
			<tr>
				<td><?=$review['rating'];?>/5</td>
				<td><?=$review['reviewText'];?></td>
				<td><?=$review['time'];?></td>
			</tr>
			<?php endforeach; ?>
			</table/>
			<?php } else { ?>
			This vendor has no reviews at present.
			<?php } ?>		
                        <div class="clear"></div>
		</div>
<br />



			<?php if(isset($user['publicKey'])) { ?>
			<p>Public key for <?=$user['userName'] ?>:</p>
			<pre id="publicKeyBox"><?=$user['publicKey'] ?></pre>
			<?php } ?>
                        <div class="clear"></div>

	


          </div>



