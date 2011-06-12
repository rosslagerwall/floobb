<?php
	include("common.php");
	$fileC = file("db/forumList.dat");
	foreach ($fileC as $item)
	{
		$temp = new Forum($item);
		if ($temp->getForumId() == $_GET['forumId'])
		{
			$forum = $temp;
		}
	}
	
	outHtml1("Edit Foru");
?>

<!-- TinyMCE -->
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="tiny_mce_init.js"></script>

<?php
	outHtml2("Edit Forum:","index.php");
?>	
		<form action="forumListEditExecute.php?forumId=<?php echo $forum->getForumId(); ?>" method="post">
			<div id="forumDiv">
				Forum Name:<br />
				<input type="text" name="name" class="textboxes" value="<?php echo $forum->getForumName() ?>" /><br />
				Forum Description:<br />
				<div style="margin-top: 10px; margin-left: 5%;">
				<textarea name="description" class="textboxes" style="width: 95%; height: 150px"><?php echo $forum->getDescription() ?></textarea><br />
				</div>
				<?php
					if ($_GET['error'] == 1)
					{
						echo "<div class='error'>Please enter a forum name!</div>";
					}
					else if ($_GET['error'] == 2)
					{
						echo "<div class='error'>Please enter a forum description!</div>";
					}
				?>
				<input type="submit" value="Update" />
			</div>
		</form>
	
<?php
	outHtml3();
?>
