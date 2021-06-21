<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/commonHeader.php";


session_destroy();
$mod->javalo("정상적으로 로그아웃 되었습니다.", $ADMINROOT."/login.php");
?>