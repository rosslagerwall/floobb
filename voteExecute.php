<?php
	include("common.php");
	include_once("class.Poll.php");
	session_start();

	$poll = new Poll(file_get_contents("db/Topics/".$_GET['topicId']."/poll.dat"));
	if (!in_array($_SESSION['user']->getUserId(),$poll->getUsers()))
	{
		$poll->addUser($_SESSION['user']->getUserId());
		//print_r($poll->getOptions());
		$poll->incOption($_POST['option']);
		$str .= $poll->toString();
		//print_r($poll->getOptions());
	}
	else
	{
		$str .= $line."\n";
	}

	//echo "<xmp>$str</xmp>";
	file_put_contents("db/Topics/".$_GET['topicId']."/poll.dat",$str);
	
	header("location: ".$_SERVER['HTTP_REFERER']);
?>
