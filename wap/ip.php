<?php
header("Content-type: text/html; charset=utf-8");
if(!extension_loaded('qqwry')) {
include('qqwry_class.php');
}
  function getIP()
  {
      static $ip;
      if (isset($_SERVER)){
          if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
             $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
         } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
             $ip = $_SERVER["HTTP_CLIENT_IP"];
         } else {
             $ip = $_SERVER["REMOTE_ADDR"];
         }
     } else {
         if (getenv("HTTP_X_FORWARDED_FOR")){
             $ip = getenv("HTTP_X_FORWARDED_FOR");
         } else if (getenv("HTTP_CLIENT_IP")) {
             $ip = getenv("HTTP_CLIENT_IP");
         } else {
             $ip = getenv("REMOTE_ADDR");
         }
     }
  
  
     return $ip;
 }
$ip=!empty($_GET['ip'])?$_GET['ip']:getIP();
//纯真IP数据库路径
$dat="qqwry.dat";
//实例qqwry类（pecl qqwry扩展）
$qqwry=new qqwry($dat);
//利用q方法在纯真数据库中查询IP
$ip_info='';
if(preg_match_all("/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/",$ip,$ip_all)) {
$ip_array=array_keys(array_count_values($ip_all['0']));
while (list($key, $value) = each($ip_array)) {
$getip=$qqwry->q($value);
//返回一个数组，[0]表示地区，[1]表示网络运营商等
$di=!empty($getip[0])?mb_convert_encoding($getip[0], "UTF-8", "GBK"):'暂无数据';
$yu=!empty($getip[1])?mb_convert_encoding($getip[1], "UTF-8", "GBK"):'暂无数据';
$ip_info.='[{"ip":"'.$value.'","city":"'.$di.'","info":"'.$yu.'"}]';
}
echo str_replace('][',',',$ip_info);
}else{
echo'[{"ip":"Ip地址无效","city":"Null","info":"请输入正确的Ip地址"}]';
}

?>