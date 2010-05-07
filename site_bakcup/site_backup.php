<html>
<head><title>Website Backup Tool</title></head>
<body><div align="center">
<h2>Website Backup Tool</h2>

<?php

$curtime = date("Y-m-d-H-i-s");
$dirname  = './site_backup/';
$backupfile = 'fullsite_' . date("Y-m-d-H-i-s") . '.tar.bz2';
$archname = $dirname . $backupfile;

function BackupSite() {

	if(!file_exists("./site_backup"))
	{
		if(mkdir("./site_backup", 0777))
			echo "backup directory successfully created./n";
		else
			echo "<span style=\"color: #FF0000\">Error: Unable to create backup directory, please check permissions.</span>";
	}
	global $backupfile;
	global $archname;
	global $size;
	$command = 'tar';
	$command .=' -cjf' . ' ' . $archname . ' --exclude=site_backup --exclude=stats --exclude=_db_backups' . ' .';
	$output = shell_exec($command);
	$version = shell_exec('tar --version');
    $size = round(filesize($archname)/1000000);
	echo "Now backup Your site,Please wait a moment.\r\n";
	echo "Your backup file is " . $backupfile . ' ' . $size.MB."\r\n";
}

function sendmail(){
global $curtime;
global $backupfile;
global $archname;
$text = "整站文件备份" . $backupfile;
$subject = $backupfile;
$from = 'wordpress@suifeng.me';
$to = 'webmaster@suifeng.me';
$file = $archname;
$boundary = uniqid( "");
$headers =  "From:$from\r\n";
$headers .= "Content-type:multipart/mixed; boundary= $boundary\r\n";
$mimeType ="application/x-bzip2";
$fileName = $backupfile;
$fp = fopen($file, "r");
$read = fread($fp, filesize($file));
$read = base64_encode($read);
$read = chunk_split($read);
$body = "--$boundary
Content-type:text/plain; charset=utf-8
Content-transfer-encoding: 8bit
$text
文件:$backupfile
备份日期:$curtime
--$boundary
Content-type: $mimeType; name=$fileName
Content-disposition: attachment; filename=$fileName
Content-transfer-encoding: base64
$read
--$boundary--";

if(mail($to, $subject,$body,$headers))
print "OK! Now the mail from $from ---to--- $to has been send<br>";
else
print "fail to send mail <br>";
	}
?>

<?php

BackupSite();
sendmail();

?>

<p>&copy; <a href="http://www.suifeng.me">且听风吟</a></p>
</div>
</body>
</html>
