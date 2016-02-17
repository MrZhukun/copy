<?php
include dirname(__FILE__).'/include/header.php';
include dirname(__FILE__) . '/lib/zan_class.php';
$pma->name='管理';
$info=isset($_GET['info'])?$_GET['info']:'';
if (isset($_POST['input'])){
$new_pass=isset($_POST['new_pass'])?strtoupper(md5(trim($_POST['new_pass']))):'';
$pass=isset($_POST['password'])?strtoupper(md5(trim($_POST['password']))):'';
$qq=isset($_POST['user'])?trim($_POST['user']):$_POST['qq'];
switch ($_POST['input']){
case '0':
$msg='修改密码成功';
$sql="UPDATE `qq_qqinfo` SET `pass` = '$new_pass' WHERE ( `user` = '$qq' )";
break;
case '1':
$msg='删除QQ成功';
$sql="DELETE FROM `qq_qqinfo` WHERE ( `user` = '$qq' ) LIMIT 1";
break;
case '2':
$msg='提取sid成功';
$uin = new ZAN($qq,$_POST['password']);
if(isset($_POST['verify'])){
$post=<<<HTML
qq={$_POST['qq']}&u_token={$_POST['u_token']}&hexpwd={$_POST['hexpwd']}&sid={$_POST['sid']}&hexp={$_POST['hexp']}&nopre=&auto={$_POST['auto']}&loginTitle={$_POST['loginTitle']}&q_from={$_POST['q_from']}&modifySKey={$_POST['modifySKey']}&q_status={$_POST['q_status']}&r={$_POST['r']}&loginType={$_POST['loginType']}&login_url={$_POST['login_url']}&extend={$_POST['extend']}&r_sid={$_POST['r_sid']}&bid_code={$_POST['bid_code']}&bid={$_POST['bid']}&rip={$_POST['rip']}&verify={$_POST['verify']}&submitlogin={$_POST['submitlogin']}
HTML;

$read=$uin->curl_post($post);
}else{
$read=$uin->qqsid($_POST['loginType']);
}
if(preg_match('/验证码/sim',$read)) {
$msg=$uin->code($read);
}else if(preg_match('/不正确/sim',$read)){
$msg='获取sid失败->当前QQ的保存的密码不正确，请返回页面修改密码。<a href="javascript:window.history.back(-1);">返回</a>';
}else{
preg_match("/sid=(.*?)&/i",$read,$rs);
}
$rs=isset($rs['1'])?$rs['1']:'';
$sql="UPDATE `qq_qqinfo` SET `sid` = '".$rs."' WHERE ( `user` = '".$qq."' )";
break;
}
if(!$sql_1 = $db -> query( "SELECT * FROM `qq_qqinfo` WHERE ( `user` = '".$qq."' AND `id` = '".$_SESSION['id']."' )")){
die('数据库连接失败:'.$db->error);
}
$edit_pass = $sql_1->fetch_assoc();
if ($edit_pass['pass']!==$pass){
$pma->msg_str='密码错误，<a href="javascript:window.history.back(-1);">返回</a>';
include $pma->tpl.'header.tpl';
include $pma->tpl.'index.tpl';
include $pma->tpl.'footer.tpl';
die;
}
($db -> query($sql))?$pma->msg_str=$msg:die('数据库连接失败:'.$db->error);
}else if (isset($_REQUEST['user'])){
if(!$sql = $db -> query( "SELECT * FROM `qq_qqinfo` WHERE ( `user` = '".$_REQUEST['user']."' AND `id` = '".$_SESSION['id']."' )")){
die('数据库连接失败:'.$db->error);
}
$edit = $sql->fetch_assoc();
if (empty($edit['user'])){
$pma->msg_str='该账户不存在此QQ号';
include $pma->tpl.'header.tpl';
include $pma->tpl.'index.tpl';
include $pma->tpl.'footer.tpl';
die;
}
if ($info=='edit'){
$pma->msg_str=<<<HTML
<li>修改{$_GET['user']}的密码</li>
<form action="{$_SERVER['PHP_SELF']}" method="post">
<input type="hidden" name="input" value="0">
<input type="hidden" name="user" value="{$_GET['user']}">
原密码：<input type="password" name="password" maxlength="16" placeholder="请输入原密码" value="">*<br>
新密码：<input type="password" name="new_pass" maxlength="16" placeholder="请输入新密码" value="">*<br>
<input type="submit" value="修改密码">
</form>
<a href="{$_SERVER['PHP_SELF']}">返回</a>
HTML;
}else if($info=='delete'){
$pma->msg_str=<<<HTML
<li>请输入{$_GET['user']}的密码确认删除</li>
<form action="{$_SERVER['PHP_SELF']}" method="post">
<input type="hidden" name="input" value="1">
<input type="hidden" name="user" value="{$_GET['user']}">
密码：<input type="password" name="password" maxlength="16" placeholder="请输入密码" value="">*<br>
<input type="submit" value="确认删除">
</form>
<a href="{$_SERVER['PHP_SELF']}">返回</a>
HTML;
}else if($info=='sid'){
$pma->msg_str=<<<HTML
<li>添加{$_GET['user']}sid</li>
<form action="{$_SERVER['PHP_SELF']}" method="post" >
<input type="hidden" name="input" value="2">
<input type="hidden" name="user" value="{$_GET['user']}">
密码：<input type="password" name="password" maxlength="16" placeholder="请输入密码" value="">*
<br />登录方式:<br />
<select name="loginType">
<option value="3" selected="selected">不登录QQ聊天</option>
<option value="1">同时在线登录QQ聊天</option>
<option value="2">同时隐身登录QQ聊天</option>
</select>
<input type="submit" name="loginsubmit" value="获取sid" />
</form>

HTML;

}

}else{
if(!$result = $db -> query( "SELECT * FROM `qq_qqinfo` WHERE ( `id` = '".$_SESSION['id']."' )")){
die('数据库连接失败:'.$db->error);
}
	while($row = $result->fetch_assoc()) {
	$data_1[]=$row; 
	}
$to_tal=!empty($data_1)?count($data_1):0;

if($to_tal > 0) 
{
	// pagination
	$per_P=10;
	$page_1 = new pagination;
	$pag_dat = $page_1->generate($data_1,$per_P);
		foreach((array)$pag_dat as $pag_data) {
			$pag_dt[]=$pag_data;
		}
	$pma->msg_str=<<<HTML
你已添加{$to_tal}个QQ
HTML;
	}
}
include $pma->tpl.'header.tpl';
include $pma->tpl.'index.tpl';
include $pma->tpl.'footer.tpl';
$db->close();
?>