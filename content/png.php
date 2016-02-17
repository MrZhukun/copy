<?php
session_start();
header("Content-type: image/png");
$strcode= "23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVW";
    $codekey= '';
    for($i= 0; $i< 4; $i++) {
        $codekey.= $strcode[mt_rand(0, strlen($strcode)-1)];
    }
    
$code = rand(49, 99);
$code_1 = rand(9, 49);
$key_1 = rand(0, 2);
$str = array(
    $code + $code_1,
    $codekey,
    $code - $code_1
);
switch ($key_1){
case '0';
$code = $code . '+' . $code_1 . '=?';
break;
case '1';
$code='   '.$codekey;
break;
case '2';
$code = $code . '-' . $code_1 . '=?';
break;
}
$_SESSION['key'] = strtoupper($str[$key_1]);
$im = imagecreatetruecolor(110, 35);
//像素
$white = imagecolorallocate($im, 255, 255, 255); //背景color
$black = imagecolorallocate($im, 0, 0, 0); //字体color
imagefilledrectangle($im, 0, 0, 110, 35, $white); //black矩阵
//画出多条线
for ($i = 0; $i < 8; $i++) {
    $cg = imagecolorallocate($im, rand(50, 255) , rand(40, 255) , rand(30, 255)); //产生随机的颜色
    imageline($im, rand(0, 15) , rand(0, 35) , rand(60, 150) , rand(5, 40) , $cg); //随机排列
    
}
$font = dirname(dirname(__FILE__)) . '/include/ttf.ttf'; //字体
imagettftext($im, 18, 4, 10, 28, $black, $font, $code); //生成图像
imagepng($im); //
imagedestroy($im);
?>