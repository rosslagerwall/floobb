<?php
	if ($_GET['mode'] == 'lock')
	{
		$fileC = file("db/Topics/".$_GET['topicId']."/topic.dat",FILE_IGNORE_NEW_LINES);
		$fileC[6] = "true";
		$str = "";
		foreach ($fileC as $temp)
		{
			$str .= $temp."\n";
		}
		//echo "<xmp>$str</xmp>";
		file_put_contents("db/Topics/".$_GET['topicId']."/topic.dat",$str);
		
		header("location: viewPosts.php?topicId=".$_GET['topicId']);
	}
	else if ($_GET['mode'] == 'unlock')
	{
		$fileC = file("db/Topics/".$_GET['topicId']."/topic.dat",FILE_IGNORE_NEW_LINES);
		$fileC[6] = "false";
		$str = "";
		foreach ($fileC as $temp)
		{
			$str .= $temp."\n";
		}
		//echo "<xmp>$str</xmp>";
		file_put_contents("db/Topics/".$_GET['topicId']."/topic.dat",$str);
		
		header("location: viewPosts.php?topicId=".$_GET['topicId']);
	}
?>
