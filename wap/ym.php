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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="CN-zh" lang="CN-zh">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"/>
<title>源码查看</title>
<link rel="stylesheet" href="sh/styles/googlecode.css">
<script src="sh/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
</head>
<body>
<form action="" method="post">
<input class="text" type="text" name="url" value="<?php echo isset($_POST['url'])?$_POST['url']:''?>">
<input type="submit" value="提交">
<br />
<?php
if (!empty($_POST['url'])){
 if(preg_match("/^http:\/\//i",$_POST['url'])){
 $url=$_POST['url'];
 }else{
 $url='http://'.$_POST['url'];
 }
echo $url;
$var=curl($url);
$text=htmlspecialchars($var);
echo<<<HTML
<pre>
<code>
{$text}
</code>
</pre>
HTML;
}
?>
</body>
</html>