<?php

function imagettftextoutline(&$im,$size,$angle,$x,$y,&$col,
            &$outlinecol,$fontfile,$text,$width) {
	// For every X pixel to the left and the right
	for ($xc=$x-abs($width);$xc<=$x+abs($width);$xc++) {
			// For every Y pixel to the top and the bottom
			for ($yc=$y-abs($width);$yc<=$y+abs($width);$yc++) {
					// Draw the text in the outline color
					$text1 = imagettftext($im,$size,$angle,$xc,$yc,$outlinecol,$fontfile,$text);
			}
	}
	// Draw the main text
	$text2 = imagettftext($im,$size,$angle,$x,$y,$col,$fontfile,$text);
}

$string = 'Nessie';
if(!empty($_GET['text']))
{
	$string = $_GET['text'];
}
$font_file = "font/vintage.ttf";

// Adapted from http://www.phpbuilder.com/columns/cash20030526.php3?print_mode=1
// &
// http://www.php.net/manual/fr/function.imagettftext.php

// Image building
$width = 204;
$height = 45;
$font_size = 20;

$im = imagecreatetruecolor($width, $height);

// Colors definitions
$white = imagecolorallocate($im, 255, 255, 255);
$yellow = imagecolorallocate($im, 255, 255, 0);
$purple =  imagecolorallocate($im, 89, 3, 255);
$black = imagecolorallocate($im, 0, 0, 0);

imagefilledrectangle($im, 0, 0, 204, 45, $white);
imagecolortransparent($im, $white);

$type_space = imagettfbbox($font_size, 0, $font_file, $string);

// Determine image width and height, 10 pixels are added for 5 pixels padding:
$text_width = abs($type_space[4] - $type_space[0]) + 10;
$text_height = abs($type_space[5] - $type_space[1]) + 10;

$position_center = ceil(($width - $text_width) / 2);
//$position_middle = ceil(($height - $text_height) / 2);

/*
echo "font_loaded:" . $font_loaded;
echo "font_width:" . $font_width;
echo "font_height:" . $font_height;
echo "font_loaded:" . $font_loaded;
echo "text_width:" . $text_width;
echo "text_height:" . $text_height;
echo "position center:" . $position_center;
echo "position middle:" . $position_middle;
*/

imagettftextoutline(
        $im,           // image location ( you should use a variable )
        $font_size,            // font size
        0,             // angle in °
        $position_center,             // x
        30, //$position_middle,            // y
        $yellow,
        $purple,
        $font_file,
        $string,       // pattern
        2              // outline width
);


header('Content-type: image/png');
imagepng($im);
imagedestroy($im);

?>
