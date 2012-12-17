<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $title ?> | <?php echo $site_name;?></title>
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <?php echo $header_meta; ?>
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?php echo site_url(); ?>"><?php echo $site_name;?></a>
          <div class="nav-collapse collapse">
            <ul class="nav pull-right">
              <li><?php echo anchor('users/login', 'Login', 'title="Login"');?></li>
		<?php if($allow_reg == 'Enabled'){?>
              <li><?php echo anchor('users/register', 'Register', 'title="Register"');?></li>
		<?php } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row-fluid">
