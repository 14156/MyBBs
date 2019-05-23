<!-- <?php 
function vcode($width=120,$height=40,$fontSize=30,$countElement=4,$countPixel=100,$countLine=4){
	ob_clean();
	header('Content-type:image/jpeg');
	$element=array('a','b','c','d','e','f','g','h','i','j','k','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	$string='';
	for ($i=0;$i<$countElement;$i++){
		$string.=$element[rand(0,count($element)-1)];
	}
	$img=imagecreatetruecolor($width, $height);
	$colorBg=imagecolorallocate($img,rand(200,255),rand(200,255),rand(200,255));
	$colorBorder=imagecolorallocate($img,rand(200,255),rand(200,255),rand(200,255));
	$colorString=imagecolorallocate($img,rand(10,100),rand(10,100),rand(10,100));
	imagefill($img,0,0,$colorBg);
	for($i=0;$i<$countPixel;$i++){
		imagesetpixel($img,rand(0,$width-1),rand(0,$height-1),imagecolorallocate($img,rand(100,200),rand(100,200),rand(100,200)));
	}
	for($i=0;$i<$countLine;$i++){
		imageline($img,rand(0,$width/2),rand(0,$height),rand($width/2,$width),rand(0,$height),imagecolorallocate($img,rand(100,200),rand(100,200),rand(100,200)));
	}

	// imagestring($img,5,0,0,$string,$colorString);
	imagettftext($img,$fontSize,rand(-5,5),rand(5,15),rand(30,35),$colorString,'font/IndieFlower.ttf',$string);
	imagejpeg($img);
	// imagedestroy($img);
}
?>  -->
 


<?php
function vcode1(){
	$w = 120; //设置图片宽和高
$h = 40;
$str = Array(); //用来存储随机码
$string = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";//随机挑选其中4个字符，也可以选择更多，注意循环的时候加上，宽度适当调整
for($i = 0;$i < 4;$i++){
   $str[$i] = $string[rand(0,35)];
   $vcode .= $str[$i];
}

$im = imagecreatetruecolor($w,$h);
$white = imagecolorallocate($im,255,255,255); //第一次调用设置背景色
$black = imagecolorallocate($im,0,0,0); //边框颜色
imagefilledrectangle($im,0,0,$w,$h,$white); //画一矩形填充
imagerectangle($im,0,0,$w-1,$h-1,$black); //画一矩形框
//生成雪花背景
for($i = 1;$i < 200;$i++){
   $x = mt_rand(1,$w-9);
   $y = mt_rand(1,$h-9);
   $color = imagecolorallocate($im,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
   imagechar($im,1,$x,$y,"*",$color);
}
//将验证码写入图案
for($i = 0;$i < count($str);$i++){
   $x = 13 + $i * ($w - 15)/4;
   $y = mt_rand(3,$h / 3);
   $color = imagecolorallocate($im,mt_rand(0,225),mt_rand(0,150),mt_rand(0,225));
   imagechar($im,50,$x,$y,$str[$i],$color);
}
ob_clean();//原来的程序没有这一栏
header("Content-type:image/jpeg"); //以jpeg格式输出，注意上面不能输出任何字符，否则出错
imagejpeg($im);
imagedestroy($im);
return $str;
}

 ?>
