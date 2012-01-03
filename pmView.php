<?php
	include("common.php");
	
	$fileC = file("db/PMs/".$_SESSION['user']->getUserId().".dat",FILE_IGNORE_NEW_LINES);
	
	$str = "";
	$statusChange = false;
	foreach ($fileC as $line)
	{
		$temp = new PM($line);
		if ($temp->getMessageId() == $_GET['messageId'])
		{
			$pm = $temp;
			if ($pm->isRead() == 'false')
			{
				$statusChange = true;
				$lineArr = explode("~",$line);
				$lineArr[4] = 'true';
				$str .= implode("~",$lineArr)."\n";
			}
		}
		else
		{
			$str .= $line."\n";
		}
	}
	
	if ($statusChange)
	{
		file_put_contents("db/PMs/".$_SESSION['user']->getUserId().".dat",$str);
	}
	
	outHtml1("View Message");
	outHtml2("View Message:","pmInbox.php");
?>
		
		<table class="tbl">
			<tr>
				<td class="tblleft">Sender</td>
				<td class="tblright"><?php echo "<a href='viewUser.php?userId=".$pm->getSender()->getUserId()."'>".$pm->getSender()->getUserId()."</a>" ?></td>
			</tr>
			<tr>
				<td class="tblleft">Date</td>
				<td class="tblright"><?php echo $pm->getDate() ?></td>
			</tr>
			<tr>
				<td class="tblleft">Subject</td>
				<td class="tblright"><?php echo $pm->getSubject() ?></td>
			</tr>
			<tr>
				<td class="tblleft">Message</td>
				<td class="tblright"><?php echo $pm->getMessage() ?></td>
			</tr>
		</table>
		<div id="controlDiv">
			<a href="pmDelete.php?&messageId=<?php echo htmlentities($_GET['messageId']) ?>">Delete</a>
		</div>
<?php
	outHtml3();
?>
