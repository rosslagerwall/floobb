<?php
	$_POST['message'] = str_replace("~","",$_POST['message']);
	if (trim(stripslashes($_POST['topicName'])) == "" || trim(stripslashes($_POST['message'])) == "")
	{
		unset($_POST['topicName']);
		unset($_POST['message']);
		header("Location: addTopic.php?forumId=".$_GET['forumId']."&error=1");
		exit();
	}
	
	include_once("class.Post.php");
	include_once("class.Topic.php");
	include_once("class.Forum.php");
	include_once("class.User.php");
	session_start();
	
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
	
	$total = trim(file_get_contents("db/topicNo.dat"));
	file_put_contents("db/topicNo.dat",($total+1));
	
	mkdir("db/Topics/".$total);
	
	$str = $_GET['forumId'];
	$str .= "\n".$total;
	$str .= "\n".$_SESSION['user']->getUserId();
	$str .= "\n".date("G:i:s, j M Y");
	$str .= "\n1";
	$str .= "\n".htmlentities(stripslashes($_POST['topicName']))."\nfalse\nfalse";
	file_put_contents("db/Topics/".$total."/topic.dat",$str);
	
	$str = $_GET['forumId'];
	$str .= "~".$total;
	$str .= "~0";
	$str .= "~".$_SESSION['user']->getUserId();
	$str .= "~".date("G:i:s, j M Y");
	
	$postString = stripslashes($_POST['message']);
	$postString = str_replace("\n","",$postString);
	$postString = str_replace("\r\n","",$postString);
	$postString = str_replace("\r","",$postString);

	preg_match_all("/<img.*? \/>/",$postString,$matches);

	foreach ($matches[0] as $match)
	{
		$url = substr(substr(strstr($match,'src="'),5),0,strpos(substr(strstr($match,'src="'),5),'"'));
		if (@urlfilesize($url,"kb") <= 200)
		{
			$imgDimensions = @getimagesize($url);
			
			if ($imgDimensions[0] > 600 || $imgDimensions[1] > 600 || $imgDimensions == false)
			{
				$postString = str_replace($match,"",$postString);
			}
		}
		else
		{
			$postString = str_replace($match,"",$postString);
		}
	}
	
	$postString = strip_tags($postString,'<p><br><b><i><u><strong><em><li><ul><ol><img><table><tr><td><hr><font><span><sub><sup><tbody><blockquote>');
	
	$str .= "~".$postString;
	file_put_contents("db/Topics/".$total."/posts.dat",$str."\n");
	
	//*********************
	$fileC = file("db/Users/".$_SESSION['user']->getUserId().".dat",FILE_IGNORE_NEW_LINES);
	$fileC[3] = trim($fileC[3]) + 1;
	$fileC[4] = trim($fileC[4]) + 1;
	$str = "";
	foreach ($fileC as $line)
	{
		$str .= $line."\n";
	}
	file_put_contents("db/Users/".$_SESSION['user']->getUserId().".dat",$str);
	
	//********************
	$fileC = file("db/forumList.dat",FILE_IGNORE_NEW_LINES);
	$str = "";
	foreach ($fileC as $statistic)
	{
		$temp = new Forum($statistic);
		if ($temp->getForumId() == $_SESSION['forum']->getForumId())
		{
			$str .= $temp->getForumId()."~".$temp->getForumName()."~".$temp->getDescription()."~".($temp->getTotalTopics()+1)."~".($temp->getTotalPosts()+1)."\n";
		}
		else
		{
			$str .= $statistic."\n";
		}
	}
	file_put_contents("db/forumList.dat",$str);
	
	//*********************
	$fhTemp = fopen("db/Topics/".$_GET['forumId']."temp.dat","w");
	$fh = fopen("db/Topics/".$_GET['forumId'].".dat","r");
	
	fwrite($fhTemp,$total."\n".time()."\n");
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
	
	//****************************
	$fileC = file("db/forumStatistics.dat",FILE_IGNORE_NEW_LINES);
	$fileC[1] = $fileC[1] + 1;
	$fileC[2] = $fileC[2] + 1;
	$str = "";
	foreach ($fileC as $statistic)
	{
		$str .= $statistic."\n";
	}
	file_put_contents("db/forumStatistics.dat",$str);
	
	header('Location: viewPosts.php?topicId='.$total);
?>
