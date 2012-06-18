<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <title><?php echo $title ?> | Bitwasp :: Anonymous Online Marketplace</title>
         <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>assets/style.css" />
</head>
<body>

<div id="container">
        <div id="header">
                <h1><a href="<?=site_url(); ?>">Bitwasp :: Anonymous Online Marketplace</a></h1>
                <ul id="nav">
                        <li><?=anchor('products', 'Home', 'title="View Products"');?></li>
                        <li><?=anchor('admin', 'Admin Panel', 'title="My Orders"');?></li>
                        <li><?=anchor('account', 'Account', 'title="My Account"');?></li>
                        <li><?=anchor('users/logout', 'Logout', 'title="Logout"');?></li>
                </ul>
                <div class="clear"></div>
</div>
<div id='main'>
