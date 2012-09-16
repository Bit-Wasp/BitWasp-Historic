<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $title ?> | <?=$site_name;?></title>
    <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>assets/css/bootstrap.min.css">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
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
          <a class="brand" href="<?=site_url(); ?>"><?=$site_name;?></a>
          <div class="nav-collapse collapse">
            <ul class="nav pull-right">
              <li><?=anchor('home', 'Home', 'title="Home"');?></li>
              <li><?=anchor('items', 'Items', 'title="Items"');?></li>
              <li><?=anchor('orders', 'Orders', 'title="My Orders"');?></li>
              <li><?=anchor('messages', 'Messages ('.$unreadMessages.')', 'title="Messages"');?></li>
              <li><?=anchor('account', 'Account', 'title="My Account"');?></li>
              <li><?=anchor('users/logout', 'Logout', 'title="Logout"');?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row-fluid">
