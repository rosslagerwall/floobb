<?php
	include("common.php");
	
	outHtml1("Add Forum");
?>

<!-- TinyMCE -->
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="tiny_mce_init.js"></script>

<?php
	outHtml2("Add Forum:", "index.php");
?>
		<form action="addForumExecute.php" method="post">
			<table class="tbl">
				<tr>
					<td class="tblleft">Forum Name</td>
					<td class="tblright"><input type="text" name="name"/></td>
				</tr>
				<tr>
					<td class="tblleft">Forum Description</td>
					<td class="tblright">
					<div style="margin-left: 1%; padding: 0;"><textarea name="description" id="description"></textarea></div>
					</td>
				</tr>
			</table>
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
			<div id="submitDiv"><input type="submit" value="Add Forum" /></div>
		</form>
<?php	
	outHtml3();
?>
