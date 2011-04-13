<?php
	$_POST['pollQuestion'] = str_replace("~","",$_POST['pollQuestion']);

	if (trim(stripslashes($_POST['pollQuestion'])) == "")
	{
		unset($_POST['pollQuestion']);
		unset($_POST['pollLength']);
		unset($_POST['option']);
		header("Location: addPoll.php?forumId=".$_GET['forumId']."&error=1");
		exit();
	}
	foreach ($_POST['option'] as $option)
	{
		if (trim(stripslashes($option)) == "")
		{
			unset($_POST['pollQuestion']);
			unset($_POST['pollLength']);
			unset($_POST['option']);
			header("Location: addPoll.php?forumId=".$_GET['forumId']."&error=2");
			exit();
		}
	}
	
	include_once("common.php");
	include_once("class.Poll.php");
	
	$total = trim(file_get_contents("db/topicNo.dat"));
	
	file_put_contents("db/topicNo.dat",($total+1));
	
	mkdir("db/Topics/".$total);
	
	$str = $_GET['forumId'];
	$str .= "\n".$total;
	$str .= "\n".$_SESSION['user']->getUserId();
	$str .= "\n".date("G:i:s, j M Y");
	$str .= "\n1";
	$str .= "\nPoll: ".substr(htmlentities(stripslashes($_POST['pollQuestion'])),0,50)."\nfalse\nfalse";
	file_put_contents("db/Topics/".$total."/topic.dat",$str);
	
	$topicId = $total;
	//*******************
	$str = $_GET['forumId'];
	$str .= "\n".$topicId;

	if ($_POST['pollLength'] == 0)
	{
		$str .= "\n\n";
	}
	else
	{
		$str .= "\n\n".date("G:i:s, j M Y",(time()+24*60*60*$_POST['pollLength']));
	}

	foreach ($_POST['option'] as $option)
	{
		$str .= "\n".str_replace("~","",str_replace(",","",$option)).",0";
	}
	
	file_put_contents("db/Topics/".$total."/poll.dat",$str);
	
	//******************
	$str = $_GET['forumId'];
	$str .= "~".$total;
	$str .= "~0";
	$str .= "~".$_SESSION['user']->getUserId();
	$str .= "~".date("G:i:s, j M Y");	
	$str .= "~<p>".htmlentities(stripslashes($_POST['pollQuestion']))."</p>";
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
	
	header("location: viewPosts.php?topicId=".$topicId);
?>
