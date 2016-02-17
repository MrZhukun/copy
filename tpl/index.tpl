<?php
$msg_str=!empty($pma->msg_str)?$pma->msg_str:'还没添加QQ';
echo '<a href="index.php">首页</a> | <a href="addqq.php">添加</a> | <a href="?logout">注销</a><div class="msg">'.$msg_str.'</div><hr>';
if(isset($to_tal) AND $to_tal > 0):
echo'<div class="list">';
foreach((array)$pag_dt as $d):
echo '<li>'.htmlentities($d['user']).'</li>
<span class="info">
<a href="?info=edit&user='.htmlentities($d['user']).'">修改密码</a> | <a href="?info=sid&user='.htmlentities($d['user']).'">更新sid</a> | <a href="dislike.php?info=dislike&user='.htmlentities($d['user']).'">点赞禁止</a> | <a href="?info=delete&user='.htmlentities($d['user']).'">删除QQ</a><hr></span>';
endforeach;
echo '</div>';
if(ceil($to_tal / $per_P) > 1)
	echo "<div class='pag'>".$page_1->links()."</div>";
endif;
?>