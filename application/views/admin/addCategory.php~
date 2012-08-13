<div class='mainContent'>
Complete the form to add a new category.

<?php echo form_open('admin/category/add'); ?>

<fieldset>
<?php if(isset($returnMessage)) echo $returnMessage; ?>
<?php echo validation_errors(); ?>
<label for="name">Name</label> <input type='text' name='name' value='<?php echo set_value('name'); ?>' size='12' /> <br />

<label for='parent'>Parent Category</label> 
<select name='parentID'>
		<option value='0'>Root Category</option>
	<?php foreach ($subCats as $subCat): ?>
		<option value='<?=$subCat['id'];?>'><?=$subCat['name'];?></option>
	<?php endforeach ?>
</select><br />
<label for='description'>Description</label>
<textarea name='description' height='30' width='100'>
</textarea>
<br /><br />
<label for="submit"><input type='submit' value='Submit' /></label><br />
</form>
</fieldset>



</div>
