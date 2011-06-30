<?php
	function isValidEmail($email)
	{
		$pattern = "/^[\w\.=-]+@[\w\.-]+\.[\w]{2,3}$/";
		
		if (preg_match($pattern,$email) == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	if (isset($_POST['username']))
	{
		if (trim(stripslashes($_POST['boardname'])) == "" || trim(stripslashes($_POST['boarddescription'])) == "" || trim(stripslashes($_POST['username'])) == "" || trim(stripslashes($_POST['password'])) == "")	
		{
			unset($_POST['boardname']);
			unset($_POST['boarddescription']);
			unset($_POST['username']);
			unset($_POST['password']);
			unset($_POST['email']);
			header("Location: install.php?error=0");
		}
		else if (strlen(trim(stripslashes($_POST['username']))) < 3)
		{
			unset($_POST['boardname']);
			unset($_POST['boarddescription']);
			unset($_POST['username']);
			unset($_POST['password']);
			unset($_POST['email']);
			header("Location: install.php?error=1");
		}
		else if (strlen(trim(stripslashes($_POST['password']))) < 3)
		{
			unset($_POST['boardname']);
			unset($_POST['boarddescription']);
			unset($_POST['username']);
			unset($_POST['password']);
			unset($_POST['email']);
			header("Location: install.php?error=2");
		}
		else if (!isValidEmail(trim(stripslashes($_POST['email']))))
		{
			unset($_POST['boardname']);
			unset($_POST['boarddescription']);
			unset($_POST['username']);
			unset($_POST['password']);
			unset($_POST['email']);
			header("Location: install.php?error=3");
		}
		else if (preg_match("/^\w+$/",trim(stripslashes($_POST['username']))) != 1)
		{
			unset($_POST['boardname']);
			unset($_POST['boarddescription']);
			unset($_POST['username']);
			unset($_POST['password']);
			unset($_POST['email']);
			header("Location: install.php?error=4");
		}
	}
?>
<html>
<head>
<title>Install</title>
<link rel="stylesheet" type="text/css" href="basic.css" />
<style>
.list {
	table-layout: fixed;
	border-spacing: 0px;
	border-collapse: collapse;
	width: 90%;
	border: solid 1px;
	margin: auto;
	font-size: 12px;
	font-weight: normal;
	margin-top: 10px;
}

.list tr {
	border: solid 1px;
}

.listleft {
	background-color: #bfbfbf;
	border-right: 1px solid;
	width: 35%;
	padding: 10px 0px 10px 10px;
	font-family: "Trebuchet MS";
}

.listright {
	background-color: #e9f3ff;
	width: 65%;
	padding: 10px 0px 10px 10px;
}

.listright input {
	width: 98%;
	font-family: Verdana;
	font-size: 12px;
}

#submitDiv {
	text-align: center;
	width: 200px;
	margin: 10px auto auto auto;
}

.error {
	text-align: center;
	width: 500px;
	margin: 10px auto auto auto;
}
</style>
</head>
<body>
	<div class="bl"><div class="br"><div id="container">
		<div id="headingImage"><img src="images/heading.png" /></div></div>
		<div id="header" style="width: 90%">Install:<br />
		<p>Please ensure that the <i>db</i> directory has suitable write permissions
		otherwise the install will not succeed.</p>
		</div>
		<?php
			if (trim(file_get_contents("db/boardname.dat")) != "")
			{
				echo "<div style='margin-left:35px;'><p style='font-size: 16px; font-weight: bold;'>Board Setup successful!</p><p>Please ensure that install.php is deleted before using the board!</p>";
			}
			else if (!isset($_POST['username']))
			{
				?>
				
				<form method="POST" action="">
		
					<table class='list'>
						<tr>
							<td class='listleft'>Username</td>
							<td class='listright'><input type="text" name="username" /></td>
						</tr>
						<tr>
							<td class='listleft'>Password</td>
							<td class='listright'><input type="password" name="password" /></td>
						</tr>
						<tr>
							<td class='listleft'>Email Address</td>
							<td class='listright'><input type="text" name="email" /></td>
						</tr>
						<tr>
							<td class='listleft'>Board Name</td>
							<td class='listright'><input type="text" name="boardname" /></td>
						</tr>
						<tr>
							<td class='listleft'>Board Description</td>
							<td class='listright'><input type="text" name="boarddescription" /></td>
						</tr>
					</table>
					<?php
						if (isset($_GET['error']))
						{
							if ($_GET['error'] == 0)
							{
								echo "<div class='error'>Please fill in all fields!</div>";
							}
							if ($_GET['error'] == 1)
							{
								echo "<div class='error'>Username too short!</div>";
							}
							if ($_GET['error'] == 2)
							{
								echo "<div class='error'>Password too short!</div>";
							}
							if ($_GET['error'] == 3)
							{
								echo "<div class='error'>Bad email address!</div>";
							}
							if ($_GET['error'] == 4)
							{
								echo "<div class='error'>Username must contain only letters, numbers and the underscore!</div>";
							}
						}
					?>
					<div id="submitDiv">
						<input type="submit" name="submit" value="Install">
					</div>
				</form>
				<?php
			}
			else
			{
				mkdir("db/PMs");
				file_put_contents("db/boardname.dat",stripslashes($_POST['boardname']));
				file_put_contents("db/boarddescription.dat",stripslashes($_POST['boarddescription']));
				
				//*******************
				$userId = stripslashes($_POST['username']);
				$fileC = file("db/Users/user.dat",FILE_IGNORE_NEW_LINES);
				$fileC[0] = $userId;
				$fileC[1] = stripslashes($_POST['password']);
				$fileC[5] = date("j M Y");
				$fileC[8] = stripslashes($_POST['email']);
				$str = "";
				foreach ($fileC as $temp)
				{
					$str .= $temp."\n";
				}
				file_put_contents("db/Users/".$userId.".dat",$str);
				if ($userId != 'user')
				{
					unlink("db/Users/user.dat");
				}
				file_put_contents("db/PMs/".$userId.".dat","");
				
				//******************
				$fileC = file("db/forumStatistics.dat",FILE_IGNORE_NEW_LINES);
				$fileC[4] = $userId;
				$str = "";
				foreach ($fileC as $temp)
				{
					$str .= $temp."\n";
				}
				file_put_contents("db/forumStatistics.dat",$str);
				
				$str = file_get_contents("db/Topics/0/posts.dat");
				$str = str_replace("user", $userId, $str);
				file_put_contents("db/Topics/0/posts.dat", $str);
				
				$str = file_get_contents("db/Topics/0/topic.dat");
				$str = str_replace("user", $userId, $str);
				file_put_contents("db/Topics/0/topic.dat", $str);
				
				echo "<div style='margin-left:35px;'><p style='font-size: 16px; font-weight: bold;'>Board Setup successful!</p><p>Please ensure that install.php is deleted before using the board!</p>";
			}
			
		?>
		
	</div></div></div>
	<div id="copyright">&copy; 2011 - flooBB 1.2</div>
</body>
</html>
