<?php
include dirname(dirname(__FILE__)) . "/include/inc.php";
include dirname(dirname(__FILE__)) . "/lib/zan_class.php";
//引入类
if (function_exists("ignore_user_abort")) ignore_user_abort(true);
ob_end_clean();
header("Connection: close");
//时间，缓存。。。
$sql=$db->query("SELECT * FROM `qq_qqinfo` WHERE ( `no` = '1' )");//查询开启点赞列表，你可以选择修改
while($su = $sql->fetch_assoc()){
$uin=new DianZan($su['user'],$su['sid']);//初始化类
if($uin->getFeedslist()=='siderr'){
$uin_sid=new ZAN($su['user'],$su['depass']);
$read=$uin_sid->qqsid();
preg_match("/sid=(.*?)&/i",$read,$rs);
$sql_1="UPDATE `qq_qqinfo` SET `sid` = '".$rs['1']."' WHERE ( `user` = '".$su['user']."' )";//更新sid
$db -> query($sql_1);
}else{
$uin->dz();
}
}
$db->close();
echo "ok";
?>