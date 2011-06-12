<?php
	if (trim(stripslashes($_POST['name'])) == "")
	{
		header("Location: editTopic.php?topicId=".$_GET['topicId']."&error=1");
		exit();
	}
	
	include_once("class.Post.php");
	include_once("class.Topic.php");
	include_once("class.Forum.php");
	include_once("class.User.php");
	session_start();
	
	$fileC = file("db/Topics/".$_GET['topicId']."/topic.dat",FILE_IGNORE_NEW_LINES);
	$fileC[5] = htmlentities(stripslashes($_POST['name']));
	$str = "";
	foreach ($fileC as $line)
	{
		$str .= $line."\n";
	}
	file_put_contents("db/Topics/".$_GET['topicId']."/topic.dat",$str);
	header('Location: viewTopics.php?forumId='.$_GET['forumId']);
?>
