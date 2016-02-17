<?php
header("Content-type: text/html; charset=utf-8");
function curl($url){
$ua="Android5.0";
$ip='119.4.252.55';
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_HTTPHEADER,array("Client_Ip:".$ip."","Real_ip:".$ip."","X_FORWARD_FOR:".$ip."","X-forwarded-for:".$ip."","PROXY_USER:".$ip.""));
//curl_setopt($ch, CURLOPT_REFERER, ''); //伪造来路页面
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_USERAGENT,$ua);
$data=curl_exec($ch);
curl_close($ch);
return $data;
}
if(isset($_POST['location'])){
$url=curl("http://restapi.amap.com/v3/geocode/regeo?location=".$_POST['location']."&language=zh&key=8ef76ba266bc71d3c423b6f28fffc6f1");
$info=json_decode($url,true);
echo $info['regeocode']['formatted_address'];
}
?>
