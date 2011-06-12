<?php

class PM
{
	private $sender;
	private $recipient;
	private $date;
	private $read;
	private $subject;
	private $message;
	private $messageId;
	
	public function __construct($str)
	{
		$arr = explode("~",$str);
		$this->messageId = $arr[0];
		$this->sender = $arr[1];
		$this->recipient = $arr[2];
		$this->date = $arr[3];
		$this->read = $arr[4];
		$this->subject = $arr[5];
		$this->message = $arr[6];
	}
	
	public function getMessageId()
	{
		return $this->messageId;
	}
	
	public function getMessage()
	{
		return $this->message;
	}
	
	public function getSender()
	{
		return new User(file_get_contents("db/Users/".$this->sender.".dat"));
	}
	
	public function getRecipient()
	{
		return $this->recipient;
	}
	
	public function getDate()
	{
		return $this->date;
	}
	
	public function getSubject()
	{
		return $this->subject;
	}
	
	public function isRead()
	{
		return $this->read;
	}
}

?>
