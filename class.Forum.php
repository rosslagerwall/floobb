<?php
class Forum
{
	private $forumId;
	private $forumName;
	private $description;
	private $posts;
	private $topics;
	
	public function __construct($str)
	{
		$arr = explode("~",$str);
		$this->forumId = trim($arr[0]);
		$this->forumName = trim($arr[1]);
		$this->description = trim($arr[2]);
		$this->topics = trim($arr[3]);
		$this->posts = trim($arr[4]);
	}
	
	public function getDescription()
	{
		return $this->description;
	}
	
	public function getForumId()
	{
		return trim($this->forumId);
	}
	
	public function getForumName()
	{
		return trim($this->forumName);
	}
	
	public function getTotalPosts()
	{
		return $this->posts;
	}
	
	public function getTotalTopics()
	{
		return $this->topics;
	}
}

?>
