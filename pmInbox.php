<?php
	include("common.php");
	
	outHtml1("Inbox");
	outHtml2("Inbox:","index.php");
?>
				
		<table class='list' style="margin-top: 10px; margin-bottom: 10px; font-family: Trebuchet MS;">
			<tr>
				<td class='listsubject' style="background: url(images/bar.png) repeat-x; color: white;"><u>Subject</u></td>
				<td class='listsender' style="background: url(images/bar.png) repeat-x; color: white;"><u>Sender</u></td>
				<td class='listdate' style="font-size: 12px; padding: 10px 0px 10px 0px; background: url(images/bar.png) repeat-x; color: white;"><u>Date Sent</u></td>
			</tr>
		</table>
		
		<?php
				
			$fileC = file("db/PMs/".$_SESSION['user']->getUserId().".dat");
			$messageArr = array();
			foreach ($fileC as $line)
			{
				if (trim($line) != "")
				{
					array_push($messageArr, new PM($line));
				}
			}
			if (sizeOf($messageArr) > 0)
			{
				echo "<table class='list'>";
				$messageArr = array_reverse($messageArr);
				foreach ($messageArr as $item)
				{
					if ($item->isRead() == 'false')
					{
						$style = " style='font-weight: bold;'";
					}
					else
					{
						$style = "";
					}
					echo "<tr$style>
							<td class='listsubject'><a href='pmView.php?messageId=".$item->getMessageId()."'>".$item->getSubject()."</a></td>
							<td class='listsender'><a href='viewUser.php?userId=".$item->getSender()->getUserId()."'>".$item->getSender()->getUserId()."</td><td class='listdate'>".$item->getDate()."</td>
						</tr>";
				}
				echo "</table>";
			}
			else
			{
				echo "<div style='margin-left: 35px;'>No messages.</div>";
			}
		?>
		<div align="center" style="margin-top : 5px;"><a href="userList.php" id="regUsers">User List</a></div>
	
<?php
	outHtml3();
?>
