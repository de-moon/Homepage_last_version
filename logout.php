<?php
include_once $_SERVER['DOCUMENT_ROOT']."/common/include/commonHeader.php";


session_destroy();
$mod->javalo("정상적으로 로그아웃 되었습니다.", $FRONTROOT);
?>