<?php

/*
	WEBSITE BACKUP TOOL V1.0
	FOR MORE INFORMATION, PLEASE VISIT THEWEBHOSTINGHERO.COM OR READ THE POST AT
	http://www.thewebhostinghero.com/tutorials/how-to-backup-godaddy-website.html
*/

global $password;

$password = 'suifengdotme';						// PASSWORD TO PROTECT THIS SCRIPT
$max_execution_time = 120;					// MAX PHP SCRIPT EXECUTION TIME IN SECONDS

// DO NOT EDIT BELOW THIS LINE
@ini_set('max_execution_time', $max_execution_time);

if(!session_id())
	session_start();
?>
	<html>
	<head><title>GoDaddy Website Backup Tool</title></head>
	<body><div align="center">
	<h2>GoDaddy Website Backup Tool</h2>
<?
$mypassword = $_POST['mypassword'];

if(!$_SESSION['authenticated'] && $mypassword == '')
{
	ShowAuthenticationForm();
	exit();
}
	
if(!$_SESSION['authenticated'] && $mypassword != '')
	Authenticate();
	
if($_SESSION['authenticated'] && $mypassword == '')
{
	BackupSite();
	exit();
}

function Authenticate()
{
	global $password, $mypassword;
	
	if($password != $mypassword)
	{
		echo '<p style="color: #FF0000;">Authentication failed</p>';
		ShowAuthenticationForm();
	}
	else
	{
		$_SESSION['authenticated'] = true;
		BackupSite();
	}
}

function BackupSite() {

	if(!file_exists("mysql-backup"))
	{
		if(mkdir("./mysql-backup", 0777))
			echo "MySQL backup directory successfully created.";
		else
			echo "<span style=\"color: #FF0000\">Error: Unable to create MySQL backup directory, please check permissions.</span>";
	}
	
	$archname = './fullsite_' . date("Y-m-d-H-i-s") . '.tar.gz';

	$command = 'tar -';
	$command .= '-exclude ' . $archname . ' -czf ' . $archname . ' .';

	$output = shell_exec($command);
	
	$size = round(filesize($archname)/1000);
?>
	<p>Backup completed<br /><a href=<?php echo $archname ?>>Click here to download your backup</a> (<?php echo $size; ?>Kb)</p> <p><em>Don’t forget to delete
	<?php echo $archname ?> when you’re done!</em></p></div>
<?php
}

function ShowAuthenticationForm()
{
?>
	<form name="sitebackup" method="post" action="sitebackup.php">
    Password : <input type="text" name="mypassword" id="mypassword" />
    <input type="submit" name="button" id="button" value="Backup!" />
	</form>
<?php
}
?>
	<p>&copy; <a href="http://www.thewebhostinghero.com">TheWebHostingHero.com</a></p>
	</div>
	</body>
	</html>
