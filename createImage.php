<?php

	define("WIDTH", 100);
    define("HEIGHT", 100);

    $data = explode(",",$_GET['values']);
	
	for ($i = 0; $i < sizeOf($data); $i++)
	{
		$piegraph_data[$i] = $data[$i]/ array_sum($data) * 100;
	}
	
    $img = imagecreate(WIDTH, HEIGHT);

    $background = $white = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);
    $black = imagecolorallocate($img, 0, 0, 0);
	$color[0] = imagecolorallocate($img, 255, 0, 0);
	$color[1] = imagecolorallocate($img, 0, 255, 0);
	$color[2] = imagecolorallocate($img, 0, 0, 255);
	$color[3] = imagecolorallocate($img, 170, 187, 204);
	$color[4] = imagecolorallocate($img, 0, 0, 0);
	$color[5] = imagecolorallocate($img, 42, 255, 237);
	$color[6] = imagecolorallocate($img, 255, 216, 188);
	$color[7] = imagecolorallocate($img, 218, 255, 188);
	$color[8] = imagecolorallocate($img, 255, 18, 169);
	$color[9] = imagecolorallocate($img, 118, 46, 46);

    $center_x = (int)WIDTH/2;
    $center_y = (int)HEIGHT/2;

    imagerectangle($img, 0, 0, WIDTH-1, HEIGHT-1, $black);

    $last_angle = 0;
	
    for ($i = 0; $i < sizeOf($piegraph_data); $i++)
	{
        $arclen = (360 * $piegraph_data[$i]) / 100;
		if ($arclen > 0)
		{
			imagefilledarc($img,
						   $center_x,
						   $center_y,
						   WIDTH-20,
						   HEIGHT-20,
						   $last_angle,
						   ($last_angle + $arclen),
						   $color[$i],
						   IMG_ARC_EDGED);
		}
        $last_angle += $arclen;
    }
    header("Content-Type: image/png");
    imagepng($img);

?>
