<?php
	/* This file provides includes and sets up sessions, certain variables,
	remember me functionality and logins. 
	This file is included from many different pages. */

	include_once("class.User.php");
	include_once("class.Topic.php");
	include_once("class.Post.php");
	include_once("class.Forum.php");
	include_once("class.PM.php");
	include_once("function.OnlineList.php");
	include_once("outHtml.php");
	session_start();
	
	if (isset($_COOKIE['username']) && isset($_COOKIE['password']) && ($_SESSION['loggedIn'] == false || !isset($_SESSION['loggedIn'])))
	{
		$fileC = file("db/forumUsers.dat");
		foreach ($fileC as $item)
		{
			$temp = new User($item);
			if ($_COOKIE['username'] == $temp->getUserId() && $_COOKIE['password'] == $temp->getPassword())
			{
				setcookie("username",$_COOKIE['username'],time()+(60*60*24*14));
				setcookie("password",$_COOKIE['password'],time()+(60*60*24*14));
				$_SESSION['loggedIn'] = true;
				$_SESSION['user'] = $temp;
			}
		}
	}
	
	if ($_SESSION['loggedIn'] == true)
	{
		addUser($_SESSION['user']->getUserId());
	}
	else
	{
		addGuest($_SERVER['SERVER_ADDR']);
	}
	
	$boardname = trim(file_get_contents("db/boardname.dat"));
	$boarddescription = trim(file_get_contents("db/boarddescription.dat"));
	define(BOARDNAME,$boardname);
	define(BOARDDESCRIPTION,$boarddescription);
?>
