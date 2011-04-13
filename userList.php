<?php
	include("common.php");
	
	outHtml1("User List");
	outHtml2("User List:","index.php");
?>
		<table class='list' style="margin-top: 10px; margin-bottom: 10px; font-family: Trebuchet MS;">
			<tr>
				<td class='listcell' style="background: url(images/bar.png) repeat-x; color: white;"><u>Username</u></td>
			</tr>
		</table>
		
		<table class='list'>
		<?php
		
			$dir=dir("db/Users/");
			while ($filename = $dir->read())
			{
				if ($filename != "." && $filename != "..")
				{
					$temp = new User(file_get_contents("db/Users/".$filename));
					echo "<tr><td class='listcell'><a href='viewUser.php?userId=".$temp->getUserId()."'>".$temp->getUserId()."</a></td>";
				}
			}
			$dir->close();
		?>
		</table>

<?php
	outHtml3();
?>
