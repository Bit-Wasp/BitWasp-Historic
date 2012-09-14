<div class='mainContent'>
<?=anchor('admin/editConfig','Edit Configuration');?><br /><br />
<?php if(isset($returnMessage)) echo $returnMessage.'<br />'; ?>
Site Title: <?=$config['site_title'];?><br />
Login Timeout : <?=$config['login_timeout'];?> minutes<br />
Base URL: <?=anchor($config['base_url']);?><br />
Index Page: <?=$config['index_page'];?>
</div>

