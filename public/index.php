<?php
define('APPLICATION_PATH', dirname(dirname(__FILE__)));
if (!file_exists(APPLICATION_PATH.'/vendor/autoload.php')) {
    echo '文件不存在';
}

