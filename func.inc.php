<?php
function human_filesize($bytes, $decimals = 2) {
	$sz = 'BKMGTP';
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor] . 'B';
}
function writeLog($filename,$result,$ip)
{
	mysql_query("INSERT INTO log SET filename='" . mysql_real_escape_string($filename) . "', IP='" . $ip . "', result='" . $result . "', time='" . date("Y-m-d H:i:s") . "';");
}
function getFile($filename)
{
	$result = mysql_query("SELECT * FROM storage WHERE filename='" . mysql_real_escape_string($filename) . "';");
	return mysql_fetch_row($result);
}
function getFileList($onlylist=0)
{
	return mysql_query("SELECT * FROM storage" . $onlylist==1?" where enablelist='1'":"" . " ORDER BY id DESC;");
}
function getFileData($filename,$password)
{
	$result = mysql_query("SELECT filedata, AES_DECRYPT(filename_enc, '" . mysql_real_escape_string($password) . "') FROM storage WHERE filename='" . mysql_real_escape_string($filename) . "'");

	return mysql_fetch_row($result);
}
function getIP()
{
	return $_SERVER['REMOTE_ADDR'];
}
function updateLastAccessDate($filename)
{
	mysql_query("UPDATE storage SET lastop='" . date('Y-m-d H:i:s') . "' WHERE filename='" . mysql_real_escape_string($filename)  . "';");
}
function printError($code='error',$result='Unknown error occured',$link='')
{
	$err = array('code'=>$code, 'result'=>$result, 'link'=>$link);
	echo json_encode($err);
}
function getFileCaptchaResult($filename)
{
	return $_SESSION[$filename]['captcha'];
}
function getFileSessionTime($filename)
{
	return $_SESSION[$filename]['time'];
}
function deleteFile($filename)
{
	mysql_query("DELETE FROM storage WHERE filename='" . mysql_real_escape_string($filename) . "';");
	
	if (file_exists('filedata' . DIRECTORY_SEPARATOR . $filename)) unlink('filedata' . DIRECTORY_SEPARATOR . $filename);
	else unlink('filedata_big' . DIRECTORY_SEPARATOR . $filename);
}