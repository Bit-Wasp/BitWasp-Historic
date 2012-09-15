        <div class="span9 mainContent" id="add_Listing_Image">
          <h2>Add Item Images</h2>
          <?php echo form_open_multipart('listings/imageUpload/'.$item['itemHash'], array('class' => 'form-horizontal')); ?>
            <fieldset>
              <?php if(isset($returnMessage)) echo '<div class="alert'; if(isset($success)){echo ' alert-success';} echo '">' . $returnMessage . '</div>'; ?>

              <div class="control-group">
                <label class="control-label" for="name">Item</label>
                <div class="controls">
                  <p><?=$item['name'];?></p>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="userfile">Image File</label>
                <div class="controls">
                  <input type='file' name='userfile' />
                  <span class="help-inline"><?php echo form_error('userfile'); ?></span>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="mainPhoto">Main Photo?</label>
                <div class="controls">
                  <input type='checkbox' name='mainPhoto' value='1' />
                  <span class="help-inline"><?php echo form_error('mainPhoto'); ?></span>
                </div>
              </div>

 	            <div class="form-actions">
                <input type="submit" value="Create" class="btn btn-primary" />
                <?=anchor("listings","Cancel", 'class="btn"'); ?>
              </div>
            </fieldset>
          </form>

          <ul id="image_listing" class="thumbnails">
            <?php foreach ($images as $image): ?>
            <li class="span2 image_box">
              <div class="thumbnail">
		            <img class="productImg" src="data:image/jpeg;base64,<?=$image['encoded'];?>" title="<?=$item['name']; ?>" width="<?=$image['width'];?>" />
                <div class="caption">
                  <?=anchor('listings/mainImage/'.$image['imageHash'],'Main', 'class="btn btn-mini"');?>
                  <?=anchor('listings/imageRemove/'.$image['imageHash'], "<i class='icon-trash icon-white'></i> Delete", 'class="btn btn-danger btn-mini"');?>
                </div>
              </div>
            </li>
			      <?php endforeach ?>
		      </ul>

        </div>
