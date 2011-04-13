<?php
	if (trim(stripslashes($_POST['name'])) == "")
	{
		header("Location: editBoardSettings.php?error=1");
		exit();
	}
	if (trim(stripslashes($_POST['description'])) == "")
	{
		header("Location: editBoardSettings.php?error=2");
		exit();
	}
	if (!(trim(stripslashes($_POST['topics'])) >= 1))
	{
		header("Location: editBoardSettings.php?error=3");
		exit();
	}
	file_put_contents("db/boardname.dat",stripslashes($_POST['name']));
	file_put_contents("db/boarddescription.dat",stripslashes($_POST['description']));
	file_put_contents("db/topicsperpage.dat",$_POST['topics']);
	
	if ($_POST['smiley'] == 'yes')
	{
		$folderArr = array();
		if ($handle = opendir('tiny_mce/plugins/emotions/img'))
		{
			while (false !== ($file = readdir($handle)))
			{
				if ($file != "." && $file != "..") {
					array_push($folderArr, $file);
				}
			}
			closedir($handle);
		}
		
		$str = "";
		$str2 = "";
		foreach ($folderArr as $key => $folder)
		{
			$str .= "str[".$key."] = \"";
			if ($handle = opendir('tiny_mce/plugins/emotions/img/'.$folder))
			{
				while (false !== ($file = readdir($handle)))
				{
					if ($file != "." && $file != "..") {
						$str .= $file.",";
					}
				}
				closedir($handle);
				$str = substr($str,0,strlen($str)-1); //remove last comma
				
				$str .= "\";\n";
			}
			$temp = "";
			if (($key+1) % 3 == 0)
			{
				$temp = "<br />";
			}
			$str2 .= "<input type=\"button\" onClick='load(\"".$folder."/\",".$key.");' id=\"but".$key."\" value=\"".$folder."\" />".$temp."\n";
		}
		//echo "<xmp>".file_get_contents("tiny_mce/plugins/emotions/part1.txt").$str.file_get_contents("tiny_mce/plugins/emotions/part3.txt").$str2.file_get_contents("tiny_mce/plugins/emotions/part5.txt")."</xmp>";
		
		file_put_contents("tiny_mce/plugins/emotions/emotions.htm",file_get_contents("tiny_mce/plugins/emotions/part1.txt").$str.file_get_contents("tiny_mce/plugins/emotions/part3.txt").$str2.file_get_contents("tiny_mce/plugins/emotions/part5.txt"));
		
	}
	
	header("Location: editBoardSettings.php");
?>
