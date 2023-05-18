<?php

$caplen = 4; 
$width = 200; 
$height = 60; 
//$font ='C:\OSPanel\domains\project\fonts\ukrainianfuturaeugenia.ttf';
$font = $_SERVER['DOCUMENT_ROOT'].'\fonts\ukrainianfuturaeugenia.ttf';
$fontsize = 20;

$im = imagecreatetruecolor($width, $height);
imagesavealpha($im, true); 
$bg = imagecolorallocatealpha($im, 0, 0, 0, 127); 
imagefill($im, 0, 0, $bg); 

//случайные линии под текстом
$linenum = rand(5, 7);
for ($i = 0; $i < $linenum; $i++) {
    $color = imagecolorallocate($im, rand(0, 255), rand(0, 200), rand(0, 255));
	imageline($im, rand(0, 10), rand(1, 60), rand(160, 200), rand(1, 60), $color);
}

//формирование текста капчи
$a = rand(10, 20);
$b = rand(1, 10);
$captcha = [$a,'-',$b,'='];
for ($i = 0; $i < $caplen; $i++) {
    //$captcha .= $letters[rand(0, strlen($letters) - 1)];
    $x = ($width - 20) / $caplen * $i + 10; 

    $x = rand($x, $x + 4); 
    $y = $height - (($height - $fontsize) / 2);
    $curcolor = imagecolorallocate($im, rand(0, 100), rand(0, 100), rand(0, 100));
    $angle = rand(-25, 25);
    imagettftext($im, $fontsize, $angle, $x, $y, $curcolor, $font, $captcha[$i]);
}

// Опять линии, уже сверху текста
$linenum = rand(4, 6);
for ($i = 0; $i < $linenum; $i++) {
    $color = imagecolorallocate($im, rand(0, 255), rand(0, 200), rand(0, 255));
	imageline($im, rand(0, 50), rand(1, 60), rand(160, 200), rand(1, 100), $color);
}

session_start();
$_SESSION['captcha'] = $a-$b;

ob_clean();
header('Content-type: image/png');
imagepng($im);
imagedestroy($im);
?>