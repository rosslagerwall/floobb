<?php
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
