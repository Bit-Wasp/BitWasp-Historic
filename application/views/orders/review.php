<div class='mainContent'>

<?php echo form_open('orders/review/'.$order['id']); ?>

<fieldset>
<?php if(isset($returnMessage)) echo $returnMessage; ?><br />
<?php echo validation_errors(); ?>
<label for="vendor">Vendor</label> <?=$order['seller']['userName'];?> <br /><br />
<label for="orderID">Order Number</label> #<?=$order['id'];?><br /><br />
<label for="price">Total Price</label> <?=$order['currencySymbol'].$order['totalPrice'];?><br /><br />
<label for="items">Items</label> 
<?php foreach($order['items'] as $item):?>
	<li><?=$item['quantity']." x ".$item['name'];?><br />
<?php endforeach; ?>
<br />
<label for="rating">Rating</label> 
	<select name='rating'>
		<option value='notset'>Rating</option>
		<option value='1'>1</option>
		<option value='2'>2</option>
		<option value='3'>3</option>
		<option value='4'>4</option>
		<option value='5'>5</option>
	</select>
<br /><br />
<label for="comment">Comments</label>	<textarea name='comment'></textarea>
<br /><br />
<label for="submit"><input type='submit' value='Submit Review' /></label><br />
</form>
</fieldset>

</form>
</div>

