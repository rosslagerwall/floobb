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


	function urlfilesize($url,$thereturn)
	{
		if (substr($url,0,4)=='http')
		{
			$x = array_change_key_case(get_headers($url, 1),CASE_LOWER);
			$x = $x['content-length'];
		}
		else
		{
			$x = @filesize($url);
		}
		if (!$thereturn)
		{
			return $x;
		}
		elseif ($thereturn == 'mb')
		{
			return round($x / (1024*1024),2);
		}
		elseif ($thereturn == 'kb')
		{
			return round($x / (1024),0);
		}
	}
	
	include_once("class.User.php");
	session_start();
	
	if (strlen(trim(stripslashes($_POST['password']))) < 3)
	{
		header("Location: editUser.php?userId=".$_SESSION['user']->getUserId()."&error=2");
		exit();
	}
	if (!isValidEmail(trim(stripslashes($_POST['email']))))
	{
		header("Location: editUser.php?userId=".$_SESSION['user']->getUserId()."&error=1");
		exit();
	}
	
	$sigStr = stripslashes($_POST['sig']);
	$sigStr = str_replace("\n","",$sigStr);
	$sigStr = str_replace("\r\n","",$sigStr);
	$sigStr = str_replace("\r","",$sigStr);

	preg_match_all("/<img.*? \/>/",$sigStr,$matches);

	foreach ($matches[0] as $match)
	{
		$url = substr(substr(strstr($match,'src="'),5),0,strpos(substr(strstr($match,'src="'),5),'"'));
		if (@urlfilesize($url,"kb") <= 200)
		{
			$imgDimensions = @getimagesize($url);
			
			if ($imgDimensions[0] > 600 || $imgDimensions[1] > 600 || $imgDimensions == false)
			{
				$sigStr = str_replace($match,"",$sigStr);
			}
		}
		else
		{
			$sigStr = str_replace($match,"",$sigStr);
		}
	}
	
	$sigStr = strip_tags($sigStr,'<p><br><b><i><u><strong><em><li><ul><ol><img><table><tr><td><hr><font><span><sub><sup><tbody><blockquote>');
	
	if ($_POST['hideEmail'] == 'yes')
	{
		$hideEmail = 1;
	}
	else
	{
		$hideEmail = 0;
	}
	
	if (@urlfilesize($_POST['avatar'],"kb") <= 100)
	{
		$imgDimensions = @getimagesize($_POST['avatar']);
		if ($imgDimensions[0] <= 70 && $imgDimensions[1] <= 70 && $imgDimensions != false)
		{
			$img = $_POST['avatar'];
		}
		else
		{
			$img = "";
		}
	}
	else
	{
		$img = "";
	}
	
	$newUserStr = $_SESSION['user']->getUserId()."\n".trim(stripslashes($_POST['password']))."\nfalse\n".$_SESSION['user']->getNoTopics()."\n".$_SESSION['user']->getNoPosts()."\n".$_SESSION['user']->getJoinDate()."\n".$_SESSION['user']->getLevel()."\n".$sigStr."\n".trim(stripslashes($_POST['email']))."\n".$hideEmail."\n".$img;
	
	file_put_contents("db/Users/".$_SESSION['user']->getUserId().".dat",$newUserStr);
	
	$temp = new User($newUserStr);
	$_SESSION['loggedIn'] = true;
	$_SESSION['user'] = $temp;
	header("location: editUser.php?userId=".$_SESSION['user']->getUserId());
?>
