<?php
	include("common.php");
	if ($_GET['mode'] == 'down')
	{
		$fhTemp = fopen("db/forumListtemp.dat","w");
		$fh = fopen("db/forumList.dat","r");
		
		while (!feof($fh))
		{
			$a = trim(fgets($fh));
			if ($a != "")
			{
				$item = new Forum($a);
				if ($item->getForumId() == $_GET['forumId'])
				{
					$b = trim(fgets($fh));
					fwrite($fhTemp, $b."\n");
				}
				fwrite($fhTemp, $a."\n");
			}
		}
		fclose($fh);
		fclose($fhTemp);
		
		unlink("db/forumList.dat");
		rename("db/forumListtemp.dat", "db/forumList.dat");
	}
	else if ($_GET['mode'] == 'up')
	{
		$fhTemp = fopen("db/forumListtemp.dat","w");
		$fh = fopen("db/forumList.dat","r");
		
		$a = trim(fgets($fh));
		while (!feof($fh))
		{
			$b = trim(fgets($fh));
			$item = new Forum($b);
			if ($item->getForumId() == $_GET['forumId'])
			{
				fwrite($fhTemp, $b."\n");
				$b = $a;
			}
			else
			{
				if ($a != "")
				{
					fwrite($fhTemp, $a."\n");
				}
			}
			$a = $b;
		}
		if ($a != "")
		{
			fwrite($fhTemp, $a."\n");
		}
		fclose($fh);
		fclose($fhTemp);
		
		unlink("db/forumList.dat");
		rename("db/forumListtemp.dat", "db/forumList.dat");
	}
	else if ($_GET['mode'] == 'delete')
	{
		$fhTemp = fopen("db/forumListtemp.dat","w");
		$fh = fopen("db/forumList.dat","r");
		
		while (!feof($fh))
		{
			$a = trim(fgets($fh));
			if ($a != "")
			{
				$item = new Forum($a);
				if ($item->getForumId() != $_GET['forumId'])
				{
					fwrite($fhTemp, $a."\n");
				}
			}
		}
		fclose($fh);
		fclose($fhTemp);
		
		unlink("db/forumList.dat");
		rename("db/forumListtemp.dat", "db/forumList.dat");
		
		unlink("db/Topics/".$_GET['forumId'].".dat");
		unlink("db/Topics/".$_GET['forumId']."sticky.dat");
		
		//***********************
		$fileC = file("db/forumStatistics.dat",FILE_IGNORE_NEW_LINES);
		$fileC[0] = trim($fileC[0]) - 1;
		$str = "";
		foreach ($fileC as $statistic)
		{
			$str .= $statistic."\n";
		}
		file_put_contents("db/forumStatistics.dat",$str);

	}
	header("Location: index.php");
?>
