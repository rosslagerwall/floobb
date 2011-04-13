<?php
	$_POST['subject'] = str_replace("~","",$_POST['subject']);
	$_POST['message'] = str_replace("~","",$_POST['message']);
	if (trim(stripslashes($_POST['subject'])) == "")
	{
		header("Location: pmCompose.php?userId=".$_GET['userId']."&error=1");
		exit();
	}

	include("common.php");
	
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
	
	$fileC = file("db/PMs/".$_GET['userId'].".dat");
			
	$temp = new PM(array_pop($fileC));
	
	$str = $temp->getMessageId()+1;
	$str .= "~".$_SESSION['user']->getUserId();
	$str .= "~".$_GET['userId'];
	$str .= "~".date("G:i:s, j M Y");
	$str .= "~false";
	$str .= "~".htmlentities(stripslashes($_POST['subject']));
	
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
	
	if (trim(stripslashes($postString)) == "" || trim(stripslashes($postString)) == "<p></p>")
	{
		header("Location: pmCompose.php?userId=".$_GET['userId']."&error=2");
		exit();
	}
	
	$str .= "~".$postString;
	
	$fh = fopen("db/PMs/".$_GET['userId'].".dat","a");
	fwrite($fh, $str."\n");
	fclose($fh);
	
	header("location: pmInbox.php");
?>
