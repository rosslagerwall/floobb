<?php
	include("common.php");
	
	outHtml1("Add Topic");
?>

<!-- TinyMCE -->
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="tiny_mce_init.js"></script>

<?php
	outHtml2("Add Topic:","viewTopics.php?forumId=".$_GET['forumId']);
?>
		
		<form action="addTopicExecute.php?forumId=<?php echo $_GET['forumId']?>" method="post">
			<table class="tbl">
				<tr>
					<td class="tblleft">Topic Name</td>
					<td class="tblright"><input type="text" name="topicName"/></td>
				</tr>
				<tr>
					<td class="tblleft">Message</td>
					<td class="tblright">
						<div id="imageInfo">Images may be no bigger than 600 x 600 and 200kB.</div>
						<textarea name="message" id="message" style="height: 300px;"></textarea>
					</td>
				</tr>
			</table>
			<?php
				if ($_GET['error'] == 1)
				{
					echo "<div class='error'>Please enter a topic name and a post!</div>";
				}
			?>
			<div id="submitDiv"><input type="submit" value="Add Topic" /></div>
		</form>
		
<?php
	outHtml3();
?>
