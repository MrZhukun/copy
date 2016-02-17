<?php
//error_reporting(E_ALL ^ E_NOTICE);
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
date_default_timezone_set('Asia/Shanghai');
session_set_cookie_params(604800);
session_start();
$pma=new stdclass();
$pma->tpl="tpl/";
if(!extension_loaded('mysqli')){
require_once dirname(dirname(__FILE__))."/lib/mysqli_so.php";
}
include dirname(dirname(__FILE__))."/lib/function.php";
include dirname(dirname(__FILE__)).'/lib/pagination_class.php';
include dirname(dirname(__FILE__))."/config.php";
remove_magic_quotes();
$db = @new mysqli(DB_HOST,DB_USER,DB_PASS);
if ($db->connect_errno){
die('链接数据库失败:'. $db->connect_error);
}
$db->select_db(DB_TABLE);
?>