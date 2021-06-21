<?php
if (empty($_SESSION['MALGUM_USER_SEQ']) || $_SESSION['MALGUM_USER_SEQ'] == "") {
	$_SESSION['MALGUM_USER_SEQ']				= "";
	$_SESSION['MALGUM_USER_ID']					= "";
	$_SESSION['MALGUM_USER_NAME']				= "";
	$_SESSION['MALGUM_EMAIL']						= "";
	$_SESSION['MALGUM_AUTHORITY']				= "";
	$_SESSION['MALGUM_AUTHORITY_DETAIL']	= "";
	$_SESSION['MALGUM_LOGIN_IP']					= "";

	$mod->javalo("로그인 정보가 없거나\\n장시간 사용하지 않아 로그아웃 되었습니다.", $ADMINROOT."/login.php");
}

if ($ADMIN_LOGIN_IP != "") {
	$arr_admin_login_ip = explode(",", $ADMIN_LOGIN_IP);
	foreach ($arr_admin_login_ip as $ip_item) {
		if ($ip_item == $_SESSION['MALGUM_LOGIN_IP']) {
			$ip_check = true;
		}
	}

	if (!$ip_check) {
		$mod->javalo("접근할 수 없는 IP 입니다.", $ADMINROOT."/login.php");
	}
}
?>