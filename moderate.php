<?php
	include_once("class.Post.php");
	include_once("class.Topic.php");
	include_once("class.Forum.php");
	include_once("class.User.php");
	session_start();
	
	if ($_GET['flag'] == 'post')
	{
		$str = "";
		$fileC = file("db/Topics/".$_GET['topicId']."/posts.dat",FILE_IGNORE_NEW_LINES);
		
		foreach ($fileC as $line)
		{
			$temp = new Post($line);
			if ($_GET["postId"] != $temp->getPostId())
			{
				$str .= $line."\n";
			}
			else
			{
				$userId = $temp->getUser()->getUserId();
			}
		}
		file_put_contents("db/Topics/".$_GET['topicId']."/posts.dat",$str);
		
		//*******************
		$fileC = file("db/Users/".$userId.".dat",FILE_IGNORE_NEW_LINES);
		$fileC[4] = trim($fileC[4]) - 1;
		$str = "";
		foreach ($fileC as $temp)
		{
			$str .= $temp."\n";
		}
		file_put_contents("db/Users/".$userId.".dat",$str);
		
		//******************
		$fileC = file("db/Topics/".$_GET['topicId']."/topic.dat",FILE_IGNORE_NEW_LINES);
		$fileC[4] = trim($fileC[4]) - 1;
		$str = "";
		foreach ($fileC as $temp)
		{
			$str .= $temp."\n";
		}
		file_put_contents("db/Topics/".$_GET['topicId']."/topic.dat",$str);
		
		//********************
		$fileC = file("db/forumList.dat",FILE_IGNORE_NEW_LINES);
		$str = "";
		foreach ($fileC as $statistic)
		{
			$temp = new Forum($statistic);
			if ($temp->getForumId() == $_SESSION['forum']->getForumId())
			{
				$str .= $temp->getForumId()."~".$temp->getForumName()."~".$temp->getDescription()."~".$temp->getTotalTopics()."~".($temp->getTotalPosts()-1)."\n";
			}
			else
			{
				$str .= $statistic."\n";
			}
		}
		file_put_contents("db/forumList.dat",$str);
		
		//******************
		$fileC = file("db/forumStatistics.dat",FILE_IGNORE_NEW_LINES);
		$fileC[2] = trim($fileC[2]) - 1;
		$str = "";
		foreach ($fileC as $temp)
		{
			$str .= $temp."\n";
		}
		file_put_contents("db/forumStatistics.dat",$str);
	}
	else if ($_GET["flag"] == "topic")
	{
		$fileC = file("db/Topics/".$_GET['topicId']."/posts.dat",FILE_IGNORE_NEW_LINES);
		
		$str = "";
		$count = 0;
		foreach ($fileC as $line)
		{
			$temp = new Post($line);
			$userId = $temp->getUser()->getUserId();
			$fileC = file("db/Users/".$userId.".dat",FILE_IGNORE_NEW_LINES);
			$fileC[4] = trim($fileC[4]) - 1;
			$str = "";
			foreach ($fileC as $temp)
			{
				$str .= $temp."\n";
			}
			file_put_contents("db/Users/".$userId.".dat",$str);
			$count++;
		}
		
		//******************************
		$topic = new Topic(file_get_contents("db/Topics/".$_GET['topicId']."/topic.dat",FILE_IGNORE_NEW_LINES));
		$fileC = file("db/Users/".$topic->getUser()->getUserId().".dat",FILE_IGNORE_NEW_LINES);
		$fileC[3] = trim($fileC[3]) - 1;
		$str = "";
		foreach ($fileC as $temp)
		{
			$str .= $temp."\n";
		}
		file_put_contents("db/Users/".$topic->getUser()->getUserId().".dat",$str);
		
		//*******************************
		$fileC = file("db/forumStatistics.dat",FILE_IGNORE_NEW_LINES);
		$fileC[1] = $fileC[1] - 1;
		$fileC[2] = $fileC[2] - $count;
		$str = "";
		foreach ($fileC as $temp)
		{
			$str .= $temp."\n";
		}
		file_put_contents("db/forumStatistics.dat",$str);
		
		//********************
		$fileC = file("db/forumList.dat",FILE_IGNORE_NEW_LINES);
		$str = "";
		foreach ($fileC as $statistic)
		{
			$temp = new Forum($statistic);
			if ($temp->getForumId() == $_SESSION['forum']->getForumId())
			{
				$str .= $temp->getForumId()."~".$temp->getForumName()."~".$temp->getDescription()."~".($temp->getTotalTopics()-1)."~".($temp->getTotalPosts()-$count)."\n";
			}
			else
			{
				$str .= $statistic."\n";
			}
		}
		file_put_contents("db/forumList.dat",$str);
		
		//********************************
		$fhTemp = fopen("db/Topics/".$_GET['forumId']."temp.dat","w");
		$fh = fopen("db/Topics/".$_GET['forumId'].".dat","r");
		
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
		
		unlink("db/Topics/".$_GET['forumId'].".dat");
		rename("db/Topics/".$_GET['forumId']."temp.dat", "db/Topics/".$_GET['forumId'].".dat");
		
		//**********************************
		unlink("db/Topics/".$_GET['topicId']."/posts.dat");
		if (file_exists("db/Topics/".$_GET['topicId']."/poll.dat"))
		{
			unlink("db/Topics/".$_GET['topicId']."/poll.dat");
		}
		unlink("db/Topics/".$_GET['topicId']."/topic.dat");
		rmdir("db/Topics/".$_GET['topicId']);
	}
	
	header("location: ".$_SERVER['HTTP_REFERER']);
?>
