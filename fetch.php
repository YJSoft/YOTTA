<?php
require_once('include.php');
set_time_limit(0);
$file_link=$_GET['link'];
$file_password=$_GET['password'];

if (getFileCaptchaResult($file_link)!=='true') {
	$err = array('code'=>'captchawrong', 'result'=>$str['err_captcha']);
	echo json_encode($err);
	writeLog($file_link,'captchawrong',getIP());
	exit();
} else if (microtime(true) - getFileSessionTime($file_link) > 10) {
	$err = array('code'=>'sessionexpired', 'result'=>$str['err_session']);
	echo json_encode($err);
	writeLog($file_link,'sessionexpired',getIP());
	exit();
}

$data = getFile($file_link);
if (count($data) < 2) {
	writeLog($file_link,'wrongfile',getIP());
	header('Location: ./');
	exit();
}

writeLog($file_link,'succeed',getIP());
$metadata = unserialize($data[5]);
if (hash('sha512', explode('$', $data[3])[2] . $file_password) === explode('$', $data[3])[1]) {
	updateLastAccessDate($file_link);
	$data = getFileData($file_link,$file_password);
	$filename = $metadata['filename'] === '' ? $data[1] : $metadata['filename'];
	if (file_exists('filedata/' . $file_link)) $content = file_get_contents('filedata/' . $file_link);
	else $content = file_get_contents('filedata_big/' . $file_link);
	$content = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, pack('H*', $file_password), $content, MCRYPT_MODE_CBC, $data[0]);
	header("Content-Type: application/octet-stream", FALSE);
	header("Content-Transfer-Encoding: Binary", FALSE); 
	header("Content-Disposition: attachment; filename=\"" . $filename . "\"", FALSE);
	header("Content-Length: " . $metadata['filesize'], FALSE);
	print($content);
} else {
	printError();
}