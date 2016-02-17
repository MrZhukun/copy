<?php
/*
用户名　 : SAE_MYSQL_USER
密　　码 : SAE_MYSQL_PASS
主库域名 : SAE_MYSQL_HOST_M
从库域名 : SAE_MYSQL_HOST_S
端　　口 : SAE_MYSQL_PORT
数据库名 : SAE_MYSQL_DB
*/
define('DB_HOST', SAE_MYSQL_HOST_M.":".SAE_MYSQL_PORT);
define('DB_USER', SAE_MYSQL_USER);
define('DB_PASS', SAE_MYSQL_PASS);
define('DB_TABLE', SAE_MYSQL_DB);
/*
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_TABLE', 'qq');
*/
?>
