<?php
include dirname(dirname(__FILE__)) . "/include/inc.php";
include dirname(dirname(__FILE__)) . "/lib/qq_login_class.php";
if (function_exists("ignore_user_abort")) ignore_user_abort(true);
ob_end_clean();
header("Connection: close");
$date_1=date('Y-m-d H:i:s');
$date_2=date('Y-m-d H:i:s',strtotime('+2 hour'));
$sql=$db -> query("SELECT * FROM `qq_qqinfo` WHERE ( `gq` = '1' )");
while($su = $sql->fetch_assoc()){
$qq = new SET_MQQ($su['user'], $su['pass']);
if (strtotime($su['time'])<=strtotime($date_1)){
$db -> query("UPDATE `qq_qqinfo` SET `time` = '".$date_2."' WHERE ( `user` = '".$su['user']."' )");
$qq->Login();
}
$qq->ChangeStat('10');
//$qq->GetMsg('系统登录');
}
$db->close();
echo "ok";
?>