<?php
require_once('config.inc.php');

//TODO create func.inc.php(functions file)
function human_filesize($bytes, $decimals = 2) {
	$sz = 'BKMGTP';
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor] . 'B';
}

//this is useless because it forces timezone to seoul.
//date_default_timezone_set("Asia/Seoul");

//TODO move db connection to other file
mysql_connect($db_host, $db_user, $db_password);
mysql_select_db($db_name);
mysql_query('SET GLOBAL max_allowed_packet=1073741824;');

session_start();

if (!isset($_SESSION['lang'])) {
	if (strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'ko') !== false) {
		$_SESSION['lang'] = 'ko';
	} else {
		$_SESSION['lang'] = 'en';
	}
}

if (isset($_GET['lang'])) {
	if ($_SESSION['lang'] === 'ko') {
		$_SESSION['lang'] = 'en';
	} else {
		$_SESSION['lang'] = 'ko';
	}
	header('Location: /');
	exit;
}

//remove stupid ini parsing method
/*
$strings = file_get_contents('strings-' . $_SESSION['lang'] . '.ini');
$strings_each = explode("\n", $strings);
foreach($strings_each as $i) {
	if (preg_match('/^ *([a-z_-]+) *= *(.*)$/', $i, $match)) {
		$str[$match[1]] = $match[2];
	}
}
*/
require('strings-' . $_SESSION['lang'] . '.php');

$result = mysql_query("SHOW TABLES LIKE 'storage'");
$tableExists = mysql_num_rows($result) > 0;

if(!$isInstall && !$tableExists)
{
	header("Location: ./install.php");
}
else if($isInstall && $tableExists)
{
	header("Location: ./");
}

//require if table exist
if($tableExists) require_once('expire.php');