<script>
$(document).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();
});
</script>
<footer class="footer">
	<div class="container">© 2010-<?php echo date('Y'); ?> <strong><?php echo $str['servicename']; ?></strong>, <?php
	if ($_SESSION['lang'] === 'ko') {
		echo '완전히 암호화된 파일 공유 서비스.';
		echo ' 업로드된 파일에 대한 모든 권리는 업로드한 사용자에게 있습니다.<br />';
		echo '<a href="#" data-toggle="tooltip" data-placement="top" title="윤지용(GSHS 31st, 기획/개발) 박현민(GSHS 31st, 기획/서류처리(?))">만든 사람</a> | <a href="/licenses.txt">오픈소스 라이센스 정보</a>';
		// | Powered by <a href="http://windows.php.net/">PHP</a> on <a href="http://iis.net/">IIS v8.5</a> w/ <a href="http://www.microsoft.com/ko-kr/server-cloud/products/windows-server-2012-r2/">Windows server 2012 R2</a>. DB powered by <a href="https://mariadb.org/">MariaDB</a>
	} else {
		echo 'the fully-encrypted file sharing service.';
		echo ' All rights to uploaded files are reserved to uploaders.<br />';
		echo '<a href="#" data-toggle="tooltip" data-placement="top" title="Jiyong Youn(GSHS 31st, Planning/Development) Kenny Park(GSHS 31st, Planning/Taking care of documents(?))">Created by...</a> | <a href="/licenses.txt">Open source licenses</a>';
		// | Powered by <a href="http://windows.php.net/">PHP</a> on <a href="http://iis.net/">IIS v8.5</a> w/ <a href="http://www.microsoft.com/ko-kr/server-cloud/products/windows-server-2012-r2/">Windows server 2012 R2</a>. DB powered by <a href="https://mariadb.org/">MariaDB</a>
	}
	?>

	</div>
</footer>
