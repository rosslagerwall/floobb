<?php

/* A class representing a Poll. A Topic may have a Poll associated with it.

Each poll has a forumId, a topicId, a join date, an array of users who have
voted in the poll and a 2D array of option, no. of votes pairs and an end date.

The object is constructed from a string in the following format:
forumId
topicId
user1,user2,user3,...
option1,noOfVotes
option2,noOfVotes
option3,noOfVotes
...

Each Poll has a file in the directory identified by the topicId:
db/Topics/<topicId>/poll.dat

*/
class Poll
{
	private $forumId;
	private $topicId;
	private $users;
	private $options;
	private $endDate;
	
	public function __construct($str)
	{
		$strArr = explode("\n",$str);
		
		$this->forumId = $strArr[0];
		$this->topicId = $strArr[1];
		$this->users = explode(",",$strArr[2]);
		$this->endDate = $strArr[3];
		
		$this->options = array();
		for ($i = 4; $i < sizeOf($strArr); $i++)
		{
			if (trim($strArr[$i]) != "")
			{
				array_push($this->options,explode(",",$strArr[$i]));
			}
		}
	}

	public function getTopicId()
	{
		return $this->topicId;
	}
	
	public function getForumId()
	{
		return $this->forumId;
	}
	
	public function getEndDate()
	{
		return $this->endDate;
	}
	
	public function getUsers()
	{
		return $this->users;
	}
	
	public function getOptions()
	{
		return $this->options;
	}
	
	public function addUser($name)
	{
		array_push($this->users, $name);
	}
	
	public function incOption($num)
	{
		$this->options[$num][1] = trim($this->options[$num][1]) + 1;
	}
	
	public function toString()
	{
		$str = $this->forumId."\n".$this->topicId."\n".implode(",",$this->users)."\n".$this->endDate."\n";
		
		foreach ($this->options as $option)
		{
			$str .= $option[0].",".$option[1]."\n";
		}
		$str = substr($str,0,strlen($str)-1);
		return $str;
	}
}

?>
