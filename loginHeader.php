<?php

	if ($_SESSION['loggedIn'] == true)
	{
		echo "Logged in as <a href='editUser.php?userId=".$_SESSION['user']->getUserId()."'>".$_SESSION['user']->getUserId()."</a><br />";
		$fileC = file("db/PMs/".$_SESSION['user']->getUserId().".dat");
			
		$messageNo = 0;
		foreach ($fileC as $line)
		{
			$temp = new PM($line);
			if ($temp->isRead() == 'false')
			{
				$messageNo++;
			}
		}
		if ($messageNo > 0)
		{
			$inboxStr = " (".$messageNo.")";
		}
		else
		{
			$inboxStr = "";
		}
		echo "<a href='pmInbox.php'>Inbox".$inboxStr."</a>";
		echo '<br /><a href="logout.php">Logout</a>';
	}
	else
	{
		echo '<a href="login.php">Login</a> or <a href="register.php">Register</a>';
	}
?>
