<?php
	include("common.php");
	outHtml1("Compose");
?>
<!-- TinyMCE -->
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="tiny_mce_init.js"></script>

<?php
	outHtml2("Compose:","index.php");
?>
		
		<form action="pmComposeExecute.php?userId=<?php echo $_GET['userId']?>" method="post">
			<table class="tbl">
				<tr>
					<td class="tblleft">To</td>
					<td class="tblright"><?php echo $_GET['userId']?></td>
				</tr>
				<tr>
					<td class="tblleft">Subject</td>
					<td class="tblright"><input type="text" name="subject" /></td>
				</tr>
				<tr>
					<td class="tblleft">Message</td>
					<td class="tblright"><textarea name="message" style="height: 300px;"></textarea></td>
				</tr>
			</table>
			<?php
				if ($_GET['error'] == 1)
				{
					echo "<div class='error'>Please enter a subject!</div>";
				}
				if ($_GET['error'] == 2)
				{
					echo "<div class='error'>Please enter a message!</div>";
				}
			?>
			<div id="submitDiv"><input type="submit" value="Send" /></div>
		</form>
	
<?php
	outHtml3();
?>
