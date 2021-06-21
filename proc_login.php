<?php
include_once $_SERVER['DOCUMENT_ROOT']."/common/include/commonHeader.php";


try {

// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------

	$var_returl			= $mod->trans2($_POST["returl"], "");
	$ins_id				= $mod->trans2($_POST["ins_id"], "");
	$ins_password	= $mod->trans2($_POST["ins_password"], "");


// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------

	if ($ins_id == "") $mod->java("{$PARAMETER_002}");
	if ($ins_password == "") $mod->java("{$PARAMETER_002}");


// ####################################################################################################
// ## 로그인 처리
// ####################################################################################################

	$var_SQL = "SELECT";
	$var_SQL .= " A.USER_SEQ, A.USER_ID, A.USER_NAME, AES_DECRYPT(UNHEX(A.PASSWORD), MD5('m2a0l1g5u0m6')) PWD, A.EMAIL";
	$var_SQL .= ", A.LOGIN_CHECK";
	$var_SQL .= ", DATE_ADD(A.LOGIN_FAIL_DATE, INTERVAL 10 MINUTE ) AS LOGIN_FAIL_DATE";
	$var_SQL .= ", DATEDIFF(now(), DATE_ADD(A.LOGIN_FAIL_DATE, INTERVAL 10 MINUTE)) AS LOGIN_FAIL_DIFF";
	$var_SQL .= ", A.REG_DATE";
	$var_SQL .= ", B.AUTHORITY, B.AUTHORITY_DETAIL";
	$var_SQL .= " FROM TB_USER A INNER JOIN TB_ADMIN B ON A.USER_SEQ=B.USER_SEQ";
	$var_SQL .= " WHERE A.USER_DIVISION=9 AND A.USER_STATE=1 AND A.USER_ID=:id";

	$stmt = $pdo->prepare($var_SQL);
	$stmt->bindParam(":id", $ins_id);
	$stmt->execute();
	$total = $stmt->rowCount();
	$stmt->bindColumn(1, $col_user_seq);
	$stmt->bindColumn(2, $col_user_id);
	$stmt->bindColumn(3, $col_user_name);
	$stmt->bindColumn(4, $col_password);
	$stmt->bindColumn(5, $col_email);
	$stmt->bindColumn(6, $col_login_check);
	$stmt->bindColumn(7, $col_login_fail_date);
	$stmt->bindColumn(8, $col_login_fail_diff);
	$stmt->bindColumn(9, $col_reg_date);
	$stmt->bindColumn(10, $col_authority);
	$stmt->bindColumn(11, $col_authority_detail);
	$stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();

	if ($total > 0) {
		if($col_password != $ins_password) {
			$var_SQL = "UPDATE TB_USER SET";
			$var_SQL .= " LOGIN_CHECK=LOGIN_CHECK+1";
			$var_SQL .= ", LOGIN_FAIL_DATE=now()";
			$var_SQL .= " WHERE USER_ID=:USER_ID";

			$stmt = $pdo->prepare($var_SQL);
			$stmt->bindParam(":USER_ID", $ins_id);
			$stmt->execute();

			$mod->java("비밀번호가 일치하지 않습니다.");
		} else {
			$_SESSION['WRJM_USER_SEQ'] = $col_user_seq;
			$_SESSION['WRJM_USER_ID'] = $col_user_id;
			$_SESSION['WRJM_USER_NAME'] = $col_user_name;

			$stmt = $pdo->prepare("UPDATE TB_USER SET LOGIN_CHECK=0, LOGIN_DATE=now(), LOGIN_COUNT=LOGIN_COUNT+1, LOGIN_IP=:ip WHERE USER_SEQ=:seq");
			$stmt->bindParam(":ip", $_SERVER['REMOTE_ADDR']);
			$stmt->bindParam(":seq", $col_user_seq);
			$stmt->execute();

			if ($stmt->rowCount() > 0) {
				if ($var_returl != "") {
					$mod->locate($var_returl);
				} else {
					$mod->locate($FRONTROOT);
				}
			} else {
				$mod->java("로그인에 실패하였습니다.");
			}
		}
	} else {
		$mod->java("등록된 아이디가 아니거나 비밀번호가 틀렸습니다.");
	}

} catch(Exception $e) {
	echo $e->getMessage();
	exit;
}
?>