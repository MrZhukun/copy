<?php
header("Content-type: text/html; charset=utf-8");
include('weather_class.php');//引入类
remove_magic_quotes();//防注入
echo"
<html>
<head>
<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0; maximum-scale=1.0\" />
</head>
<body>
<form action=\"weather.php\" method=\"post\">
<input class=\"text\" type=\"text\" name=\"name\" value=\"\">
<input type=\"submit\" value=\"提交\">
";
//查询数据，不用echo
if (!empty($_POST['name'])){
if (!preg_match("/^[\x{4e00}-\x{9fa5}]{2,7}+$/u",$_POST['name'])){
die('<br>请输入正确的城市');
}
$post=$_POST['name'];
$job=new weather();
echo "<br/>请选择你的城市：";
echo $job->api("weather.db",$post);//前面数据库目录，后面查询的城市，贪婪匹配
}
//提交id，获取天气
if (!empty($_GET['name'])){
if (!preg_match("/^[1][0][1]\d{6}$/",$_GET['name'])){
die('<br>id错误');
}
$j=new weather();
$info=$j->curl("1",$_GET['name']);
$in=$j->curl("2",$_GET['name']);//显示类型，可选填1.2,后面的GET是获取查询到数据的sql，禁止修改
echo "<br />当前城市：".$info['weatherinfo']['city'];
echo "<br />天气状况：".$in['weatherinfo']['weather'];
echo "<br />当前气温：".$info['weatherinfo']['temp']."℃";
echo "<br />最高气温：".$in['weatherinfo']['temp1'];
echo "<br />最低气温：".$in['weatherinfo']['temp2'];
echo "<br />当前湿度：".$info['weatherinfo']['SD'];
echo "<br />风向：".$info['weatherinfo']['WD']."，风速：
".$info['weatherinfo']['WS'];
echo "<br />更新时间：".$info['weatherinfo']['time'];
}
?>
</body>
</html>