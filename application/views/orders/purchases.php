	<div id="item_view" class="mainContent">
	<h2>Purchases</h2>
	<?php if(isset($returnMessage)) echo $returnMessage."<br />"; ?>

	<?php 
	$countNew = count($newOrders);
	$countSend = count($dispatchOrders);	
	if($countNew > 0){?>
	<a href="#payment">Waiting Payment (<?=$countNew;?>)</a> 
	<?php  }
	if($countSend > 0){
		if($countNew > 0){ echo " | "; }?>
		<a href="#dispatch">For Dispatch (<?=$countSend;?>)</a> 
	<?php } 

	if($countSend == 0 && $countNew == 0){?>
	You have no purchases.
	<?php } ?>


	<?php if(count($newOrders) > 0){ ?>
		<h3>Currently awaiting payment:</h3> 
		<table class="orderlist">
			<tr class="orderHeader">
				<td>Buyer</td>
				<td>Items</td>
				<td>Total Price</td>
				<td>Progress</td>
				<td>Last Update</td>
			</tr>
			<?php foreach($newOrders as $order): ?>
			<tr>
				<td><?=anchor("user/".$order['buyer']['userHash'], $order['buyer']['userName']); ?></td>
				<td>
					<ul><?php foreach($order['items'] as $item):?>
						<li><?=$item['quantity']." x ".$item['name'];?></li>
					<?php endforeach; ?></ul>
				</td>
				<td><?=$order['currencySymbol'].$order['totalPrice'];?></td>
				<td><?=anchor('payment/confirm/'.$order['buyer']['userHash'], 'Click to confirm payment.');?></td>
				<td><?=$order['dispTime'];?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	<?php }	?>
		<div class="clear"></div>
	<?php if(count($dispatchOrders) > 0){ ?>
		<h3>Orders for dispatch:</h3> 		
		<table class="orderlist">
			<tr class="orderHeader">
				<td>Buyer</td>
				<td>Items</td>
				<td>Total Price</td>
				<td>Progress</td>
				<td>Last Updated</td>
			</tr>
			<?php foreach($dispatchOrders as $order): ?>
			<tr>
				<td><?=anchor("user/".$order['buyer']['userHash'], $order['buyer']['userName']); ?></td>
				<td>
					<ul><?php foreach($order['items'] as $item):?>
						<li><?=$item['quantity']." x ".$item['name'];?></li>
					<?php endforeach; ?></ul>
				</td>
				<td><?=$order['currencySymbol'].$order['totalPrice'];?></td>
				<td><?=anchor('dispatch/confirm/'.$order['buyer']['userHash'], 'Click to confirm dispatch.');?></td>
				<td><?=$order['dispTime'];?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	<? } ?>
		<div class="clear"></div>
