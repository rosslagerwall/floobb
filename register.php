<?php
	include("common.php");
	
	if ($_SESSION['loggedIn'] == true)
	{
		header("location: index.php");
		exit();
	}
	
	outHtml1("Register");
	outHtml2("Register","index.php",false);
?>

		<form method="POST" action="registerExecute.php">
			<table class='list'>
				<tr>
					<td class='listlefta'>Username</td>
					<td class='listrighta'><input type="text" name="username"></td>
				</tr>
				<tr>
					<td class='listlefta'>Password</td>
					<td class='listrighta'><input type="password" name="password"></td>
				</tr>
				<tr>
					<td class='listlefta'>Email Address</td>
					<td class='listrighta'><input type="text" name="email"></td>
				</tr>
				<tr>
					<td class='listlefta'>Hide Email</td>
					<td class='listrighta'><input type="checkbox" name="hideEmail" value="yes"></td>
				</tr>
			</table>
			<?php
				if ($_GET['badRegister'] == 1)
				{
					echo "<div style='margin-top: 10px' align='center'>Username already exists!</div>";
				}
				else if ($_GET['badRegister'] == 2)
				{
					echo "<div style='margin-top: 10px' align='center'>Please fill in username and password!</div>";
				}
				else if ($_GET['badRegister'] == 3)
				{
					echo "<div style='margin-top: 10px' align='center'>Username or password too short!</div>";
				}
				else if ($_GET['badRegister'] == 4)
				{
					echo "<div style='margin-top: 10px' align='center'>Bad email address!</div>";
				}
				else if ($_GET['badRegister'] == 5)
				{
					echo "<div style='margin-top: 10px' align='center'>Username must contain only letters, numbers and the underscore!</div>";
				}
			?>
			<div id='submitDiv'>
				<input type="submit" name="submit" value="Register">
			</div>
		</form>
		
<?php
	outHtml3();
?>
