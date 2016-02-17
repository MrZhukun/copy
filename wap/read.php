<?php
header("Content-type: text/html; charset=utf-8");
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>http请求</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"/>
<meta name="format-detection" content="telephone=no"/>
<style type="text/css">
#whole_body {
background-color: #CC99FF;
border:#00CCFF solid thin;
border-width:3px;
padding:10px;
font-size:14px;
word-wrap: break-word;
border-radius: 10px;
}
</style>
</head>
<body>
<div id="whole_body">
';
echo 'Accept-Encoding: '.$_SERVER['HTTP_ACCEPT_ENCODING']; #当前请求的 Accept-Encoding: 头部的内容。例如：“gzip”。

echo '<br />Accept-Language: '.$_SERVER['HTTP_ACCEPT_LANGUAGE'];#当前请求的 Accept-Language: 头部的内容。例如：“en”。

echo '<br />Accept: '.$_SERVER['HTTP_ACCEPT']; #当前请求的 Accept: 头部的内容。

echo '<br />Connection: '.$_SERVER['HTTP_CONNECTION']; #当前请求的 Connection: 头部的内容。例如：“Keep-Alive”。

echo '<br />User-Agent: '.$_SERVER['HTTP_USER_AGENT']; #当前请求的 User_Agent: 头部的内容。

echo '<br />Host: '.$_SERVER['HTTP_HOST']; #当前请求的 Host: 头部的内容。

echo '<br />Protocol: '.$_SERVER['SERVER_PROTOCOL']; #请求页面时通信协议的名称和版本。例如，“HTTP/1.0”。

echo '<br />Method: '.$_SERVER['REQUEST_METHOD']; #访问页面时的请求方法。例如：“GET”、“HEAD”，“POST”，“PUT”。

echo '<br />Url: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; #访问此页面所需的 URI。例如，“/index.html”。

echo '<br />String: '.$_SERVER['QUERY_STRING']; #查询(query)的字符串。

echo '<br />Referer: '.isset($_SERVER['HTTP_REFERER']); #链接到当前页面的前一页面的 URL 地址。

echo '<br />Port: '.$_SERVER['REMOTE_PORT']; #用户连接到服务器时所使用的端口。

echo '<br />Addr: '.$_SERVER['REMOTE_ADDR']; #正在浏览当前页面用户的 IP 地址。

echo '<br />X-Forwarede-For: '.$_SERVER["HTTP_X_FORWARDED_FOR"];

echo '<br />Client-Ip: '.isset($_SERVER["HTTP_CLIENT_IP"]);
echo '<div/>
</body>
</html>';
?>