<?php
	if (file_exists("install.php"))
	{
		header("Location: install.php");
	}
	include("common.php");
	
	outHtml1("Forum Index");

	outHtml2("Forum Index:");
?>
		<table class='list' style="margin-top: 10px; margin-bottom: 10px; font-family: Trebuchet MS;">
		<tr><td class="listLeft" style="background: url(images/bar.png) repeat-x; color: white;"><u>Forum</u></td><td class='listRight' style="background: url(images/bar.png) repeat-x; color: white;"><u>No. Posts</u></td></tr>
		</table>
		
		<?php
			
			$forumArr = array();
			$fileC = file("db/forumList.dat",FILE_IGNORE_NEW_LINES);
			
			foreach ($fileC as $line)
			{
				array_push($forumArr, new Forum($line));
			}
			
			echo "<table class='list'>";
			foreach ($forumArr as $count => $item)
			{
				$insertStr = "";
				if ($_SESSION['loggedIn'] == true && $_SESSION['user']->getLevel() == 3)
				{
					if ($count == 0)
					{
						$insertStr = "<span class='controls'><a href='forumListChange.php?mode=down&forumId=".$item->getForumId()."'>down</a> <a href='forumListEdit.php?forumId=".$item->getForumId()."'>edit</a> <a href='forumListChange.php?mode=delete&forumId=".$item->getForumId()."'>delete</a></span>";
					}
					else if ($count == sizeOf($forumArr)-1)
					{
						$insertStr = "<span class='controls'><a href='forumListChange.php?mode=up&forumId=".$item->getForumId()."'>up</a> <a href='forumListEdit.php?forumId=".$item->getForumId()."'>edit</a> <a href='forumListChange.php?mode=delete&forumId=".$item->getForumId()."'>delete</a></span>";
					}
					else
					{
						$insertStr = "<span class='controls'><a href='forumListChange.php?mode=up&forumId=".$item->getForumId()."'>up</a> <a href='forumListChange.php?mode=down&forumId=".$item->getForumId()."'>down</a> <a href='forumListEdit.php?forumId=".$item->getForumId()."'>edit</a> <a href='forumListChange.php?mode=delete&forumId=".$item->getForumId()."'>delete</a></span>";
					}
				}
				echo "<tr>
				<td class='listleft'><a href='viewTopics.php?forumId=".$item->getForumId()."'>".$item->getForumName()."</a>".$insertStr."<br />".$item->getDescription()."</td>
						<td class='listright'>".$item->getTotalPosts()."</td>
					</tr>";	
			}
			echo "</table>";
			
			if ($_SESSION['loggedIn'] && $_SESSION['user']->getLevel() == 3)
			{
				echo '<div style="margin-left: 5%; margin-top: 10px;"><a href="addForum.php">Add Forum</a></div>';
			}
		?>
		
		<?php
			$fileC = file("db/forumStatistics.dat",FILE_IGNORE_NEW_LINES);
		?>
		<div id="statistics">
			Forums: <?php echo $fileC[0]; ?>&nbsp;&nbsp;
			Topics: <?php echo $fileC[1]; ?>&nbsp;&nbsp;
			Posts: <?php echo $fileC[2]; ?>&nbsp;&nbsp;
			<a href="userList.php" id="regUsers">Registered Users:</a> <?php echo $fileC[3]; ?>&nbsp;&nbsp;
			Newest User: <?php echo $fileC[4]; ?>&nbsp;&nbsp;
			<br />
			<?php
				purge();
				$fileC = file("db/forumOnlineUsers.dat",FILE_IGNORE_NEW_LINES);
				echo "Online Users: ".(sizeOf($fileC)/2)."&nbsp;&nbsp;";
				$fileC = file("db/forumOnlineGuests.dat",FILE_IGNORE_NEW_LINES);
				echo "Online Guests: ".(sizeOf($fileC)/2)."&nbsp;&nbsp;";
			?>
		</div>
<?php
	outHtml3();
?>
