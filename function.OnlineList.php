<?php
	function addUser($userName)
	{
		$fileC = file("db/forumOnlineUsers.dat",FILE_IGNORE_NEW_LINES);
		
		$updated = false;
		for ($i = 0; $i < sizeOf($fileC); $i += 2)
		{
			if ($fileC[$i] == $userName)
			{
				$fileC[$i+1] = time();
				$updated = true;
			}
		}
		
		if (!$updated)
		{
			array_push($fileC, $userName);
			array_push($fileC, time());
		}
		
		$str = "";
		foreach ($fileC as $line)
		{
			$str .= $line."\n";
		}
		file_put_contents("db/forumOnlineUsers.dat",$str);
	}
	
	function addGuest($ip)
	{
		$fileC = file("db/forumOnlineGuests.dat",FILE_IGNORE_NEW_LINES);
		
		$updated = false;
		for ($i = 0; $i < sizeOf($fileC); $i += 2)
		{
			if ($fileC[$i] == $ip)
			{
				$fileC[$i+1] = time();
				$updated = true;
			}
		}
		
		if (!$updated)
		{
			array_push($fileC, $ip);
			array_push($fileC, time());
		}
		
		$str = "";
		foreach ($fileC as $line)
		{
			$str .= $line."\n";
		}
		file_put_contents("db/forumOnlineGuests.dat",$str);
	}

	function purge()
	{
		$fileC = file("db/forumOnlineGuests.dat",FILE_IGNORE_NEW_LINES);
		$str = "";
		for ($i = 0; $i < sizeOf($fileC)-1; $i += 2)
		{
			if (time() - $fileC[$i+1] <= 300)
			{
				$str .= $fileC[$i]."\n".$fileC[$i+1]."\n";
			}
		}
		if (trim($str) != "")
		{
			file_put_contents("db/forumOnlineGuests.dat",$str);
		}
		else
		{
			file_put_contents("db/forumOnlineGuests.dat","");
		}
		
		$fileC = file("db/forumOnlineUsers.dat",FILE_IGNORE_NEW_LINES);
		$str = "";
		for ($i = 0; $i < sizeOf($fileC)-1; $i += 2)
		{
			if (time() - $fileC[$i+1] <= 300)
			{
				$str .= $fileC[$i]."\n".$fileC[$i+1]."\n";
			}
		}
		if (trim($str) != "")
		{
			file_put_contents("db/forumOnlineUsers.dat",$str);
		}
		else
		{
			file_put_contents("db/forumOnlineUsers.dat","");
		}
	}
	
	function removeUser($userName)
	{
		$fileC = file("db/forumOnlineUsers.dat",FILE_IGNORE_NEW_LINES);
		$str = "";
		for ($i = 0; $i < sizeOf($fileC)-1; $i += 2)
		{
			if ($fileC[$i] != $userName)
			{
				$str .= $fileC[$i]."\n".$fileC[$i+1]."\n";
			}
		}
		if (trim($str) != "")
		{
			file_put_contents("db/forumOnlineUsers.dat",$str);
		}
		else
		{
			file_put_contents("db/forumOnlineUsers.dat","");
		}
	}
	
	function removeGuest($ip)
	{
		$fileC = file("db/forumOnlineGuests.dat",FILE_IGNORE_NEW_LINES);
		$str = "";
		for ($i = 0; $i < sizeOf($fileC)-1; $i += 2)
		{
			if ($fileC[$i] != $ip)
			{
				$str .= $fileC[$i]."\n".$fileC[$i+1]."\n";
			}
		}
		if (trim($str) != "")
		{
			file_put_contents("db/forumOnlineGuests.dat",$str);
		}
		else
		{
			file_put_contents("db/forumOnlineGuests.dat","");
		}
	}
?>
