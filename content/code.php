<?php
session_start();
if (isset($_GET['id'])) {
    if ($_GET['id'] == session_id()) {
        include dirname(dirname(__FILE__)) . '/lib/qq_login_class.php';
        header('Content-Type: image/png');
        $im = new SET_MQQ('', '');
        echo $im->hextopng($_SESSION['CODE']);
    }
}
?>