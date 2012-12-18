<?php
ini_set('display_errors',1); 
 error_reporting(E_ALL);
session_start();
define('BASEPATH',dirname(__FILE__));
if(isset($_GET['step'])){
	if($_GET['step'] == '2'){
		include('application/config/database.php');
		$siteCfg = '{"site_title":"'.$_POST['site_title'].'","login_timeout":"'.$_POST['site_timeout'].'","base_url":"'.$_POST['site_url'].'","index_page":"'.$_POST['site_index'].'","default_items_per_page":"25","registration_allowed":"Enabled","force_vendor_PGP":"Disabled","captcha_length":"'.$_POST['captcha_length'].'"}';
		
		$conn = mysql_connect('localhost',$_SESSION['sql_user'],$_SESSION['sql_pw']);
		if(!$conn){
			echo "Unable to connect to MySQL database.<br />";
		}

		$db = mysql_select_db($_SESSION['sql_db'],$conn);
		if(!$db){
			echo "Unable to select database.<br />";
		}

		$insert = mysql_query("UPDATE `".$_SESSION['sql_prefix']."config` SET jsonConfig=\"".mysql_real_escape_string($siteCfg)."\" WHERE id=1",$conn);
		if(!$insert){
			echo "Unable to set up your configuration.<br />";echo mysql_error();
		} else {
			echo "Site configuration set up. Be sure to chmod ./assets/images and ./assets/images/captchas to writable before use. If you wish to use mod_rewrite, be sure to update the folder in .htaccess<br />";
		}


	} else if($_GET['step'] == '1'){
		$_SESSION['sql_user'] = $_POST['sql_user'];
		$_SESSION['sql_pw'] = $_POST['sql_pw'];
		$_SESSION['sql_db'] = $_POST['sql_db'];
		$_SESSION['sql_prefix'] = $_POST['sql_prefix'];

		$databaseCfg="
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

\$active_group = 'default';
\$active_record = TRUE;
\$db['default']['hostname'] = 'localhost';
\$db['default']['username'] = '".$_POST['sql_user']."';
\$db['default']['password'] = '".$_POST['sql_pw']."';
\$db['default']['database'] = '".$_POST['sql_db']."';
\$db['default']['dbdriver'] = 'mysql';
\$db['default']['dbprefix'] = '".$_POST['sql_prefix']."';
\$db['default']['pconnect'] = TRUE;
\$db['default']['db_debug'] = TRUE;
\$db['default']['cache_on'] = FALSE;
\$db['default']['cachedir'] = '';
\$db['default']['char_set'] = 'utf8';
\$db['default']['dbcollat'] = 'utf8_general_ci';
\$db['default']['swap_pre'] = '';
\$db['default']['autoinit'] = TRUE;
\$db['default']['stricton'] = FALSE;
";
		$databaseFD = fopen("application/config/database.php","w");
		if($databaseFD){
			fwrite($databaseFD, $databaseCfg);
			fclose($databaseFD);
		} else {
			echo "Unable to write database.php!<br />Save this file manually by pasting the code below:<br />
<pre>$databaseCfg</pre>";

		}


		$conn = mysql_connect('localhost',$_SESSION['sql_user'],$_SESSION['sql_pw']);
		if(!$conn){
			echo "Unable to connect to MySQL database.<br />";
		}

		$db = mysql_select_db($_SESSION['sql_db'],$conn);
		if(!$db){
			echo "Unable to select database.<br />";
		}

		$file = fopen('schema.sql', 'r');
		print '<pre>';
		print mysql_error();
		$temp = '';
		$count = 0;
		
		while($line = fgets($file)) {
		  if ((substr($line, 0, 2) != '--') && (substr($line, 0, 2) != '/*') && strlen($line) > 1) {
		    $last = trim(substr($line, -2, 1));
		    $temp .= trim(substr($line, 0, -1));
		    if ($last == ';') {
		      mysql_query($temp);
		      $count++;
		      $temp = '';
		    }
		  }
		}
		print mysql_error();
		print "Total {$count} queries done\n";
		print '</pre>';

		echo "<form action='".$_SERVER['PHP_SELF']."?step=2' method='post'>
Site Title: <input type='text' name='site_title' value='' /><br/>
Login Timeout: <input type='text' name='site_timeout' value='30' /> minutes<br />
Captcha Length: <input type='text' name='captcha_length'] value='5' /> characters<br />
Base URL: <input type='text' name='site_url' value='' /><br />
Index Page: <input type='text' name='site_index' value='index.php' /><br />
<input type='submit' value='Submit' /></form>";
	}
} else {
	echo "<form action='".$_SERVER['PHP_SELF']."?step=1' method='post'>
SQL User: <input type='text' name='sql_user' value='' /><br />
Password: <input type='password' name='sql_pw' value='' /><br />
Database: <input type='text' name='sql_db' value='' /><br />
Table Prefix: <input type='text' name='sql_prefix' value='' /><br />
<input type='submit' value='Submit' />
</form>";
}

?>
