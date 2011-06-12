<?php
	include("common.php");
	
	outHtml1("Move Topic");
	outHtml2("Move Topic:",$_SERVER['HTTP_REFERER']);
?>
		
		<p style="margin-left: 5%;">Click on the forum to which the topic is going to be moved.</p>
		
		<table class='list' style="margin-top: 10px; margin-bottom: 10px; font-family: Trebuchet MS;">
			<tr><td class="listcell"  style="background: url(images/bar.png) repeat-x; color: white;"><u>Forum</u></td></tr>
		</table>
		
		<?php
			
			$forumArr = array();
			$fileC = file("db/forumList.dat");
			
			foreach ($fileC as $line)
			{
				$temp = new Forum($line);
				if ($temp->getForumId() != $_GET['forumId'])
				{
					array_push($forumArr, $temp);
				}
			}
			
			echo "<table class='list'>";
			foreach ($forumArr as $item)
			{
				echo "<tr>
						<td class='listcell'><a href='moveTopicExecute.php?oldForumId=".$_GET['forumId']."&topicId=".$_GET['topicId']."&forumId=".$item->getForumId()."'>".$item->getForumName()."</a></td>
					</tr>";	
			}
			echo "</table>";
		?>

<?php
	outHtml3();
?>
