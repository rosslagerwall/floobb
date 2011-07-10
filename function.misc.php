<?php
	/* Return the size of a remote url or a local file specified by $url.
	$thereturn specifies the unit returned (either bytes "", MiB "mb" or KiB
	"kb"). */
	function urlfilesize($url,$thereturn)
	{
		if (substr($url,0,4)=='http')
		{
			$x = array_change_key_case(get_headers($url, 1),CASE_LOWER);
			$x = $x['content-length'];
		}
		else
		{
			$x = @filesize($url);
		}
		if (!$thereturn)
		{
			return $x;
		}
		elseif ($thereturn == 'mb')
		{
			return round($x / (1024*1024),2);
		}
		elseif ($thereturn == 'kb')
		{
			return round($x / (1024),0);
		}
	}
?>
