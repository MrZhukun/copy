<?php
/*
*by 紫殇

要转的链接样本： http://down.mydiskm.uc.cn/netdisk/netdisk/fileview?file_id=2749321658086872065&s_uid=14****06&pt=1410229441&pt_data=289d1e79d4df566e94ac114186486aad|%E5%90%8E%E4%BC%9A%E6%97%A0%E6%9C%9F-1.avi|s_uid=184224a770
下图，复制下载两字的链接
*/
header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
<title>
uc网盘转换
</title>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0" />
<style type="text/css">
.top,.foot {
background-color: #CC99FF;
border:#00CCFF solid thin;
border-width:3px;
padding:10px;
word-wrap: break-word;
border-radius: 10px;
}
form,.zq{
border:#00CCFF solid thin;
border-width:3px;
padding:10px;
word-wrap: break-word;
border-radius: 10px;
}
</style>
</head>
<body>
<div class='board_header' >uc网盘转换</div>
在这提取文件地址:<a href="http://newdiskm.uc.cn/ucnd/index.php/netdisk/">uc网盘</a>，支持不同浏览器下载。
<form action="" method="post">
<div class="board_bbs"><div class="bbs_topic">输入网盘文件地址：</div>
<input type="text" name="url" value="" /><br/>
<input type="submit" value="点击转换" /></div>
</form>
<?php
if(!empty($_POST["url"]))
{
$url=$_POST['url'];
preg_match("/file_id=(.*?)&/i",$url,$rs);
$fid=$rs['1'];
preg_match("/s_uid=(.*?)&/i",$url,$r);
$uid=$r['1'];
$url='http://uclx.ucweb.com:8097/uclx_down?s_uid='.$uid.'&request_from=UCMIDDLE&file_id='.$fid;
echo "转换结果：".$url."<br /><a href='".$url."'>uc网盘直链接</a><br />";
}
else
{
echo '在网盘主页面按住某个文件的名称查看链接URL就可以得到地址';
}
?>
</body>
</html>