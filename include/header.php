<?php
include dirname(__FILE__) . "/inc.php";
if (function_exists("ignore_user_abort")) ignore_user_abort(true);
//用户的登录
if(!isset($_SESSION['admin']))
{
    if(isset($_SESSION['name']) && isset($_SESSION['id']))
    { if($_COOKIE['name']===$_SESSION['name'] && $_COOKIE['id']===$_SESSION['id'])
        {
            $_SESSION['admin']=true;
            unset($_SESSION['key']);
            header("Location: {$_SERVER['PHP_SELF']}");
            exit;
        }
    }
    $lock = 'lock';
    include dirname(__FILE__) . '/login.php';
    exit;
    }else{
    if($_SESSION['admin']!==true || isset($_GET['logout']))
    {
        unset($_SESSION['name']);
        unset($_SESSION['id']);
        unset($_SESSION['admin']);
        setcookie("name", "", time() - 86400);
        setcookie("id", "", time() - 86400);
        session_regenerate_id();
        setcookie(session_name(), session_id() , time() - 86400);
        $pma->name = "注销登录";
        $pma->msg_str = "注销成功 <a href=\"" . $_SERVER['PHP_SELF'] . "\">点击回到首页</a>";
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'login.tpl';
        include $pma->tpl . 'footer.tpl';
        exit;
    }else  if($_COOKIE['name']!==$_SESSION['name'] || $_COOKIE['id']!==$_SESSION['id']) {
     unset($_SESSION['name']);
        unset($_SESSION['id']);
        unset($_SESSION['admin']);
        setcookie("name", "", time() - 86400);
        setcookie("id", "", time() - 86400);
        session_regenerate_id();
        setcookie(session_name(), session_id() , time() - 86400);
        $pma->name = "登录状态异常";
        $pma->msg_str = "警告： 非法登录，请<a href=\"" . $_SERVER['PHP_SELF'] . "\">返回</a>首页重新登录";
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'login.tpl';
        include $pma->tpl . 'footer.tpl';
        exit;
    }
}
?>