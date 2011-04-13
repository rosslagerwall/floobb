<?php
	if ($_GET['mode'] == 'sticky')
	{
		$fileC = file("db/Topics/".$_GET['topicId']."/topic.dat",FILE_IGNORE_NEW_LINES);
		$fileC[7] = "true";
		$str = "";
		foreach ($fileC as $temp)
		{
			$str .= $temp."\n";
		}
		//echo "<xmp>$str</xmp>";
		file_put_contents("db/Topics/".$_GET['topicId']."/topic.dat",$str);
		
		//*********************
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
		
		//***********************
		$fhTemp = fopen("db/Topics/".$_GET['forumId']."stickytemp.dat","w");
		$fh = fopen("db/Topics/".$_GET['forumId']."sticky.dat","r");
		
		fwrite($fhTemp, $_GET['topicId']."\n".time()."\n");
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
		
		unlink("db/Topics/".$_GET['forumId']."sticky.dat");
		rename("db/Topics/".$_GET['forumId']."stickytemp.dat", "db/Topics/".$_GET['forumId']."sticky.dat");
			
		header("location: viewPosts.php?topicId=".$_GET['topicId']);
	}
	else if ($_GET['mode'] == 'unsticky')
	{
		$fileC = file("db/Topics/".$_GET['topicId']."/topic.dat",FILE_IGNORE_NEW_LINES);
		$fileC[7] = "false";
		$str = "";
		foreach ($fileC as $temp)
		{
			$str .= $temp."\n";
		}
		//echo "<xmp>$str</xmp>";
		file_put_contents("db/Topics/".$_GET['topicId']."/topic.dat",$str);
		
		//*********************
		$fhTemp = fopen("db/Topics/".$_GET['forumId']."temp.dat","w");
		$fh = fopen("db/Topics/".$_GET['forumId'].".dat","r");
		
		fwrite($fhTemp, $_GET['topicId']."\n".time()."\n");
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
		
		//***********************
		$fhTemp = fopen("db/Topics/".$_GET['forumId']."stickytemp.dat","w");
		$fh = fopen("db/Topics/".$_GET['forumId']."sticky.dat","r");
		
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
		
		unlink("db/Topics/".$_GET['forumId']."sticky.dat");
		rename("db/Topics/".$_GET['forumId']."stickytemp.dat", "db/Topics/".$_GET['forumId']."sticky.dat");
		
		header("location: viewPosts.php?topicId=".$_GET['topicId']);
	}
?>
