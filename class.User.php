<?php

/* A class representing a User.

Each user has a userId, a password, a join date, a level, a signature, an email
address, a boolean variable indicating whether their email address is visible
or not, an URL to their avatar (if any), a boolean variable indicating whether
they are banned or not, a number of topics and a number of posts.

The noOfTopics and noOfPosts are cached here for performance reasons instead of
recounting the number of posts each time it is required.

The object is constructed from a string in the following format:
userId
password
joinDate
level
sig
email
mustHideEmail
avatar
isBanned
noOfTopics
noOfPosts

Each User has a file in the Users directory identified by the users' name,
consisting of the user string:
db/Users/<username>.dat

*/
class User
{
	private $userId;
	private $password;
	private $joinDate;
	private $level;
	private $sig;
	private $email;
	private $hideEmail;
	private $avatar;
	private $banned;
	private $topics;
	private $posts;
	
	public function __construct($str)
	{
		$arr = explode("\n",$str);
		$this->userId = trim($arr[0]);
		$this->password = trim($arr[1]);
		$this->banned = trim($arr[2]);
		$this->topics = trim($arr[3]);
		$this->posts = trim($arr[4]);
		$this->joinDate = trim($arr[5]);
		$this->level = trim($arr[6]);
		$this->sig = trim($arr[7]);
		$this->email = trim($arr[8]);
		if (trim($arr[9]) == 1)
		{
			$this->hideEmail = true;
		}
		else
		{
			$this->hideEmail = false;
		}
		$this->avatar = trim($arr[10]);
	}
	
	public function getUserId()
	{
		return trim($this->userId);
	}
	
	public function getPassword()
	{
		return trim($this->password);
	}
	
	public function isBanned()
	{
		return $this->banned;
	}
	
	public function getJoinDate()
	{
		return trim($this->joinDate);
	}
	
	public function getLevel()
	{
		return trim($this->level);
	}
	
	public function getNoPosts()
	{
		return $this->posts;
	}
	
	public function getNoTopics()
	{
		return $this->topics;
	}
	
	public function getSig()
	{
		return $this->sig;
	}
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function isHideEmail()
	{
		return $this->hideEmail;
	}

	public function getAvatar()
	{
		return $this->avatar;
	}
}

?>
