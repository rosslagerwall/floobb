<?php
	function isValidEmail($email)
	{
		$pattern = "/^[\w\.=-]+@[\w\.-]+\.[\w]{2,3}$/";
		
		if (preg_match($pattern,$email) == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	if (trim(stripslashes($_POST['username'])) == '' || trim(stripslashes($_POST['password'])) == '')
	{
		header("location: register.php?badRegister=2");
		exit();
	}
	else if (strlen(trim(stripslashes($_POST['username']))) < 3 || strlen(trim(stripslashes($_POST['password']))) < 3)
	{
		header("location: register.php?badRegister=3");
		exit();
	}
	else if (!isValidEmail(trim(stripslashes($_POST['email']))))
	{
		header("location: register.php?badRegister=4");
		exit();
	}
	else if (preg_match("/^\w+$/",trim(stripslashes($_POST['username']))) != 1)
	{
		header("location: register.php?badRegister=5");
		exit();
	}
	
	include("class.User.php");
	session_start();
	
	
	
	if (file_exists("db/Users/".$_POST['username'].".dat"))
	{
		header("location: register.php?badRegister=1");
		exit();
	}
	
	$fh = fopen("db/Users/".$_POST['username'].".dat","w");
	$hideEmail = 0;
	if ($_POST['hideEmail'] == "yes")
	{
		$hideEmail = 1;
	}
	
	$writeString = $_POST['username']."\n".$_POST['password']."\nfalse\n0\n0\n".date("j M Y")."\n1\n\n".$_POST['email']."\n".$hideEmail."\n";
	fwrite($fh, $writeString);
	fclose($fh);
	
	file_put_contents("db/PMs/".$_POST['username'].".dat","");
	
	$fileC = file("db/forumStatistics.dat",FILE_IGNORE_NEW_LINES);
	$fileC[3] = $fileC[3] + 1;
	$fileC[4] = $_POST['username'];
	$str = "";
	foreach ($fileC as $temp)
	{
		$str .= $temp."\n";
	}
	file_put_contents("db/forumStatistics.dat",$str);
	
	header("location: index.php");
?>
