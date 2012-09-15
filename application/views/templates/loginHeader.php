<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $title ?> | Bitwasp :: Anonymous Online Marketplace</title>
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>assets/css/bootstrap-responsive.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>assets/css/custom.css">
    <?=$header_meta; ?>
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
          <a class="brand" href="<?=site_url(); ?>">Bitwasp :: Anonymous Online Marketplace</a>
          <div class="nav-collapse collapse">
            <ul class="nav pull-right">
              <li><?=anchor('users/login', 'Login', 'title="Login"');?></li>
              <li><?=anchor('users/register', 'Register', 'title="Register"');?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row-fluid">
