<?php
	include("common.php");
	
	$fileC = file("db/forumList.dat");
			
	foreach ($fileC as $line)
	{
		$temp = new Forum($line);
		if ($temp->getForumId() == $_GET['forumId'])
		{
			$forum = $temp;
		}
	}
	$_SESSION['forum'] = $forum;
	
	outHtml1($forum->getForumName());
	outHtml2($forum->getForumName(),"index.php");
?>
		<table class='list' style="margin-top: 10px; margin-bottom: 10px; font-family: Trebuchet MS;">
			<tr>
				<td class='listtopicname' style="background: url(images/bar.png) repeat-x; color: white;"><u>Topic</u></td>
				<td class='listtopiccreator' style="background: url(images/bar.png) repeat-x; color: white;"><u>Creator</u></td>
				<td class='listtopicposts' style="background: url(images/bar.png) repeat-x; color: white;"><u>No. Posts</u></td>
				<td class='listtopicdate' style="font-size: 12px; background: url(images/bar.png) repeat-x; color: white;"><u>Date Last Post / Date Created</u></td>
			</tr>
		</table>
		<?php
			
			$frId = $_GET['forumId'];
			$topicsperpage = trim(file_get_contents("db/topicsperpage.dat"));
			
			if (!isset($_GET['page']))
			{
				$pageNo = 0;
			}
			else
			{
				$pageNo = $_GET['page'];
			}
			
			$topicArr = array();
			
			$fh = fopen("db/Topics/".$frId.".dat","r");
			
			for ($i = 0; $i < $pageNo*$topicsperpage; $i++)
			{
				fgets($fh);
				fgets($fh);
			}
			$count = 0;
			while ($count < $topicsperpage && !feof($fh))
			{
				$count++;
				$a = trim(fgets($fh));
				$b = trim(fgets($fh));
				if ($a != "" && $b != "")
				{
					array_push($topicArr,new Topic(file_get_contents("db/Topics/".$a."/topic.dat")));
				}
			}
			
			fclose($fh);
			
			$stickyTopicArr = array();
			$fh = fopen("db/Topics/".$frId."sticky.dat","r");

			while (!feof($fh))
			{
				$a = trim(fgets($fh));
				$b = trim(fgets($fh));
				if ($a != "" && $b != "")
				{
					array_push($stickyTopicArr,new Topic(file_get_contents("db/Topics/".$a."/topic.dat")));
				}
			}
			
			fclose($fh);

			echo "<table class='list'>";
			foreach ($stickyTopicArr as $item)
			{
				echo "<tr><td class='stickylistname'><a href='viewPosts.php?topicId=".$item->getTopicId()."'>Sticky: ".$item->getTopicName()."</a>".$deleteStr."</td>
					<td class='stickylistcreator'><a href='viewUser.php?userId=".$item->getUser()->getUserId()."'>".$item->getUser()->getUserId()."</a>
					<td class='stickylistposts'>".$item->getTotalPosts()."</td>
					<td class='stickylistdate'>".$item->getLatestPost()->getDateTime()."<br />".$item->getDateTime()."</td>
					</tr>";
			}
			foreach ($topicArr as $item)
			{
				$deleteStr = "";
				if ($_SESSION['loggedIn'] == true && $_SESSION['user']->getLevel() > 1)
				{
					$deleteStr = "<a class='deleteTopic' href='moderate.php?flag=topic&forumId=".$_GET['forumId']."&topicId=".$item->getTopicId()."'>delete</a><a class='deleteTopic' href='moveTopic.php?topicId=".$item->getTopicId()."&forumId=".$_GET['forumId']."'>move</a><a class='deleteTopic' href='editTopic.php?topicId=".$item->getTopicId()."'>edit</a>";
				}
				echo "<tr><td class='listtopicname'><a href='viewPosts.php?topicId=".$item->getTopicId()."'>".$item->getTopicName()."</a>".$deleteStr."</td>
					<td class='listtopiccreator'><a href='viewUser.php?userId=".$item->getUser()->getUserId()."'>".$item->getUser()->getUserId()."</a>
					<td class='listtopicposts'>".$item->getTotalPosts()."</td>
					<td class='listtopicdate'>".$item->getLatestPost()->getDateTime()."<br />".$item->getDateTime()."</td>
					</tr>";
			}
			echo "</table>";
		
			
			?>
				<div id="addTopic">
					<div style="float: right;">
					Page: 
					<?php
						if ($forum->getTotalTopics() <= $topicsperpage)
						{
							echo "1";
							$controlsStr = "";
						}
						else if ($forum->getTotalTopics() <= 2*$topicsperpage)
						{
							if ($pageNo == 0)
							{
								echo "1&nbsp;<a href='viewTopics.php?forumId=".$_GET['forumId']."&page=1'>2</a>";
								$controlsStr = "<a href='viewTopics.php?forumId=".$_GET['forumId']."&page=1'>Next</a>";
							}
							else
							{
								echo "<a href='viewTopics.php?forumId=".$_GET['forumId']."&page=0'>1</a>&nbsp;2";
								$controlsStr = "<a href='viewTopics.php?forumId=".$_GET['forumId']."&page=0'>Prev</a>";
							}
							
							
						}
						else
						{
							$maxPage = ceil($forum->getTotalTopics()/$topicsperpage)-1;
							if ($pageNo == 0)
							{
								echo "1&nbsp;...&nbsp;<a href='viewTopics.php?forumId=".$_GET['forumId']."&page=".$maxPage."'>".($maxPage+1)."</a>";
								$controlsStr = "<a href='viewTopics.php?forumId=".$_GET['forumId']."&page=".($pageNo+1)."'>Next</a>";
							}
							else if ($pageNo == $maxPage)
							{
								echo "<a href='viewTopics.php?forumId=".$_GET['forumId']."&page=0'>1</a>&nbsp;...&nbsp;".($maxPage+1);
								$controlsStr = "<a href='viewTopics.php?forumId=".$_GET['forumId']."&page=".($pageNo-1)."'>Prev</a>";
							}
							else
							{
								echo "<a href='viewTopics.php?forumId=".$_GET['forumId']."&page=0'>1</a>&nbsp;...&nbsp;".($pageNo+1)."&nbsp;...&nbsp;<a href='viewTopics.php?forumId=".$_GET['forumId']."&page=".$maxPage."'>".($maxPage+1)."</a>";
								$controlsStr = "<a href='viewTopics.php?forumId=".$_GET['forumId']."&page=".($pageNo-1)."'>Prev</a>&nbsp;<a href='viewTopics.php?forumId=".$_GET['forumId']."&page=".($pageNo+1)."'>Next</a>";
							}
						}
						
						echo "<br />".$controlsStr;
						
					?>
					</div>
					<?php
					if ($_SESSION['loggedIn'] == true)
					{
						?><a href="addTopic.php?forumId=<?php echo $_GET['forumId']?>">Add Topic</a><br />
						<a href="addPoll.php?forumId=<?php echo $_GET['forumId']?>">Add Poll</a><?php
					}
					?>
				</div>
		
<?php
	outHtml3();
?>
