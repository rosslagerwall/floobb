<?php
	include_once("class.Post.php");
	include_once("class.Topic.php");
	include_once("class.Forum.php");
	include_once("class.User.php");
	session_start();
	
	//***********************
	$fileC = file("db/Topics/".$_GET['topicId']."/topic.dat",FILE_IGNORE_NEW_LINES);
	$fileC[0] = $_GET['forumId'];
	$count = trim($fileC[4]);
	$str = "";
	foreach ($fileC as $line)
	{
		$str .= $line."\n";
	}
	file_put_contents("db/Topics/".$_GET['topicId']."/topic.dat",$str);
	
	//***********************
	$fileC = file("db/Topics/".$_GET['topicId']."/posts.dat",FILE_IGNORE_NEW_LINES);
	$str = "";
	foreach ($fileC as $line)
	{
		$temp = explode("~",$line);
		$temp[0] = $_GET['forumId'];
		$str .= implode("~",$temp)."\n";
	}
	file_put_contents("db/Topics/".$_GET['topicId']."/posts.dat",$str);
	
	//************************
	$fhTemp = fopen("db/Topics/".$_GET['oldForumId']."temp.dat","w");
	$fh = fopen("db/Topics/".$_GET['oldForumId'].".dat","r");

	while (!feof($fh))
	{
		$a = trim(fgets($fh));
		$b = trim(fgets($fh));
		if ($a != "" && $b != "" && $a != $_GET['topicId'])
		{
			fwrite($fhTemp, $a."\n".$b."\n");
		}
	}
	fclose($fh);
	fclose($fhTemp);
	
	unlink("db/Topics/".$_GET['oldForumId'].".dat");
	rename("db/Topics/".$_GET['oldForumId']."temp.dat", "db/Topics/".$_GET['oldForumId'].".dat");
	
	//************************
	$fhTemp = fopen("db/Topics/".$_GET['forumId']."temp.dat","w");
	$fh = fopen("db/Topics/".$_GET['forumId'].".dat","r");
	fwrite($fhTemp,$_GET['topicId']."\n".time()."\n");
	
	while (!feof($fh))
	{
		$a = trim(fgets($fh));
		$b = trim(fgets($fh));
		if ($a != "" && $b != "")
		{
			fwrite($fhTemp, $a."\n".$b."\n");
		}
	}
	fclose($fh);
	fclose($fhTemp);
	
	unlink("db/Topics/".$_GET['forumId'].".dat");
	rename("db/Topics/".$_GET['forumId']."temp.dat", "db/Topics/".$_GET['forumId'].".dat");
	
	//*************************
	$fileC = file("db/forumList.dat",FILE_IGNORE_NEW_LINES);
	$str = "";
	foreach ($fileC as $line)
	{
		$temp = explode("~",$line);
		if ($temp[0] == $_GET['oldForumId'])
		{
			$temp[3] = trim($temp[3]) - 1;
			$temp[4] = trim($temp[4]) - $count;
		}
		else if ($temp[0] == $_GET['forumId'])
		{
			$temp[3] = trim($temp[3]) + 1;
			$temp[4] = trim($temp[4]) + $count;
		}

		$str .= implode("~",$temp)."\n";
	}
	file_put_contents("db/forumList.dat",$str);
	
	//**************************
	
	if (file_exists("db/Topics/".$_GET['topicId']."/poll.dat"))
	{
		$fileC = file("db/Topics/".$_GET['topicId']."/poll.dat",FILE_IGNORE_NEW_LINES);
		$fileC[0] = $_GET['forumId'];
		$str = "";
		foreach ($fileC as $line)
		{
			$str .= $line."\n";
		}
		file_put_contents("db/Topics/".$_GET['topicId']."/poll.dat",$str);
	}
	header('Location: index.php');
?>
