<?php

/* A class representing a single Forum. Each Forum contains a number of topics.
In other words, it is the largest category.

Each forum has a forumId, a forum name, a description, a number of posts and a
number of topics.

The noOfTopics and noOfPosts are cached here for performance reasons instead of
recounting the number of posts each time it is required.

The object is constructed from a string in the following format:
forumId~forumName~description~noOfTopics~noOfPosts

Each forum is a line in a file:
db/forumList.dat

*/
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
