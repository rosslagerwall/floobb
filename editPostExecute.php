<?php

	$_POST['message'] = str_replace("~","",$_POST['message']);
	
	include_once("class.Post.php");
	include_once("class.Topic.php");
	include_once("class.Forum.php");
	include_once("class.User.php");
	session_start();
	
	include_once("function.misc.php");
	
	$str = "";
	$fileC = file("db/Topics/".$_GET['topicId']."/posts.dat",FILE_IGNORE_NEW_LINES);
	
	foreach ($fileC as $line)
	{
		$temp = new Post($line);
		if ($_GET["postId"] == $temp->getPostId())
		{
			$postArr = explode("~",$line);
			
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
			
			if ($postString == "")
			{
				header("Location: editPost.php?postId=".$_GET["postId"]."&topicId=".$_GET['topicId']."&error=1");
				exit();
			}
			
			$postArr[5] = $postString;
			$str .= trim(implode("~",$postArr))."\n";
		}
		else
		{
			$str .= $line."\n";
		}
	}
	file_put_contents("db/Topics/".$_GET['topicId']."/posts.dat",$str);
	header('Location: viewPosts.php?topicId='.$_GET['topicId']);
?>
