        <div class="span9 mainContent" id="admin-panel">
          <h2>Admin Configuration</h2>
          <?php if(isset($returnMessage)) echo '<div class="alert">' . $returnMessage . '</div>'; ?>

          <div class="container-fluid">
            <div class="row-fluid">
              <div class="span2"><strong>Site Title</strong></div>
              <div class="span7"><?=$config['site_title'];?></div>
            </div>

            <div class="row-fluid">
              <div class="span2"><strong>Login Timeout</strong></div>
              <div class="span7"><?=$config['login_timeout'];?></div>
            </div>

            <div class="row-fluid">
              <div class="span2"><strong>Base URL</strong></div>
              <div class="span7"><?=anchor($config['base_url']);?></div>
            </div>

            <div class="row-fluid">
              <div class="span2"><strong>Index Page</strong></div>
              <div class="span7"><?=$config['index_page'];?></div>
            </div>
          </div>

          <div class="form-actions">
            <?=anchor('admin/editConfig','Edit Configuration', 'class="btn btn-primary"');?>
          </div>
        </div>

