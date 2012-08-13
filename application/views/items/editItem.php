        <div id="editItem" class="mainContent">
                <?php echo form_open('listings/edit/'.$item['itemHash']); ?>

<fieldset>
<?php echo validation_errors(); ?>

<label for='name'>Name</label>
<input type="text" name="name" value="<?=$item['name'];?>"  size='12'/> <br /> 

<label for='description'>Description</label>
<textarea name='description' height='30' width='100'>
<?=$item['description'];?>
</textarea><br />

<label for='categoryID'>Category</label> 
<select name='categoryID' id='<?=$item['category'];?>'>
	<?php foreach ($categories as $subCat): ?>
		<option value='<?=$subCat['id'];?>' <?php if($subCat['id'] == $item['category']) echo "selected='selected'"; ?> '><?=$subCat['name'];?></option>
	<?php endforeach ?>
</select><br />

<label for='price'>Price</label>
<input type='text' name='price' value='<?=$item['price'];?>' size='12' /><br />

<label for='currency'>Currency</label>
<select name='currency'>
	<?php foreach ($currencies as $currency): ?>
		<option value='<?=$currency['id'];?>'><?=$currency['name'];?> (<?=$currency['symbol'];?>)</option>
	<?php endforeach ?>
</select><br />

<input type='hidden' name='itemHash'  value='<?=$item['itemHash'];?>' />

<br />
<label for='submit'><input type="submit" value="Submit" /></label>
</fieldset>
</form>
</div>

