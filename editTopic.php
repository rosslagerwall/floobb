<?php
	include("common.php");
	
	$topic = new Topic(file_get_contents("db/Topics/".$_GET['topicId']."/topic.dat"));
	
	outHtml1("Edit Topic");
?>

<?php
outHtml2("Edit Topic:","viewTopics.php?forumId=".$topic->getForumId());
?>
		
		<form action="editTopicExecute.php?topicId=<?php echo $_GET['topicId']."&forumId=".$topic->getForumId(); ?>" method="post">
			<div id="topicDiv">
				Topic Name:<br />
				<input type="text" name="name" id="name" value="<?php echo $topic->getTopicName() ?>" /><br />
				<input type="submit" value="Update" />
				<?php
					if ($_GET['error'] == 1)
					{
						echo "<div class='error'>Please enter a topic name!</div>";
					}
				?>
			</div>
		</form>
	
<?php
	outHtml3();
?>
