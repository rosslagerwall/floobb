<?php
	include("common.php");
	
	if ($_SESSION['user']->getUserId() != $_GET['userId'])
	{
		header("Location: index.php");
	}
	
	outHtml1("Edit Your Profile");
?>
<!-- TinyMCE -->
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="tiny_mce_init.js"></script>

<?php
	outHtml2("Edit Your Profile","index.php");
?>

		<form method="post" action="editExecute.php">
			<table class='list'>
				<?php

					$temp = new User(file_get_contents("db/Users/".$_GET['userId'].".dat"));
					echo "<tr><td class='listleftb'>Name</td><td colspan='2' class='listrightb'>".$temp->getUserId()."</td></tr>";
					echo "<tr><td class='listleftb'>Password</td><td colspan='2' class='listrightb'><input type='password' class='inputBox' name='password' value='".$temp->getPassword()."' /></td></tr>";
					echo "<tr><td class='listleftb'>Email Address</td><td colspan='2' class='listrightb'><input type='text' class='inputBox' name='email' value='".$temp->getEmail()."' /></td></tr>";
					echo "<tr><td class='listleftb'>Join Date</td><td colspan='2' class='listrightb'>".$temp->getJoinDate()."</td></tr>";
					echo "<tr><td class='listleftb'>No Of Posts</td><td colspan='2' class='listrightb'>".$temp->getNoPosts()."</td></tr>";
					echo "<tr><td class='listleftb'>No Of Topics</td><td colspan='2' class='listrightb'>".$temp->getNoTopics()."</td></tr>";
					echo "<tr><td class='listleftb'>Level</td><td colspan='2' class='listrightb'>".$temp->getLevel()."</td></tr>";
					echo "<tr><td class='listleftb'>Signature</td><td colspan='2' class='listrightb'><textarea name='sig'>".$temp->getSig()."</textarea></td></tr>";
					if ($temp->ishideEmail())
					{
						$hideEmail = " checked";
					}
					echo "<tr><td class='listleftb'>Hide Email</td><td colspan='2' class='listrightb' style='text-align: center;'><input type='checkbox' name='hideEmail' value='yes'".$hideEmail." /></td></tr>";
					if ($temp->getAvatar() != "")
					{
						$imgAvatar = "<img src='".$temp->getAvatar()."' />";
					}
					else
					{
						$imgAvatar = "";
					}
					echo "<tr><td class='listleftb'>Avatar</td><td class='listrightb'><input type='text' style='width: 265px' name='avatar' value='".$temp->getAvatar()."' /></td>
						<td style='background-color: #e9f3ff; padding: 10px 0px 10px 20px; border-left: 1px solid;'>".$imgAvatar."</td></tr>";

					
				?>
			</table>
			
			<?php
				if ($_SESSION['user']->getLevel() == 3)
				{
					echo "<div align='center' style='margin-top: 5px;'><a href='userAdmin.php'>User Admin</a><br /><a href='editBoardSettings.php'>Edit Board Settings</a></div>";
				}
			?>
			<?php
				if ($_GET['error'] == 1)
				{
					echo "<div class='error'>Please enter a valid email address!</div>";
				}
				if ($_GET['error'] == 2)
				{
					echo "<div class='error'>Please enter a password longer than 2 characters!</div>";
				}
			?>
			<div id="submitDiv"><input type="submit" value="Update" /></div>
		</form>
	
<?php
	outHtml3();
?>
