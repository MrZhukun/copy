<?php
class weather
{
//核心类
function curl($id,$get){
$ua="Mozilla/5.0(Linux;Android4.3;MI3WBuild/JLS36C)AppleWebKit/537.36(KHTML,likeGecko)Chrome/34.0.1847.114MobileSafari/537.36";
if ($id=="1"){
$url="http://www.weather.com.cn/data/sk/{$get}.html";
}else if($id=="2"){
$url="http://www.weather.com.cn/data/cityinfo/{$get}.html";
}else if($id=="3"){
$ua='Dalvik/2.0.0 (Linux; U;Android 4.4.4; MI 2 MIUI/4.12.26)';
$url="http://weatherapi.market.xiaomi.com/wtr-v2/weather?cityId={$get}&device=aries&miuiVersion=4.12.26&modDevice=aries_beta&source=miuiWeatherApp";
}else{
exit('传入参数错误！');
}
$ip='119.4.252.55';
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_HTTPHEADER,array("Client_Ip:".$ip."","Real_ip:".$ip."","X_FORWARD_FOR:".$ip."","X-forwarded-for:".$ip."","PROXY_USER:".$ip.""));
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_USERAGENT,$ua);
$data=curl_exec($ch);
curl_close($ch);
return json_decode($data,true);
}

function api($dbpath='weather.db',$post){
//$db=new SQLite3($dbpath);
if(!extension_loaded('mysqli')){
require_once dirname(dirname(__FILE__))."/lib/mysqli_so.php";
}
include dirname(dirname(__FILE__))."/config.php";
$db = @new mysqli(DB_HOST,DB_USER,DB_PASS);
if ($db->connect_errno){
die('链接数据库失败:'. $db->connect_error);
}
$db->select_db(DB_TABLE);
$sql="SELECT * FROM city WHERE Rtrim(name) LIKE '%$post%'";
$re=$db->query($sql);
$strin='<table border="1"><tr>';
//fetchArray(SQLITE3_ASSOC) fetch_assoc()
while($row=$re->fetch_assoc()){
			$strin.="<td><a href=\"?name=".$row['cid']."\">".$row['name']."</a></td>";
}
$strin.='</tr></table>';
return $strin;
$conn->close();
}

}
//防注入
function remove_magic_quotes(){
    if( get_magic_quotes_gpc() ) {
		$_GET = stripslashes_recursive($_GET);
		$_POST = stripslashes_recursive($_POST);
    }
}
?>