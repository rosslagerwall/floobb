<?php
	function outHtml1($title)
	{
		echo '<html>
			<head>
			<title>'.$title.'</title>
			<link rel="stylesheet" type="text/css" href="basic.css" />';
	}
	
	function outHtml2($title, $url="",$includeHeader=true)
	{
		echo '</head>
				<body>
					<div class="bl"><div class="br"><div id="container">
						<div id="headingImage"><img src="images/heading.png" /><div style="margin-top: 10px;">'.BOARDNAME." • ".BOARDDESCRIPTION.'</div></div>
						<div id="header">'.$title;
		if (isset($url) && $url != "")
		{
			echo "<br /><a href='".$url."'>Back</a>";
		}
		echo '</div>
						<div id="login">';
		if ($includeHeader)
		{
			include("loginHeader.php");
		}
		echo '</div>';
	}
	
	function outHtml3()
	{
		echo '	</div></div></div>
			<div id="copyright">&copy; 2011 - flooBB 1.2</div>
		</body>
		</html>';
	}
?>
