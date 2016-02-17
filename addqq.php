<?php
include dirname(__FILE__) . '/include/header.php';
include dirname(__FILE__) . '/lib/qq_login_class.php';
include dirname(__FILE__) . '/lib/zan_class.php';
//失败返回error;
$pma->name = "登录QQ";
$get = isset($_GET['win']) ? $_GET['win'] : Null;
$date_time = date('Y-m-d H:i:s');
if ($get == "login") {
    if (empty($_POST['qq']) or empty($_POST['password'])) {
        $pma->msg_str = "QQ或密码为空,<a href=\"javascript:window.history.back(-1);\">返回</a>重新输入";
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'addqq.tpl';
        include $pma->tpl . 'footer.tpl';
        die;
    }
    if (!preg_match("/^[1-9][0-9]\d{3,9}$/i", $_POST['qq'])) {
        $pma->msg_str = "QQ格式不正确,<a href=\"javascript:window.history.back(-1);\">返回</a>重新输入";
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'addqq.tpl';
        include $pma->tpl . 'footer.tpl';
        die;
    }
    $uin = trim($_POST['qq']);
    $pwd = md5(trim($_POST['password'])); //md5加密密码
    $pwd = strtoupper($pwd); //转为大写
    $input = isset($_POST['input']) ? $_POST['input'] : '2';
    if ($input == '1') {
        $qq = new SET_MQQ($uin, $pwd);
        $loginType = $_POST['loginType'] . '0';
        $str = json_decode($qq->Login($loginType) , true); //登录，如果有验证码获取验证码
        switch ($str['status']) {
            case "vc":
                $_SESSION['CODE'] = $str['res'];
                $id = session_id();
                $pma->msg_str = <<<HTML
请输入验证码:<br><img src="content/code.php?id={$id}">
<form action="{$_SERVER['PHP_SELF']}?win=code" method="post">
<input class="qq" type="hidden" name="qq" value="{$uin}">
<input class="pass" type="hidden" name="pass" value="{$_POST['password']}">
验证码<input class="text" type="text" name="code" maxlength="4"  pattern="[\w|\d]{4}$"
title="验证码不合格" placeholder="请输入上图字符" value=""><br>
<input type="submit" value="提交">
<br>
HTML;
                include $pma->tpl . 'header.tpl';
                include $pma->tpl . 'addqq.tpl';
                include $pma->tpl . 'footer.tpl';
                die;
                break;

            case "password":
                $pma->msg_str = "密码错误<a href=\"{$_SERVER['PHP_SELF']}\">返回</a>";
                break;

            case "error":
                $pma->msg_str = "用户" . $str['qq'] . "登录频繁或服务器连接失败，请稍候再试<a href=\"{$_SERVER['PHP_SELF']}\">返回</a>";
                break;

            case "ok":
                $pma->msg_str = "登录成功<a href=\"index.php\">返回</a>";
                $u_sid_q = new ZAN($_POST['qq'], $_POST['password']);
                $read = $u_sid_q->qqsid();
                preg_match("/sid=(.*?)&/i", $read, $rs);
                $rs = !empty($rs) ? $rs : null;
                if (!$db->multi_query("INSERT INTO `qq_qqinfo` SET `id` = '" . $_SESSION['id'] . "',`user` = '$uin',`pass` = '$pwd',`depass` = '" . $_POST['password'] . "',`sid`='" . $rs['1'] . "',`time` = '" . $date_time . "'")) {
                    $pma->msg_str = "添加失败，原因：该QQ已经添加过<a href=\"{$_SERVER['PHP_SELF']}\">返回</a>";
                }
                break;
        }
    }
    if ($input == '2') {
        $qq_sidlogin = new ZAN($uin, $_POST['password']);
        if (isset($_POST['verify'])) {
            $post = <<<HTML
qq={$_POST['qq']}&u_token={$_POST['u_token']}&hexpwd={$_POST['hexpwd']}&sid={$_POST['sid']}&hexp={$_POST['hexp']}&nopre=&auto={$_POST['auto']}&loginTitle={$_POST['loginTitle']}&q_from={$_POST['q_from']}&modifySKey={$_POST['modifySKey']}&q_status={$_POST['q_status']}&r={$_POST['r']}&loginType={$_POST['loginType']}&login_url={$_POST['login_url']}&extend={$_POST['extend']}&r_sid={$_POST['r_sid']}&bid_code={$_POST['bid_code']}&bid={$_POST['bid']}&rip={$_POST['rip']}&verify={$_POST['verify']}&submitlogin={$_POST['submitlogin']}
HTML;
            $read = $qq_sidlogin->curl_post($post);
        } else {
            $read = $qq_sidlogin->qqsid($_POST['loginType']);
        }
        if (preg_match('/验证码/sim',$read)) {
            $pma->msg_str = $qq_sidlogin->code($read);
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'addqq.tpl';
        include $pma->tpl . 'footer.tpl';
        die;
        } else if (preg_match('/不正确/sim',$read)) {
            $pma->msg_str = '获取sid失败->密码错误（若是更新sid请返回页面修改密码）。<a href="javascript:window.history.back(-1);">返回</a>';
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'addqq.tpl';
        include $pma->tpl . 'footer.tpl';
        die;
        }
        preg_match("/sid=(.*?)&/i", $read, $rs);
        $rs = !empty($rs['1']) ? $rs['1'] : null;
        $pma->msg_str = "登录成功<a href=\"index.php\">返回首页</a>";
        $pwd = md5(trim($_POST['password'])); //md5加密密码
        $pwd = strtoupper($pwd);
        if (!$db->multi_query("INSERT INTO `qq_qqinfo` SET `id`='" . $_SESSION['id'] . "',`user`='" . $uin . "',`pass` ='$pwd',`depass`='" . $_POST['password'] . "',`sid`='" . $rs . "',`time`='" . $date_time . "'")) {
            $pma->msg_str = "添加失败，原因：该QQ已经添加过<a href=\"addqq.php\">返回</a>";
        }
    }
} else if ($get == "code" && !empty($_POST['qq'])) {
    if (!preg_match("/^[\w|\d]{4}$/i", $_POST['code'])) {
        $pma->msg_str = '验证码格式不正确,<a href="javascript:window.history.back(-1);">返回</a>重新输入';
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'addqq.tpl';
        include $pma->tpl . 'footer.tpl';
        die;
    }
    $im = new SET_MQQ($_POST['qq'], "");
    $code = json_decode($im->Verifycode($_POST['code']) , true); //处理验证码
    switch ($code['status']) {
        case "vc":
            unset($_SESSION['CODE']); //注销验证码
            $_SESSION['CODE'] = $code['res'];
            $id = session_id();
            $pma->msg_str = <<<HTML
你输入的验证码不正确，请重新输入<br>
请输入验证码:<br><img src="content/code.php?id={$id}">
<form action="{$_SERVER['PHP_SELF']}?win=code" method="post">
<input class="qq" type="hidden" name="qq" value="{$_POST['qq']}">
<input class="pass" type="hidden" name="pass" value="{$_POST['pass']}">
验证码<input class="text" type="text" name="code" maxlength="4"  pattern="[\w|\d]{4}$"
title="验证码不合格" placeholder="请输入上图字符" value=""><br>
<input type="submit" value="提交">
</form>
HTML;
            break;

        case "ok":
            $pma->msg_str = "登录成功<a href=\"index.php\">返回首页</a>";
            $pwd = md5(trim($_POST['pass'])); //md5加密密码
            $pwd = strtoupper($pwd);
            $u_sid_q = new ZAN($_POST['qq'], $_POST['pass']);
            $read = $u_sid_q->qqsid();
            preg_match("/sid=(.*?)&/i", $read, $rs);
            $rs = !empty($rs) ? $rs : null;
            if (!$db->multi_query("INSERT INTO `qq_qqinfo` SET `id`='" . $_SESSION['id'] . "',`user`='" . $_POST['qq'] . "',`pass` ='$pwd',`depass`='" . $_POST['pass'] . "',`sid`='" . $rs['1'] . "',`time`='" . $date_time . "'")) {
                $pma->msg_str = "添加失败，原因：该QQ已经添加过<a href=\"addqq.php\">返回</a>";
            }
            unset($_SESSION['CODE']);
            break;
    }
} else {
    $pma->msg_str = <<<HTML
<form action="{$_SERVER['PHP_SELF']}?win=login" method="post">
<select name="input">
<option value="1" selected="selected">协议登录</option>
<option value="2">3gQQ登录</option>
</select> 协议登录可能出现登录失败<br />
Q Q<input class="text" type="text" name="qq" maxlength="11" pattern="^[1-9][0-9]\d{3,9}$" title="请输入正确的QQ号" placeholder="请输入QQ号" value=""><br />
密码<input class="password" type="password" name="password" maxlength="16" placeholder="请输入密码" value=""><br>
<select id="loginType" name="loginType">
								<option value="3" selected="selected">
									不登录QQ聊天
								</option>
								<option value="1">
									同时在线登录QQ聊天
								</option>
								<option value="2">
									同时隐身登录QQ聊天
								</option>
							</select><br />
<input type="submit" value="提交">
</form>
<a href="index.php">返回首页</a>

<br>
HTML;
    
}
include $pma->tpl . 'header.tpl';
include $pma->tpl . 'addqq.tpl';
include $pma->tpl . 'footer.tpl';
$db->close();
?>