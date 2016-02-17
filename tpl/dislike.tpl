<?php
$msg_str=!empty($pma->msg_str)?$pma->msg_str:'该QQ还未添加,返回<a href="index.php">首页</a>';
$_msg=$_SERVER['PHP_SELF'].'?info=dislike&'.preg_replace("/info=.*?&|&disqq=\d{5,11}/","",$_SERVER['QUERY_STRING']);
$_msgadd=$_SERVER['PHP_SELF'].'?info=addqq&'.preg_replace("/info=.*?&|&disqq=\d{5,11}/","",$_SERVER['QUERY_STRING']);
echo<<<HTML
<a href="index.php">首页</a> | <a href="{$_msg}">返回</a>
HTML;
echo ((!empty($_GET['user']) && $info=='dislike')?' | <a href="'.$_msgadd.'">添加QQ</a>':'').'<br>'.$msg_str;
if(isset($to_tal) AND $to_tal > 0):
foreach((array)$pag_dt as $d):
echo '<div class="info"><li>['.htmlentities($d['myqq']).']->'.htmlentities($d['disqq']).'</li><a href="?info=edit&user='.htmlentities($d['myqq']).'&disqq='.htmlentities($d['disqq']).'">修改QQ</a> | <a href="?info=delete&user='.htmlentities($d['myqq']).'&disqq='.htmlentities($d['disqq']).'">删除QQ</a>';
if(!isset($_GET['user'])){
echo' | <a href="?info=addqq&user='.htmlentities($d['myqq']).'">添加QQ</a></div>';
}
echo '<hr>';
endforeach;
if(ceil($to_tal / $per_P) > 1)
	echo "<div class='pag'>".$page_->links()."</div>";
endif;
?>