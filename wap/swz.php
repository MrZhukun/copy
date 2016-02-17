<?php
header("Content-type: text/html; charset=utf-8");
include('swz_class.php');
echo<<<HTML
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>生物钟</title>
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0" />
    </head>
    <body>
<form action="" method="post">
你的生日：<input class="date" type="date" name="date" value="">
<input type="submit" value="提交">
</html>
<br>
HTML;
if (!empty($_POST['date'])){
$date_1=date('Y-m-d');
$date_0=date('Y-m-d',strtotime("-1 day"));
$date_2=date('Y-m-d',strtotime("+1 day"));
preg_match_all('/\-(\d{2})/i',$_POST['date'],$day);
$str=new swzclass();
echo '你的星座：'.$str->xz($day['1']['0'],$day['1']['1']);
echo '<hr>昨天生物钟：<br>'.$str->swz($date_0,$_POST['date']);
echo '<hr>今天生物钟：<br>'.$str->swz($date_1,$_POST['date']);
echo '<hr>明天生物钟：<br>'.$str->swz($date_2,$_POST['date']);
}
echo <<<XHTML
    </body>
</html>

XHTML;
?>