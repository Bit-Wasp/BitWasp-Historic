        <div class="span9 mainContent" id="admin-panel">
          <h2>Admin Panel</h2>
          <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?> 
          <p>Not much here yet!</p>

          <div class="form-actions">
            <?=anchor('admin/siteConfig', 'Site Configuration', 'class="btn btn-primary"');?>
            <?=anchor('admin/category/add', 'Add Category', 'class="btn"');?>
            <?=anchor('admin/category/remove', 'Remove Category', 'class="btn"');?>
          </div>
        </div>
