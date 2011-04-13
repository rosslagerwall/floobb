<?php
	include("common.php");
	
	$fileC = file("db/Topics/".$_GET['topicId']."/posts.dat",FILE_IGNORE_NEW_LINES);
	foreach ($fileC as $line)
	{
		$temp = new Post($line);
		if ($temp->getPostId() == $_GET['postId'])
		{
			$actual = $temp;
		}
	}
	
	outHtml1("Edit Post");
?>

<!-- TinyMCE -->
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="tiny_mce_init.js"></script>

<?php
	outHtml2("Edit Post:","viewPosts.php?topicId=".$actual->getTopicId());
?>
		
		<form action="editPostExecute.php?topicId=<?php echo $_GET['topicId'] ?>&postId=<?php echo $_GET['postId'] ?>" method="post">
			<div id="messageDiv">
				Post Message:<br />
				<textarea name="message"><?php echo trim($actual->getMessage()); ?></textarea><br />
				<?php
					if ($_GET['error'] == 1)
					{
						echo "<div class='error'>Please enter a post!</div>";
					}
				?>
				<input type="submit" value="Change" />
			</div>
		</form>
<?php
	outHtml3();
?>
