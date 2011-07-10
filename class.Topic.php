<?php

/* A class representing a single topic. Each message in a topic is a post.

Each topic has a topicId, a forumId, a userId, a dateTime, a total number of
posts, a boolean variable indicating whether the topic is locked or not and a
boolean variable indicating whether it is a "sticky" topic or not.

The noOfPosts is cached here for performance reasons instead of recounting the
number of posts each time it is required.

The object is constructed from a string in the following format:
forumId
topicId
userId
dateTime
noOfPosts
topicName
isLocked
isSticky

Each topic has a directory consisting of the topic string:
db/Topics/<topicId>/topic.dat
and the posts:
db/Topics/<topicId>/posts.dat

*/
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
	
	/* Loads a User object of the user who created this Topic */
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
	
	/* Load a Post object of the most recent post in the Topic.
	This is used to get the dateTime of the most recent post in this topic
	for display in various places. */
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
