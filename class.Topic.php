<?php
class Topic
{
	private $topicId;
	private $forumId;
	private $userId;
	private $dateTime;
	private $posts;
	private $topicName;
	private $locked;
	private $sticky;
	
	public function __construct($str)
	{
		$arr = explode("\n",$str);
		$this->forumId = trim($arr[0]);
		$this->topicId = trim($arr[1]);
		$this->userId = trim($arr[2]);
		$this->dateTime = trim($arr[3]);
		$this->posts = trim($arr[4]);
		$this->topicName = trim($arr[5]);
		$this->locked = trim($arr[6]);
		$this->sticky = trim($arr[7]);
	}
	
	public function getForumId()
	{
		return $this->forumId;
	}
	
	public function getTopicId()
	{
		return $this->topicId;
	}
	
	public function getUser()
	{
		return new User(file_get_contents("db/Users/".$this->userId.".dat"));
	}
	
	public function getDateTime()
	{
		return $this->dateTime;
	}
	
	public function getTopicName()
	{
		return $this->topicName;
	}
	
	public function getTotalPosts()
	{
		return $this->posts;
	}
	
	public function getLatestPost()
	{
		$fileC = file("db/Topics/".$this->topicId."/posts.dat");
		return new Post(array_pop($fileC));
	}
	
	public function isLocked()
	{
		return $this->locked;
	}
	
	public function isSticky()
	{
		return $this->sticky;
	}
}

?>
