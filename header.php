<?php
echo '<meta property="og:title" content="' . $str['servicename'] . ' - Fully-encrypted censorship-free file sharing service">
	<meta property="og:description" content="';
if ($mode === 'download') {
	echo $metadata['filename'] . ' - Download';
} else if ($mode === 'upload') {
	echo 'Upload new file on ' . $str['servicename'];
} else if ($mode === 'about') {
	echo 'Introducing ' . $str['servicename'];
} else if ($mode === 'list') {
	echo 'Public files on ' . $str['servicename'];
}
echo '">';
@include('header.user.php');