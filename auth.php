<?php
require_once('include.php');
set_time_limit(0);
$req = curl_init('https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptcha_secret . '&response=' . $_POST['captcha'] . '&remoteip=' . getIP());
curl_setopt($req, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($req, CURLOPT_SSL_VERIFYPEER, FALSE);
$data = curl_exec($req);
$captcha = json_decode($data, true);
if ($captcha['success'] === false) {
	echo '{"result":"' . $str['err_captcha'] . '"}';
	$_SESSION[$_POST['link']]['captcha'] = false;
	exit();
}

$_SESSION[$_POST['link']]['captcha'] = 'true';
$_SESSION[$_POST['link']]['time'] = microtime(true);

$data = getFile($_POST['link']);
if (count($data) < 2) {
	header('Location: ./');
	exit();
}
$metadata = unserialize($data[5]);
if (hash('sha512', explode('$', $data[3])[2] . $_POST['password']) === explode('$', $data[3])[1]) {
	printError('succeed','succeed');
} else {
	printError('err_wrongpw',$str['err_wrongpw']);
}