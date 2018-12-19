<?php

dirname(dirname(__FILE__));

$str = "a:1:{i:0;a:4:{s:2:\"id\";i:20717;s:9:\"image_url\";s:54:\"upload/images/201812/5RnoQsM1544334623joF14Nb20717.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:1561;}}";
var_dump(unserialize($str));exit;