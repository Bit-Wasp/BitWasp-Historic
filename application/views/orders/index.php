<div class='mainContent'>
<h2>Orders</h2>
<p><?php if(isset($returnMessage)) echo $returnMessage; ?></p>
<?php  
if(count($orders) > 0){?>
	Review your current orders:
	<table class="orderlist">
		<tr class="orderHeader">
			<td>Seller</td>
			<td>Items</td>
			<td>Price</td>
			<td>Progress</td>
		</tr>
		<?php foreach($orders as $order): ?>
		<tr>
			<td><?=anchor('user/'.$order['seller']['userHash'], $order['seller']['userName']);?></td>
			<td><ul><?php foreach($order['items'] as $item): ?>
				<li><?=$item['quantity'];?> x <?=anchor('item/'.$item['itemHash'], $item['name']);?></li>
			<?php endforeach; ?></ul>
			<td><?=$order['currencySymbol'].$order['totalPrice'];?></td>
			<td><?=$order['progress']?></td>
		</tr>
		<?php endforeach; ?>
	</table>
<? } else { ?>
You have no orders at present.<br />
<?php } ?>

</div>
