<?php
function remove_magic_quotes()
{
    if( get_magic_quotes_gpc() ) {
		$_GET = stripslashes_recursive($_GET);
		$_POST = stripslashes_recursive($_POST);
    }
}
function curl($url){
$ua="";
$ip='119.4.252.55';
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_HTTPHEADER,array("Client_Ip:".$ip."","Real_ip:".$ip."","X_FORWARD_FOR:".$ip."","X-forwarded-for:".$ip."","PROXY_USER:".$ip.""));
//curl_setopt($ch, CURLOPT_REFERER, 'http://9in.info/chen/install.php?do=bc3'); //伪造来路页面
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_USERAGENT,$ua);
$data=curl_exec($ch);
curl_close($ch);
return $data;
}
?>