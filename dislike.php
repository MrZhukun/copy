<?php
include dirname(__FILE__) . '/include/header.php';
$pma->name = '点赞QQ管理';
$info=isset($_GET['info'])?$_GET['info']:'';
if ($info == 'dislike' && !empty($_GET['user'])) {
    $sql = "SELECT * FROM `qq_dislike` WHERE ( `id` = '" . $_SESSION['id'] . "' ) AND ( `myqq` = '" . $_REQUEST['user'] . "')";
} else if (!empty($_REQUEST['user']) && !empty($_REQUEST['disqq'])) {
    $sql = "SELECT * FROM `qq_dislike` WHERE (`id`='" . $_SESSION['id'] . "') AND ( `myqq` = '" . $_REQUEST['user'] . "') AND ( `disqq` = '" . $_REQUEST['disqq'] . "')";
} else if (!empty($_REQUEST['user']) && isset($_REQUEST['user'])) {
    $sql = "SELECT * FROM `qq_qqinfo` WHERE ( `user` = '" . $_REQUEST['user'] . "' AND `id` = '" . $_SESSION['id'] . "' )";
} else {
    $sql = "SELECT * FROM `qq_dislike` WHERE (`id`='" . $_SESSION['id'] . "')";
}
if (isset($_POST['no'])) {
    switch ($_POST['no']) {
        case ' 0':
            $msg = '添加成功';
            $sql_zx = "INSERT INTO `qq_dislike` SET `id` = '" . $_SESSION['id'] . "',`myqq` = '" . $_POST['user'] . "',`disqq` = '" . $_POST['adddisqq'] . "'";
            break;

        case '1':
            $msg = '修改成功';
            $sql_zx = "UPDATE `qq_dislike` SET `disqq` = '" . $_POST['newdisqq'] . "' WHERE ( `id` = '" . $_SESSION['id'] . "' ) AND ( `myqq` = '" . $_POST['user'] . "' ) AND ( `disqq` = '" . $_POST['disqq'] . "' )";
            break;

        case '2':
            $msg = '删除成功';
            $sql_zx = "DELETE FROM `qq_dislike` WHERE ( `id` = '" . $_SESSION['id'] . "' ) AND ( `myqq` = '" . $_POST['user'] . "' ) AND ( `disqq` = '" . $_POST['disqq'] . "' )";
            break;
    }
    ($db->query($sql_zx)) ? $pma->msg_str = $msg : die('数据库连接失败:' . $db->error);
} else if ((isset($_REQUEST['user']) or isset($_REQUEST['disqq'])) AND $info!='dislike') {
    if (!$sql_sql = $db->query($sql)) {
        die('数据库连接失败:' . $db->error);
    }
    $edit = $sql_sql->fetch_assoc();
    if (empty($edit)) {
        $pma->msg_str = '该账户列表为空或不存在此QQ号';
        include $pma->tpl . 'header.tpl';
        include $pma->tpl . 'dislike.tpl';
        include $pma->tpl . 'footer.tpl';
        die;
    }

if ($info == 'addqq') {
    $pma->msg_str = <<<HTML
<li>管理QQ：{$_GET['user']}</li>
<form action="{$_SERVER['PHP_SELF']}" method="post">
<input type="hidden" name="no" value="0">
<input type="text" name="adddisqq" maxlength="11" pattern="^[1-9][0-9]\d{3,9}$" title="请输入正确的QQ号" placeholder="请输入QQ号" value="">
<input type="hidden" name="user" value="{$_GET['user']}">
<input type="submit" value="确认添加">
</form>
HTML;
    
} else if ($info == 'edit') {
    $pma->msg_str = <<<HTML
<li>管理QQ：{$_GET['user']}</li>
<form action="{$_SERVER['PHP_SELF']}" method="post">
<input type="hidden" name="no" value="1">
<input type="text" name="newdisqq" maxlength="11" pattern="^[1-9][0-9]\d{3,9}$" title="请输入正确的QQ号" placeholder="请输入QQ号" value="{$_GET['disqq']}">
<input type="hidden" name="disqq" value="{$_GET['disqq']}">
<input type="hidden" name="user" value="{$_GET['user']}">
<input type="submit" value="确认修改">
</form>
HTML;
    
} else if ($info == 'delete') {
    $pma->msg_str = <<<HTML
<li>管理QQ：{$_GET['user']}</li>
确定删除{$_GET['disqq']}？
<form action="{$_SERVER['PHP_SELF']}" method="post">
<input type="hidden" name="no" value="2">
<input type="hidden" name="disqq" value="{$_GET['disqq']}">
<input type="hidden" name="user" value="{$_GET['user']}">
<input type="submit" value="确认删除">
</form>
HTML;
}
}else{
if (!$result = $db->query($sql)) {
        die('数据库连接失败:' . $db->error);
    }
    while ($row = $result->fetch_assoc()) {
        $data_1[] = $row;
    }
    $to_tal = !empty($data_1) ? count($data_1) : 0;
    if ($to_tal > 0) {
        // pagination
        $per_P = 10;
        $page_1 = new pagination;
        $pag_dat = $page_1->generate($data_1, $per_P);
        foreach ((array)$pag_dat as $pag_data) {
            $pag_dt[] = $pag_data;
        }
        $pma->msg_str = <<<HTML
你已添加{$to_tal}个不需要点赞的QQ
HTML;
        
    }
}
include $pma->tpl . 'header.tpl';
include $pma->tpl . 'dislike.tpl';
include $pma->tpl . 'footer.tpl';
$db->close();
?>
