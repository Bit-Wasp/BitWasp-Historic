<div class='mainContent'>
<?php if(isset($returnMessage)) echo $returnMessage; ?><br />

<?php  
if(count($orders) > 0){
	foreach($orders as $order){
		echo "Seller: " . anchor('user/'.$order['seller']['userHash'], $order['seller']['userName']) . "<br />";
		foreach($order['items'] as $item){
			echo "<li>{$item['quantity']} x " . anchor('item/'.$item['itemHash'], $item['name']) . "<br />";
		}
		echo "Total Price: ".$order['currencySymbol'].$order['totalPrice']."<br />";
		echo "Progress: Step ".$order['step']."<br />";
		
		echo anchor('order/place/'.$order['seller']['userHash'], 'Place Order')."<br /><br />";
	}
} else { ?>
You have no orders at present.<br />
<?php } ?>

</div>
