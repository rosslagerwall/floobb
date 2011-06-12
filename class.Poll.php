<?php

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
