<?php
	include("common.php");
	include_once("class.Poll.php");
	
	$topic = new Topic(file_get_contents("db/Topics/".$_GET['topicId']."/topic.dat"));
	
	outHtml1($topic->getTopicName());
?>

<!-- TinyMCE -->
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="tiny_mce_init.js"></script>
<script type="text/javascript">
	function addQuote(row)
	{
		var str = document.getElementById("tbl").rows[row].cells[2].innerHTML;
		if (str.lastIndexOf("<div class=") == -1)
		{
			str = str.substring(str.indexOf("Quote</a")+9);
		}
		else
		{
			str = str.substring(str.indexOf("Quote</a")+9,str.lastIndexOf("<div class="));
		}
		return "<blockquote class='quote'><span style='font-size: 12px; font-weight: bold;'>Quote: "+ document.getElementById("tbl").rows[row].cells[0].firstChild.innerHTML +"</span><hr />"+ str +"</blockquote>";
	}
</script>

<?php
	outHtml2($_SESSION['forum']->getForumName(),"viewTopics.php?forumId=".$_SESSION['forum']->getForumId());

			if ($_SESSION['loggedIn'] == true)
			{
				if ($_SESSION['user']->getLevel() > 1)
				{
					echo "<div id='adminControls'>Moderator Controls: ";
					if ($topic->isLocked() == "false")
					{
						echo "<a href='lockExecute.php?mode=lock&topicId=".$_GET["topicId"]."'>Lock</a>&nbsp";
					}
					else
					{
						echo "<a href='lockExecute.php?mode=unlock&topicId=".$_GET["topicId"]."'>Unlock</a>&nbsp";
					}
					if ($topic->isSticky() == "false")
					{
						echo "<a href='stickyExecute.php?mode=sticky&forumId=".$_SESSION['forum']->getForumId()."&topicId=".$_GET["topicId"]."'>Sticky</a>&nbsp";
					}
					else
					{
						echo "<a href='stickyExecute.php?mode=unsticky&forumId=".$_SESSION['forum']->getForumId()."&topicId=".$_GET["topicId"]."'>Unsticky</a>&nbsp";
					}
					echo "</div>";
				}
			}
		?>
		
		<table class='list' style="margin-top: 10px; margin-bottom: 10px; font-family: Trebuchet MS;">
			<tr>
				<td class='listuser' style="background: url(images/bar.png) repeat-x; color: white;"><u>User</u></td>
				<td class='listdate' style='font-size: 12px; padding: 10px 0px 10px 0px; background: url(images/bar.png) repeat-x; color: white;'><u>Date</u></td>
				<td class='listmessage' style="background: url(images/bar.png) repeat-x; color: white;"><u>Post</u></td>
			</tr>
		</table>
		
		<?php
			
			$tpId = $_GET["topicId"];
			
			$postArr = array();
			
			$fileC = file("db/Topics/".$tpId."/posts.dat");
			
			foreach ($fileC as $line)
			{ 
				array_push($postArr, new Post($line));
			}
			
			if (file_exists("db/Topics/".$tpId."/poll.dat"))
			{
				$poll = new Poll(file_get_contents("db/Topics/".$tpId."/poll.dat"));
				echo "<div id='pollDiv'>";
				$sum = 0;
				$str = "";
				$optionArr = $poll->getOptions();
				foreach ($optionArr as $option)
				{
					$sum += $option[1];
					$str .= $option[1].",";
				}
				$str = substr($str,0,strlen($str)-1);
				
				if ($sum == 0)
				{
					echo "No votes yet.<br /><br />";
				}
				else
				{
					echo "<img src='createImage.php?values=".$str."' /><br /><br />";
					$color[0] = "red";
					$color[1] = "green";
					$color[2] = "blue";
					$color[3] = "#AABBCC";
					$color[4] = "black";
					$color[5] = "#2affed";
					$color[6] = "#ffd8bc";
					$color[7] = "#daffbc";
					$color[8] = "#ff12a9";
					$color[9] = "#762e2e";
					
					for ($i = 0; $i < sizeOf($optionArr); $i++)
					{
						echo "<span style='color: ".$color[$i]."'>".$optionArr[$i][0].": ".$optionArr[$i][1]."</span><br />";
					}
		
				}
			
				if ($_SESSION['loggedIn'] && (time() < strtotime($poll->getEndDate()) || $poll->getEndDate() == "") && $topic->isLocked() == 'false')
				{
					if (!in_array($_SESSION['user']->getUserId(),$poll->getUsers()))
					{
						echo "<br /><div id='options'><form name='poll' action='voteExecute.php?topicId=".$tpId."' method='post'>";
						for ($i = 0; $i < sizeOf($optionArr); $i++)
						{
							echo "<input type='radio' name='option' value='$i' />".$optionArr[$i][0]."<br />";
						}
						echo "<input type='submit' value='Vote' />";
						echo "</form></div>";
					}
				}
				echo "</div>";
			}
			
			echo "<table id='tbl' class='list'>";
			$count = 0;
			foreach ($postArr as $key => $item)
			{
				$count++;
				$sig = "";
				if (trim($item->getUser()->getSig()) != "")
				{
					$sig = "<div class='sig'>".trim($item->getUser()->getSig())."</div>";
				}
				$avatarStr = "";
				if ($item->getUser()->getAvatar() != "")
				{
					$avatarStr = "<img style='padding-top: 5px;' src='".$item->getUser()->getAvatar()."' />";
				}
				$deleteStr = "";
				if ($_SESSION['loggedIn'] == true && $_SESSION['user']->getLevel() > 1 && sizeOf($postArr) > 1)
				{
					$deleteStr = "<a class='delete' href='moderate.php?flag=post&postId=".$item->getPostId()."&topicId=".$_GET['topicId']."'>delete</a><br />";			
				}
				
				if ($_SESSION['loggedIn'] == true && $_SESSION['user']->getLevel() > 1)
				{
					$deleteStr .= "<a class='delete' href='editPost.php?postId=".$key."&topicId=".$_GET['topicId']."'>edit</a><br />";
				}
				if ($_SESSION['loggedIn'] == true)
				{
					$deleteStr .= '<a class="delete" href="javascript:;" onClick="tinyMCE.execCommand(\'mceInsertContent\',false,addQuote('.$key.'));">Quote</a>';
				}
				echo "<tr><td class='listuser'><a href='viewUser.php?userId=".$item->getUser()->getUserId()."'>".$item->getUser()->getUserId()."</a><br />".$avatarStr."</td>
					<td class='listdate'>".$item->getDateTime()."</td>
					<td class='listmessage'>".$deleteStr.$item->getMessage().$sig."</td></tr>";
				$count = $item->getPostId()+1;
			}
			echo "</table>";
		?>
		
		<?php
			if ($_SESSION['loggedIn'] == true && $topic->isLocked() == "false")
			{
				?>
					<form action="postExecute.php?topicId=<?php echo $_GET['topicId']."&postId=".$count; ?>" method="post" onsubmit="return verify(this);">
						<div id='replyId'>
							Post Reply:<br />
							<div id="imageInfo">Images may be no bigger than 600 x 600 and 200kB.</div>
							<textarea id="reply" name="reply" style="width: 100%; height: 350px;"></textarea>
							<?php
								if ($_GET['error'] == 1)
								{
									echo "<div class='error'>Please enter a post!</div>";
								}
							?>
							<input type='submit' value='Reply' id="submitId" />
						</div>
					</form>
					<?php
			}
	outHtml3();
?>
