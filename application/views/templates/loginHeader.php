
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <title><?php echo $title ?> | Bitwasp :: Anonymous Online Marketplace</title>
        <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>assets/css/style.css" />
	<?=$header_meta; ?>
</head>
<body>

<div id="container">
        <div id="header">
                <h1><a href="<?=site_url(); ?>">Bitwasp :: Anonymous Online Marketplace</a></h1>
                <ul id="nav">
                        <li><?=anchor('users/login', 'Login', 'title="Login"');?></li>
                        <li><?=anchor('users/register', 'Register', 'title="Register"');?></li>
                </ul>
                <div class="clear"></div>
</div>
<div id='main'>
