<?php
$isInstall=TRUE;
require("include.php");

//install
mysql_query("CREATE TABLE storage(id INT NOT NULL auto_increment, filename TEXT NOT NULL, filedata MEDIUMBLOB NOT NULL, password TEXT NOT NULL, ip TEXT NOT NULL, metadata MEDIUMTEXT NOT NULL, filename_enc BLOB NOT NULL, expires DATETIME NOT NULL, lastop DATETIME NOT NULL, enablelist BOOLEAN NOT NULL, PRIMARY KEY (id));");

mysql_query("CREATE TABLE log(id INT NOT NULL auto_increment, filename TEXT NOT NULL, IP TEXT NOT NULL, result TEXT NOT NULL, time DATETIME NOT NULL, PRIMARY KEY (id));");

$title = $str['title'];
?><!doctype HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<?php
	$mode = 'upload';
	@include('header.php');
	?>
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="site.min.css">
	<link rel="stylesheet" type="text/css" href="jquery-ui.min.css">
	<script src="jquery.js"></script>
	<script src="jquery-ui.min.js"></script>
	<script src="bootstrap.min.js"></script>
	<script src="./cryptojs/rollups/sha256.js"></script>
	<script src="jquery.zclip.min.js"></script>
	<style type="text/css">
		@font-face {
			font-family: 'Open Sans';
			font-style: normal;
			font-weight: 400;
			src: local('Open Sans'), local('OpenSans'), url(./open_sans.woff2) format('woff2');
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215, U+E0FF, U+EFFD, U+F000;
		}
		.navbar-brand {
			color: white !important;
		}
		body {
			background-color: #f0f0f0;
		}
		div.main {
			margin-top: 65px;
		}
		div.content {
			padding: 15px;
		}
		.btn-upload {
			margin-top: 10px;
		}
		.container-checkbox {
			padding: 0px;
			margin-top: 10px;
		}
		.spacer1 {
			height: 5px;
		}
		.spacer2 {
			height: 0px;
		}
		@media screen and (max-width: 767px) {
			.spacer3 {
				height: 10px;
			}
		}
		.spacer4 {
			height: 15px;
		}
		.label-expires {
			margin-top: 15px;
		}
		.label-expires-desc {
			margin-left: 15px;
			margin-top: 10px;
		}
		.ui-datepicker {
			top: 142px !important;
		}
		@media screen and (max-width: 767px) {
			.ui-datepicker {
				top: 164px !important;
			}
		}
		div.datepicker {
			padding-left: 0px;
			padding-right: 0px;
		}
		input.file {
			display:none;
		}
		.popover {
			position: absolute;
			top: 33px;
		}
		.btn-popover {
			width: calc(50% - 16px);
			margin-left: 10px;
		}
		.footer {
			background-color: #FFF;
			padding: 10px 15px 10px 15px;
			width: 100%;
			position: relative;
		}
	</style>
</head>
<body>
	<!--[if lte IE 8]><script>alert('<?php echo $str['err_noie']; ?>');</script><![endif]-->
	<?php
	$mode = 'install';
	@include('menu.php');
	?>
	<div class="container main">
		<div id="form" class="panel content">
			<h1>거의 다 되었습니다...</h1>
			<p>filedata 폴더와 filedata_big 폴더를 생성후 쓰기 권한을 부여해야 합니다.</p>
		</div>
	</div>
	<?php @include('footer.php'); ?>
</body>
</html>