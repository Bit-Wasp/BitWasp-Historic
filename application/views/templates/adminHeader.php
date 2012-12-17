<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $title ?> | <?php echo $site_name;?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
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
              <li><?php echo anchor('home', 'Home', 'title="Home"');?></li>
              <li><?php echo anchor('items', 'Items', 'title="Items"');?></li>
              <li><?php echo anchor('admin', 'Admin Panel', 'title="Admin Panel"');?></li>
              <li><?php echo anchor('messages', 'Messages ('.$unreadMessages.')', 'title="Messages"');?></li>
              <li><?php echo anchor('account', 'Account', 'title="Account"');?></li>
              <li><?php echo anchor('users/logout', 'Logout', 'title="Logout"');?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row-fluid">
