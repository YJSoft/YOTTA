<?php
require('include.php');
$data = getFile($_GET['link']);

if (count($data) < 2) {
	header('Location: ./');
	exit();
}
$metadata = unserialize($data[5]);

if ($metadata['password_delete'] === hash('sha512', $metadata['salt_delete'] . $_GET['password'])) {
	deleteFile($_GET['link']);
	printError('succeed','succeed');
} else {
	printError('err_wrongpw',$str['err_wrongpw']);
}