<?php

/* A class representing a single post. Each message in a topic is a post.

Each post has a postId, a topicId, a forumId, a userId, a dateTime and a
message.

The object is constructed from a string in the following format:
forumId~topicId~postId~userId~dateTime~message

Each post is a line in a file called posts.dat:
db/Topics/<topicId>/posts.dat

*/
class Post
{
	private $postId;
	private $topicId;
	private $forumId;
	private $userId;
	private $dateTime;
	private $message;
	
	public function __construct($str)
	{
		$arr = explode("~",$str);
		$this->forumId = $arr[0];
		$this->topicId = $arr[1];
		$this->postId = $arr[2];
		$this->userId = $arr[3];
		$this->dateTime = $arr[4];
		$this->message = $arr[5];
	}
	
	public function getPostId()
	{
		return trim($this->postId);
	}
	
	public function getTopicId()
	{
		return trim($this->topicId);
	}
	
	public function getForumId()
	{
		return trim($this->forumId);
	}
	
	public function getMessage()
	{
		return trim($this->message);
	}
	
	public function getDateTime()
	{
		return $this->dateTime;
	}
	
	/* Loads a User object of the user who created this Post */
	public function getUser()
	{
		return new User(file_get_contents("db/Users/".$this->userId.".dat"));
	}
}

?>
