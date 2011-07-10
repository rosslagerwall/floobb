<?php
	$_POST['reply'] = str_replace("~","",$_POST['reply']);
	
	include_once("function.misc.php");
	include_once("common.php");
	
	$fh = fopen("db/Topics/".$_GET['topicId']."/posts.dat","a");
	$postString = stripslashes($_POST['reply']);
	$postString = str_replace("\n","",$postString);
	$postString = str_replace("\r\n","",$postString);
	$postString = str_replace("\r","",$postString);

	preg_match_all("/<img.*? \/>/",$postString,$matches);

	foreach ($matches[0] as $temp)
	{
		$url = substr(substr(strstr($temp,'src="'),5),0,strpos(substr(strstr($temp,'src="'),5),'"'));
		if (@urlfilesize($url,"kb") <= 200)
		{
			$imgDimensions = @getimagesize($url);
			
			if ($imgDimensions[0] > 600 || $imgDimensions[1] > 600 || $imgDimensions == false)
			{
				$postString = str_replace($temp,"",$postString);
			}
		}
		else
		{
			$postString = str_replace($temp,"",$postString);
		}
	}
	
	$postString = strip_tags($postString,'<p><br><b><i><u><strong><em><li><ul><ol><img><table><tr><td><hr><font><span><sub><sup><tbody><blockquote>');
	
	if ($postString == "" || $postString == "<p></p>")
	{
		header("Location: viewPosts.php?topicId=".$_GET['topicId']."&error=1");
		exit();
	}
	
	//********************
	$writeString = $_SESSION['forum']->getForumId()."~".$_GET['topicId']."~".$_GET['postId']."~".$_SESSION['user']->getUserId()."~".date("G:i:s, j M Y")."~".$postString;
	fwrite($fh, $writeString."\r\n");
	fclose($fh);
	
	//********************
	$fileC = file("db/Topics/".$_GET['topicId']."/topic.dat",FILE_IGNORE_NEW_LINES);
	$fileC[4] = trim($fileC[4]) + 1;
	$str = "";
	foreach ($fileC as $line)
	{
		$str .= $line."\n";
	}
	file_put_contents("db/Topics/".$_GET['topicId']."/topic.dat",$str);
	
	//*********************
	$fhTemp = fopen("db/Topics/".$_SESSION['forum']->getForumId()."temp.dat","w");
	$fh = fopen("db/Topics/".$_SESSION['forum']->getForumId().".dat","r");
	
	fwrite($fhTemp,$_GET['topicId']."\n".time()."\n");
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
	
	unlink("db/Topics/".$_SESSION['forum']->getForumId().".dat");
	rename("db/Topics/".$_SESSION['forum']->getForumId()."temp.dat", "db/Topics/".$_SESSION['forum']->getForumId().".dat");
	
	//*********************
	$fileC = file("db/Users/".$_SESSION['user']->getUserId().".dat",FILE_IGNORE_NEW_LINES);
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
			$str .= $temp->getForumId()."~".$temp->getForumName()."~".$temp->getDescription()."~".$temp->getTotalTopics()."~".($temp->getTotalPosts()+1)."\n";
		}
		else
		{
			$str .= $statistic."\n";
		}
	}
	file_put_contents("db/forumList.dat",$str);
	
	//*********************
	$fileC = file("db/forumStatistics.dat",FILE_IGNORE_NEW_LINES);
	$fileC[2] = $fileC[2] + 1;
	$str = "";
	foreach ($fileC as $statistic)
	{
		$str .= $statistic."\n";
	}
	file_put_contents("db/forumStatistics.dat",$str);

	header('Location: viewPosts.php?topicId='.$_GET['topicId']);
?>
