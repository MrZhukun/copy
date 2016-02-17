<?php
function xhtml_head() {
$name=NAME;
$title=func_get_arg(0);
echo <<<XHTML
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>{$title} - 〔{$name}〕</title>
        <link rel="stylesheet" href="./style.css">
    </head>
    <body>
        <div id="header">
	    文件管理器
        </div>

XHTML;
}
function xhtml_footer() {
echo <<<XHTML
        <div id="footer">
	     
        </div>
    </body>
</html>

XHTML;
}
?>