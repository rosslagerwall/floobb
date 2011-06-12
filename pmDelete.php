<?php
	include("common.php");
	
	$fileC = file("db/PMs/".$_SESSION['user']->getUserId().".dat",FILE_IGNORE_NEW_LINES);
	
	$str = "";
	foreach ($fileC as $line)
	{
		$temp = new PM($line);
		if ($temp->getMessageId() != $_GET['messageId'])
		{
			$str .= $line."\n";
		}
	}
	file_put_contents("db/PMs/".$_SESSION['user']->getUserId().".dat",$str);
	
	header("location: pmInbox.php");
?>
