<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <title><?=$title;?> | <?=$site_name;?></title>
        <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>assets/style.css" />
	<?=$header_meta; ?>
</head>
<body>

<div id="container">
        <div id="header">
                <h1><a href="<?=site_url(); ?>"><?=$site_name;?></a></h1>
                <ul id="nav">
                        <li><?=anchor('home', 'Home', 'title="Home"');?></li>
                        <li><?=anchor('items', 'Items', 'title="Items"');?></li>
                        <li><?=anchor('admin', 'Admin Panel', 'title="Admin Panel"');?></li>
                        <li><?=anchor('messages', 'Messages ('.$unreadMessages.')', 'title="Messages"');?></li>
                        <li><?=anchor('account', 'Account', 'title="Account"');?></li>
                        <li><?=anchor('users/logout', 'Logout', 'title="Logout"');?></li>
                </ul>
                <div class="clear"></div>
</div>
<div id='main'>
