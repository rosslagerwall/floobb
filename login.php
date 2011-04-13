<?php
	include("common.php");
	
	if ($_SESSION['loggedIn'] == true)
	{
		header("location: index.php");
		exit();
	}
	
	outHtml1("Login");
?>

<?php
	outHtml2("Login:","index.php",false);
?>

	<form method="POST" action="loginExecute.php">
		
			<table class='list'>
				<tr>
					<td class='listlefta'>Username</td>
					<td class='listrighta'><input type="text" name="username" /></td>
				</tr>
				<tr>
					<td class='listlefta'>Password</td>
					<td class='listrighta'><input type="password" name="password" /></td>
				</tr>
				<tr>
					<td class='listlefta'>Remember Me</td>
					<td class='listrighta'><input type="checkbox" name="remember" value="checked" /></td>
				</tr>
			</table>
			<?php
				if ($_GET['badLogin'] == '1')
				{
					echo '<div align="center" style="margin-top: 5px;">Incorrect Username and/or password!</div>';
				}
				else if ($_GET['badLogin'] == '2')
				{
					echo '<div align="center" style="margin-top: 5px;">Username is banned.</div>';
				}
			?>
			<div id="submitDiv">
				<input type="submit" name="submit" value="Login">
			</div>
		</form>

<?php
	outHtml3();
?>
