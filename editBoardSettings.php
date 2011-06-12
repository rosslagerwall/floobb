<?php
	include("common.php");
	outHtml1("Edit Board Settings");
?>
<!-- TinyMCE -->
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="tiny_mce_init.js"></script>
<?php
	outHtml2("Edit Board Settings","index.php");
?>
		
		<form method="post" action="editBoardSettingsExecute.php">
			<table class='list'>
				<?php
					echo "<tr><td class='listlefta'>Board Name</td><td class='listrighta'><input type='text' class='inputbox' name='name' value=\"".$boardname."\" /></td></tr>";
					echo "<tr><td class='listlefta'>Board Description</td><td class='listrighta'><input type='text' class='inputbox' name='description' value='".trim(file_get_contents("db/boarddescription.dat"))."' /></td></tr>";
					echo "<tr><td class='listlefta'>Number Of Topics Per Page</td><td class='listrighta'><input type='text' class='inputbox' name='topics' value='".trim(file_get_contents("db/topicsperpage.dat"))."' /></td></tr>";
					echo "<tr><td class='listlefta'>Recalculate Smilies</td><td class='listrighta'><input type='checkbox' class='inputBox' name='smiley' value='yes' /></td></tr>";
				?>
			</table>
			<?php
				if ($_GET['error'] == 1)
				{
					echo "<div class='error'>Please enter a board name!</div>";
				}
				if ($_GET['error'] == 2)
				{
					echo "<div class='error'>Please enter a board description!</div>";
				}
				if ($_GET['error'] == 3)
				{
					echo "<div class='error'>Please enter a valid number of topics per page!</div>";
				}
			?>
			<div id="submitDiv"><input type="submit" value="Update" /></div>
		</form>
<?php
	outHtml3();
?>
