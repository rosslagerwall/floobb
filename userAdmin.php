<?php
	include("common.php");
	
	outHtml1("User Admin");
	outHtml2("User Admin:","editUser.php?userId=".$_SESSION['user']->getUserId());
?>

		<table class='list' style="margin-top: 10px; margin-bottom: 10px; font-family: Trebuchet MS;">
			<tr>
				<td class='listname' style="background: url(images/bar.png) repeat-x; color: white;"><u>Username</u></td>
				<td class='listlevel' style="background: url(images/bar.png) repeat-x; color: white;"><u>Level</u></td>
				<td class='listbanned' style="background: url(images/bar.png) repeat-x; color: white;"><u>Banned</u></td>
			</tr>
		</table>
		
		<form action="userAdminExecute.php" method="post">
			<table class='list'>
				<?php
				
					$dir=dir("db/Users/");
					$count = 0;
					while ($filename = $dir->read())
					{
						if ($filename != "." && $filename != "..")
						{
							$temp = new User(file_get_contents("db/Users/".$filename));
							echo "<tr><td class='listname'>".$temp->getUserId()."</td>";
							echo "<td class='listlevel'><input type='text' name='".$temp->getUserId()."[]' value='".$temp->getLevel()."' /></td>";
							if ($temp->isBanned() == 'false')
							{
								$checked = "";
							}
							else
							{
								$checked = " checked";
							}
							echo "<td class='listlevel'><input type='checkbox' name='".$temp->getUserId()."[]' value='yes'".$checked." /></td></tr>";
							$count++;
						}
					}
					$dir->close();
				?>
			</table>
		
			<div id="submitDiv">
				<input type="submit" value="Update" />
			</div>
		</form>
<?php
	outHtml3();
?>
