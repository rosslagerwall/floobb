<?php
	include("common.php");

	$name = stripslashes($_POST['name']);
	$name = str_replace("\n","",$name);
	$name = str_replace("\r\n","",$name);
	$name = str_replace("\r","",$name);
	$name = str_replace("~","",$name);
	$description = stripslashes($_POST['description']);
	$description = str_replace("\n","",$description);
	$description = str_replace("\r\n","",$description);
	$description = str_replace("\r","",$description);
	$description = str_replace("~","",$description);
	$description = substr($description,3,strlen($description)-7);
	
	if (trim($name) == "")
	{
		header("Location: forumListEdit.php?forumId=".$_GET['forumId']."&error=1");
		exit();
	}
	if (trim($description) == "")
	{
		header("Location: forumListEdit.php?forumId=".$_GET['forumId']."&error=2");
		exit();
	}

	$fileC = file("db/forumList.dat",FILE_IGNORE_NEW_LINES);
	$str = "";
	foreach ($fileC as $statistic)
	{
		$temp = new Forum($statistic);
		if ($temp->getForumId() == $_GET['forumId'])
		{
			$str .= $temp->getForumId()."~".$name."~".$description."~".$temp->getTotalTopics()."~".$temp->getTotalPosts()."\n";
		}
		else
		{
			$str .= $statistic."\n";
		}
	}
	file_put_contents("db/forumList.dat",$str);
	
	header("Location: index.php");
?>
