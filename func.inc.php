<?php
function getUrl($url,$params=array())
{
    //rewrite setting
    $use_rewrite = 'N';

    //rewrite replace array
    $rewritearray = array(
        '/'=>'',
        '/long'=>'',
        'about.php' => 'about',
        'nofile'=>'nofile',
        'nofile/long'=>'index.php?nofile',
        'list.php'=>'list',
        'upload.php'=>'upload',
        'lang'=>'lang',
        'lang/long'=>'index.php?lang',
        'fetch.php/long'=>'fetch.php?link=linkval&password=passwordval',
        'fetch.php'=>'fetch/linkval/passwordval',
        'delete.php/long'=>'delete.php?link=linkval&password=passwordval',
        'delete.php'=>'delete/linkval/passwordval',
        'download.php/long'=>'download.php?link=linkval',
        'download.php'=>'linkval'
    );

    if($use_rewrite=='Y')
    {
        $shorturl = $rewritearray[$url];

        foreach($params as $key=>$value)
        {
            $shorturl = str_replace($key,$value,$shorturl);
        }
        return $shorturl;
    }
    else
    {
        if(isset($rewritearray[$url . '/long']))
        {
            $longurl = $rewritearray[$url . '/long'];

            foreach($params as $key=>$val)
            {
                $longurl = str_replace($key,$val,$longurl);
            }
            return $longurl;
        }
        else
        {
            return $url;
        }
    }
}

/**
 * @param $val
 * @return int
 */
function returnBytes($val)
{
    $unit = strtoupper(substr($val, -1));
    $val = (int)$val;
    switch ($unit)
    {
        case 'G': $val *= 1024;
        case 'M': $val *= 1024;
        case 'K': $val *= 1024;
    }
    return $val;
}

/**
 * change file byte to human-friendly
 * @param int $bytes
 * @param int $decimals
 * @return string
 */
function human_filesize($bytes=0, $decimals = 2) {
	$sz = 'BKMGTP';
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor] . 'B';
}

/**
 * write log
 * @param string $filename
 * @param string $result
 * @param $ip
 */
function writeLog($filename,$result,$ip)
{
	mysql_query("INSERT INTO log SET filename='" . mysql_real_escape_string($filename) . "', IP='" . $ip . "', result='" . $result . "', time='" . date("Y-m-d H:i:s") . "';");
}

/**
 * get file infomation
 * @param string $filename
 * @return array
 */
function getFile($filename)
{
	$result = mysql_query("SELECT * FROM storage WHERE filename='" . mysql_real_escape_string($filename) . "';");
	return mysql_fetch_row($result);
}

/**
 * get file list
 * @param int $onlylist
 * @return resource
 */
function getFileList($onlylist=0)
{
	$cond = $onlylist==1 ? " where enablelist='1'" : "";
	$query = sprintf("SELECT * FROM storage%s ORDER BY id DESC;",$cond);

	return mysql_query($query);
}

/**
 * get file data(filedata,filename,etc)
 * @param string $filename
 * @param string $password
 * @return array
 */
function getFileData($filename,$password)
{
	$result = mysql_query("SELECT filedata, AES_DECRYPT(filename_enc, '" . mysql_real_escape_string($password) . "') FROM storage WHERE filename='" . mysql_real_escape_string($filename) . "'");

	return mysql_fetch_row($result);
}

/**
 * returns client's ip
 * @return mixed
 */
function getIP()
{
	return $_SERVER['REMOTE_ADDR'];
}

/**
 * update file's last access time
 * @param $filename
 */
function updateLastAccessDate($filename)
{
	mysql_query("UPDATE storage SET lastop='" . date('Y-m-d H:i:s') . "' WHERE filename='" . mysql_real_escape_string($filename)  . "';");
}

/**
 * print json error
 * @param string $code
 * @param string $result
 * @param string $link
 */
function printError($code='error',$result='Unknown error occured',$link='')
{
	$err = array('code'=>$code, 'result'=>$result, 'link'=>$link);
	echo json_encode($err);
}

/**
 * @param $filename
 * @return mixed
 */
function getFileCaptchaResult($filename)
{
	return $_SESSION[$filename]['captcha'];
}

/**
 * @param $filename
 * @return mixed
 */
function getFileSessionTime($filename)
{
	return $_SESSION[$filename]['time'];
}

/**
 * @param $filename
 */
function deleteFile($filename)
{
	mysql_query("DELETE FROM storage WHERE filename='" . mysql_real_escape_string($filename) . "';");
	
	if (file_exists('filedata' . DIRECTORY_SEPARATOR . $filename)) unlink('filedata' . DIRECTORY_SEPARATOR . $filename);
	else unlink('filedata_big' . DIRECTORY_SEPARATOR . $filename);
}