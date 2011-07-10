<?php
	/* Logout, remove the user from the online list, reset cookies and return
	to the index page. */

	include_once("function.OnlineList.php");
	include_once("class.User.php");
	session_start();
	setcookie("username",NULL,time()-10);
	setcookie("password",NULL,time()-10);
	removeUser($_SESSION['user']->getUserId());
	session_destroy();
	header("location: index.php");
?>
