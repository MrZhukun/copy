<?php
if (!empty($lock) && $lock == 'lock') {
    $pma->name = '登录';
    if (isset($_POST['login'])) {
        $user = htmlspecialchars(trim($_POST['user']));
        $pass = sha1(trim($_POST['pass']));
        $key_2 = strtoupper(trim($_POST['key']));
        switch ($_POST['login']) {
            case '1':
                $u = 'user';
                break;

            case '2':
                $u = 'id';
                break;

            case '3';
            $u = 'phone';
            break;
    }
    if (empty($user) or empty($_POST['pass'])) {
        $pma->msg_str = '用户名或密码不能为空 <a href="index.php">返回首页</a>';
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'login.tpl';
        include $pma->tpl . 'footer.tpl';
        unset($_SESSION['key']);
        die;
    }
    if (!preg_match("/[[\x{4e00}-\x{9fa5}]|\w|\d]{1,12}/u", $_POST['user'])) {
        $pma->msg_str = "用户名格式不正确请<a href=\"{$_SERVER['PHP_SELF']}\">返回</a>";
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'login.tpl';
        include $pma->tpl . 'footer.tpl';
        unset($_SESSION['key']);
        die;
    }
    if (!preg_match("/^\w{6,16}$/i", $_POST['pass'])) {
        $pma->msg_str = '密码格式不正确 <a href="index.php">返回首页</a>';
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'login.tpl';
        include $pma->tpl . 'footer.tpl';
        unset($_SESSION['key']);
        die;
    }
    if ($key_2 != $_SESSION['key'] or !preg_match("/^\w{1,4}$/i", $key_2)) {
        $pma->msg_str = '验证码不正确 <a href="index.php">返回首页</a>';
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'login.tpl';
        include $pma->tpl . 'footer.tpl';
        unset($_SESSION['key']);
        die;
    }
    if (!$result = $db->query("SELECT * FROM `qq_user` WHERE ( `$u` = '$user' )")) {
        $pma->msg_str = '数据库连接失败:' . $db->error;
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'login.tpl';
        include $pma->tpl . 'footer.tpl';
        unset($_SESSION['key']);
        die;
    }
    $row = $result->fetch_assoc(); //取一行数据
    if (!$row[$u]) {
        $pma->msg_str = "用户不存在请<a href=\"{$_SERVER['PHP_SELF']}\">返回</a>重新输入";
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'login.tpl';
        include $pma->tpl . 'footer.tpl';
        unset($_SESSION['key']);
        die;
    }
    if ($row['pass'] !== $pass) {
        $pma->msg_str = '你输入的密码与用户名不匹配<a href="/">返回</a>重新输入';
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'login.tpl';
        include $pma->tpl . 'footer.tpl';
        unset($_SESSION['key']);
        die;
    }
    $_SESSION['id'] = $row['id'];
    $_SESSION['name'] = $user;
    if (isset($_POST['cok'])) {
        setcookie(session_name(), session_id() , time() + 604800);
    }
    setcookie("id", $row['id'], time() + 604800);
    setcookie("name", $user, time() + 604800);
    $pma->msg_str = '恭喜你，登录成功 <a href="index.php">返回首页</a>';
    unset($_SESSION['key']);
    $result->free();
    $db->close();
} else {
    $pma->msg_str = <<<HTML
<form action="{$_SERVER['PHP_SELF']}" method="post">
<select name="login">
<option value="1">用户名</option>
<option value="2" >ID名</option>
<option value="3" >手机号</option>
</select><br>
账 户<input class="user" type="text" name="user" placeholder="请输入账户" value=""><br>
密 码<input type="password" name="pass" maxlength="16" pattern="[\d|\w]{6,16}" title="6-16位字母数字或下划线" placeholder="请输入密码" value=""><br>
<img src="content/png.php" onClick='this.src=this.src'>点图片更换<br>
验证码<input type="text" name="key" maxlength="4"  pattern="[\w]{1,4}$"
title="1-4位结果" placeholder="请输入上图结果" value=""><br>
<input type="checkbox" name="cok">记住登录<br>
<input type="submit" value="提交"> <a href="reg.php">马上注册</a>
<br>
HTML;
}
    include $pma->tpl . 'header.tpl';
    include $pma->tpl . 'login.tpl';
    include $pma->tpl . 'footer.tpl';
}
?>