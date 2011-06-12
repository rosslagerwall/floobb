<?php
	include("common.php");
	$dir=dir("db/Users/");
	while ($filename = $dir->read())
	{
		if ($filename != "." && $filename != "..")
		{
			$filename = substr($filename,0,strlen($filename)-4);
			$temp = new User(file_get_contents("db/Users/".$filename.".dat"));
			
			if ($temp->getLevel() != $_POST[$filename][0] || ($temp->isBanned() == 'false' && $_POST[$filename][1] == "yes") || ($temp->isBanned() != 'false' && $_POST[$filename][1] != "yes"))
			{
				$fileC = file("db/Users/".$filename.".dat",FILE_IGNORE_NEW_LINES);
				
				if ($_POST[$filename][0] == 1 || $_POST[$filename][0] == 2 || $_POST[$filename][0] == 3)
				{
					$fileC[6] = $_POST[$filename][0];
				}
				
				if ($_POST[$filename][1] == "yes")
				{
					$fileC[2] = "true";
				}
				else
				{
					$fileC[2] = "false";
				}
				
				$str = "";
				foreach ($fileC as $line)
				{
					$str .= $line."\n";
				}
				file_put_contents("db/Users/".$filename.".dat", $str);
			}
		}
	}

	header("location: userAdmin.php");
?>
