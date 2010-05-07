<?php
$text = 整站备份文件;
$subject = 文件备份;
$from = 'wordpress@suifeng.me';
$to = 'webmaster@suifeng.me';
$file = './site_backup/fullsite_2010-05-06-13-19-33.tar.bz2';
$boundary = uniqid( "");
$headers =  "From:$from\r\n";
$headers .= "Content-type:multipart/mixed; boundary= $boundary\r\n";
$mimeType ="application/x-bzip2";
$fileName = "fullsite_2010-05-06-13-19-33.tar.bz2";
$fp = fopen($file, "r");
$read = fread($fp, filesize($file));
$read = base64_encode($read);
$read = chunk_split($read);
$body = "--$boundary
Content-type:text/plain; charset=iso-8859-1
Content-transfer-encoding: 8bit
$text
--$boundary
Content-type: $mimeType; name=$fileName
Content-disposition: attachment; filename=$fileName
Content-transfer-encoding: base64
$read
--$boundary--";

if(mail($to, $subject,$body,$headers))
print "OK! the mail $from --- $to has been send<br>";
else
print "fail to send mail <br>";
?> 

