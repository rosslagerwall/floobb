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
		header("Location: addForum.php?error=1");
		exit();
	}
	if (trim($description) == "")
	{
		header("Location: addForum.php?error=2");
		exit();
	}

	$forumId = trim(file_get_contents("db/forumNo.dat"));
	
	$fh = fopen("db/forumList.dat","a");
	fwrite($fh,$forumId."~".$name."~".$description."~0~0\n");
	fclose($fh);
	
	file_put_contents("db/Topics/".$forumId.".dat","");
	file_put_contents("db/Topics/".$forumId."sticky.dat","");
	
	file_put_contents("db/forumNo.dat",($forumId+1)."\n");
	
	//***********************
	$fileC = file("db/forumStatistics.dat",FILE_IGNORE_NEW_LINES);
	$fileC[0] = trim($fileC[0]) + 1;
	$str = "";
	foreach ($fileC as $statistic)
	{
		$str .= $statistic."\n";
	}
	file_put_contents("db/forumStatistics.dat",$str);
	
	header("Location: index.php");
?>
