<?php
include dirname(__FILE__) . "/include/inc.php";
$pma->name = '注册';
if (isset($_POST['reg']) && $_POST['reg']=='1') {
    $user = htmlspecialchars(trim($_POST['user']));
    $pass = sha1(trim($_POST['pass']));
    $phone = trim($_POST['phone']);
    $key_2 = strtoupper(trim($_POST['key']));
    if (empty($user) or empty($_POST['pass']) or empty($phone)) {
        $pma->msg_str = "用户名。密码。手机都不能为空请<a href=\"{$_SERVER['PHP_SELF']}\">返回</a>";
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'reg.tpl';
        include $pma->tpl . 'footer.tpl';
        unset($_SESSION['key']);
        die;
    }
    if (!preg_match("/[[\x{4e00}-\x{9fa5}]|\w|\d]{1,12}/u", $user)) {
        $pma->msg_str = "用户名格式不正确请<a href=\"{$_SERVER['PHP_SELF']}\">返回</a>";
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'reg.tpl';
        include $pma->tpl . 'footer.tpl';
        unset($_SESSION['key']);
        die;
    }
    if (!preg_match("/^\w{6,16}$/sim", $_POST['pass'])) {
        $pma->msg_str = "密码格式不正确请<a href=\"{$_SERVER['PHP_SELF']}\">返回</a>";
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'reg.tpl';
        include $pma->tpl . 'footer.tpl';
        unset($_SESSION['key']);
        die;
    }
    if (!preg_match("/^1[3|4|5|7|8][0-9]\d{8}$/", $phone)) {
        $pma->msg_str = "手机号格式不正确请<a href=\"{$_SERVER['PHP_SELF']}\">返回</a>";
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'reg.tpl';
        include $pma->tpl . 'footer.tpl';
        unset($_SESSION['key']);
        die;
    }
    if ($key_2 != $_SESSION['key'] or !preg_match("/^\w{1,4}$/sim", $key_2)) {
        $pma->msg_str = "验证码不正确请<a href=\"{$_SERVER['PHP_SELF']}\">返回</a>";
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'reg.tpl';
        include $pma->tpl . 'footer.tpl';
        unset($_SESSION['key']);
        die;
    }
    if (!$resul = $db->query("SELECT * FROM `qq_user` WHERE ( `user` = '$user' )")) {
        die('数据库连接失败:' . $db->error);
    }
    $ro = $resul->fetch_assoc(); //取一行数据
    if ($ro['user'] == $user) {
        $pma->msg_str = "用户名被占用 请<a href=\"{$_SERVER['PHP_SELF']}\">返回</a>重新输入";
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'reg.tpl';
        include $pma->tpl . 'footer.tpl';
        unset($_SESSION['key']);
        die;
    }
    if (!$ph = $db->query("SELECT * FROM `qq_user` WHERE ( `phone` = '$phone' )")) {
        die('数据库连接失败:' . $db->error);
    }
    $rp = $ph->fetch_assoc(); //取一行数据
    if ($rp['phone'] == $user) {
        $pma->msg_str = "手机号被占用 请<a href=\"{$_SERVER['PHP_SELF']}\">返回</a>重新输入";
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'reg.tpl';
        include $pma->tpl . 'footer.tpl';
        unset($_SESSION['key']);
        die;
    }
    if (!$db->multi_query("INSERT INTO `qq_user` SET `user` = '$user',`pass` = '$pass',`phone` = '$phone'")) {
        $pma->msg_str = "该账户已经注册，请勿重复注册请<a href=\"{$_SERVER['PHP_SELF']}\">返回</a>";
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'reg.tpl';
        include $pma->tpl . 'footer.tpl';
        unset($_SESSION['key']);
        die;
    }
    $resul->free();
    $ph->free();
    $pma->msg_str = <<<HTML
<form action="index.php" method="post">
<input type="hidden" name="user" value="{$user}">
<input type="hidden" name="pass" value="{$_POST['pass']}">
<input type="hidden" name="login" value="1">
<img src="content/png.php" onClick='this.src=this.src'>点图片更换<br>
验证码<input type="text" name="key" maxlength="4"  pattern="[\w]{1,4}$"
title="1-4位结果" placeholder="请输入上图结果" value=""><br>
<input type="submit" value="马上登陆">
</form>
HTML;
} else {
    $pma->msg_str = <<<HTML
<form action="{$_SERVER['PHP_SELF']}" method="post">
<input type="hidden" name="reg" value="1">
账 户<input class="user" type="text" name="user" placeholder="请输入账户名" value=""><br>
密 码<input type="password" name="pass" maxlength="16" pattern="[\d|\w]{6,16}" title="6-16位字母数字或下划线" placeholder="请输入密码" value=""><br>
手机号<input class="phone" type="text" name="phone" maxlength="11" pattern="1[3|4|5|7|8][0-9]\d{8}$" title="请输入11位正确的手机号" placeholder="请输入手机号" value=""><br>
<img src="content/png.php" onClick='this.src=this.src'>点图片更换<br>
验证码<input type="text" name="key" maxlength="4"  pattern="[\w]{1,4}$"
title="1-4位结果" placeholder="请输入上图结果" value=""><br>
<input type="submit" value="提交"> <a href="index.php">已有帐号</a>
</form>
HTML;
}

    include $pma->tpl . 'header.tpl';
    include $pma->tpl . 'reg.tpl';
    include $pma->tpl . 'footer.tpl';
$db->close();
?>