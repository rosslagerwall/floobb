<?php
	session_start();
	include_once("class.User.php");
	include_once("function.OnlineList.php");
	
	if (file_exists("db/Users/".$_POST['username'].".dat"))
	{
		$str = file_get_contents("db/Users/".$_POST['username'].".dat");
		$user = new User($str);
		if ($_POST['password'] == $user->getPassword())
		{
			if ($user->isBanned() == 'false')
			{
				if ($_POST['remember'] == 'checked')
				{
					setcookie("username",$_POST['username'],time()+(60*60*24*14));
					setcookie("password",$_POST['password'],time()+(60*60*24*14));
				}
				$_SESSION['loggedIn'] = true;
				$_SESSION['user'] = $user;
				removeGuest($_SERVER['SERVER_ADDR']);
				header("location: index.php");
				exit();
			}
			else
			{
				header("location: login.php?badLogin=2");
				exit();
			}
		}
		else
		{
			header("location: login.php?badLogin=1");
			exit();
		}
	}
	
	header("location: login.php?badLogin=1");
?>
