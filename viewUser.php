<?php
	include("common.php");
	
        outHtml1("View User - ".htmlentities($_GET['userId']));
?>
<style>
.list {
	table-layout: fixed;
	border-spacing: 0px;
	border-collapse: collapse;
	width: 90%;
	border: solid 1px;
	margin: auto;
	font-size: 12px;
	font-weight: normal;
	margin-top: 10px;
}

.list tr {
	border: solid 1px;
}

.listleft {
	background-color: #bfbfbf;
	border-right: 1px solid;
	width: 35%;
	padding: 10px 0px 10px 10px;
	font-family: "Trebuchet MS";
}

.listright {
	background-color: #e9f3ff;
	width: 65%;
	padding: 10px 0px 10px 10px;
}
</style>
<?php
	outHtml2("View User: ".htmlentities($_GET['userId']),$_SERVER['HTTP_REFERER']);
?>

		<table class='list'>
			<?php
			
				$temp = new User(file_get_contents("db/Users/".$_GET['userId'].".dat"));
				echo "<tr><td class='listLeft'>Name</td><td class='listRight'>".$temp->getUserId()."</td></tr>";
				if ($temp->isBanned() == 'false')
				{
					echo "<tr><td class='listLeft'>Banned</td><td class='listRight'>No</td></tr>";
				}
				else
				{
					echo "<tr><td class='listLeft'>Banned</td><td class='listRight'>Yes</td></tr>";
				}
				if ($temp->isHideEmail() == false && $_SESSION['loggedIn'] == true)
				{
					echo "<tr><td class='listLeft'>Email Address</td><td class='listRight'>".$temp->getEmail()."</td></tr>";
				}
				echo "<tr><td class='listLeft'>Join Date</td><td class='listRight'>".$temp->getJoinDate()."</td></tr>";
				echo "<tr><td class='listLeft'>No Of Posts</td><td class='listRight'>".$temp->getNoPosts()."</td></tr>";
				echo "<tr><td class='listLeft'>No Of Topics</td><td class='listRight'>".$temp->getNoTopics()."</td></tr>";
				echo "<tr><td class='listLeft'>Level</td><td class='listRight'>".$temp->getLevel()."</td></tr>";
				if ($temp->getSig() != "")
				{
					echo "<tr><td class='listLeft'>Signature</td><td class='listRight'>".$temp->getSig()."</td></tr>";
				}
				if ($temp->getAvatar() != "")
				{
					echo "<tr><td class='listLeft'>Avatar</td><td class='listRight'><img src='".$temp->getAvatar()."' /></td></tr>";
				}
			?>
		</table>
		
		<?php
			if ($_SESSION['loggedIn'] == true)
			{
				echo "<div align='center' style='margin-top: 5px;'><a href='pmCompose.php?userId=".htmlentities($_GET['userId'])."'>PM User</a></div>";
			}

	outHtml3();
?>
