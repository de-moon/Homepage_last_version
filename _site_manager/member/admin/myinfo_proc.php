<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/commonHeader.php";
include_once "./board_info.php";


try {

// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------

	$var_Mode								= "EDT";

	$in_user_division					= $mod->trans3($_POST, "user_division",  "9");
	$in_user_id								= $mod->trans3($_POST, "user_id",  "");
	$in_user_name						= $mod->trans3($_POST, "user_name",  "");
	$in_password							= $mod->trans3($_POST, "password",  "");
	$in_telephone_1						= $mod->trans3($_POST, "telephone_1",  "");
	$in_telephone_2						= $mod->trans3($_POST, "telephone_2",  "");
	$in_telephone_3						= $mod->trans3($_POST, "telephone_3",  "");
	$in_cellphone_1						= $mod->trans3($_POST, "cellphone_1",  "");
	$in_cellphone_2						= $mod->trans3($_POST, "cellphone_2",  "");
	$in_cellphone_3						= $mod->trans3($_POST, "cellphone_3",  "");
	$in_email								= $mod->trans3($_POST, "email",  "");
	$in_zip_code							= $mod->trans3($_POST, "zip_code",  "");
	$in_address							= $mod->trans3($_POST, "address",  "");
	$in_address_details					= $mod->trans3($_POST, "address_details",  "");
	$in_gender								= $mod->trans3($_POST, "gender",  "");
	$in_birthdate							= $mod->trans3($_POST, "birthdate",  "");
	$in_lunar_yn							= $mod->trans3($_POST, "lunar_yn",  "Y");
	$in_sms_yn							= $mod->trans3($_POST, "sms_yn",  "N");
	$in_email_yn							= $mod->trans3($_POST, "email_yn",  "N");
	$in_user_state						= $mod->trans3($_POST, "user_state",  "1");
	$in_language_type					= $mod->trans3($_POST, "language_type",  "KOR");
	$in_authority							= $mod->trans3($_POST, "authority",  "");
	$in_authority_detail					= $mod->trans3($_POST, "authority_detail",  "");

	$password_now						= $mod->trans3($_POST, "password_now", "");

	$in_telephone							= $in_telephone_1 . "-" . $in_telephone_2 . "-" . $in_telephone_3;
	$in_cellphone							= $in_cellphone_1 . "-" . $in_cellphone_2 . "-" . $in_cellphone_3;


// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------

	if ($var_Mode == "EDT") {
		if ($password_now == "") $mod->javaAlerFunction("{$PARAMETER_002}[현재 비밀번호]", "parent.button_recovery()");
		if ($in_user_name == "") $mod->javaAlerFunction("{$PARAMETER_002}[이름]", "parent.button_recovery()");
	}


// ----------------------------------------------------------------------------------------------------
// ## DB 연결 / 트랜젝션
// ----------------------------------------------------------------------------------------------------

	$pdo->beginTransaction();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// ####################################################################################################
// ## 수정
// ####################################################################################################

	if ($var_Mode == "EDT") {

		// 현재 비밀번호 확인
		$var_SQL = "SELECT";
		$var_SQL .= " A.USER_SEQ, A.USER_ID, A.USER_NAME, AES_DECRYPT(UNHEX(A.PASSWORD), MD5('m2a0l1g5u0m6')) PWD, A.EMAIL";
		$var_SQL .= ", A.LOGIN_CHECK";
		$var_SQL .= ", DATE_ADD(A.LOGIN_FAIL_DATE, INTERVAL 10 MINUTE ) AS LOGIN_FAIL_DATE";
		$var_SQL .= ", DATEDIFF(now(), DATE_ADD(A.LOGIN_FAIL_DATE, INTERVAL 10 MINUTE)) AS LOGIN_FAIL_DIFF";
		$var_SQL .= ", A.REG_DATE";
		$var_SQL .= ", B.AUTHORITY, B.AUTHORITY_DETAIL";
		$var_SQL .= " FROM TB_USER A INNER JOIN TB_ADMIN B ON A.USER_SEQ=B.USER_SEQ";
		$var_SQL .= " WHERE A.USER_DIVISION=9 AND A.USER_STATE=1 AND A.USER_SEQ = :no";

		$stmt = $pdo->prepare($var_SQL);
		$stmt->bindParam(":no", $_SESSION['MALGUM_USER_SEQ']);
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
			if($col_password != $password_now) {
				$mod->javaAlerFunction($LOGIN_001, "parent.button_recovery()");
			}
		} else {
			$mod->javaAlerFunction($DB_003, "parent.button_recovery()");
		}

		// 기본 정보수정
		$var_SQL = " UPDATE ".$BOARD_TABLENAME." SET ";
		$var_SQL .= "   USER_NAME				= ? ";
		$var_SQL .= " , TELEPHONE				= ? ";
		$var_SQL .= " , CELLPHONE				= ? ";
		$var_SQL .= " , EMAIL							= ? ";
		$var_SQL .= " , ZIP_CODE					= ? ";
		$var_SQL .= " , ADDRESS						= ? ";
		$var_SQL .= " , ADDRESS_DETAILS		= ? ";
		$var_SQL .= " , GENDER						= ? ";
		$var_SQL .= " , BIRTHDATE					= ? ";
		$var_SQL .= " , LUNAR_YN					= ? ";
		$var_SQL .= " , SMS_YN						= ? ";
		$var_SQL .= " , EMAIL_YN					= ? ";
		$var_SQL .= " WHERE USER_SEQ = ?";

		$param[] = $in_user_name;
		$param[] = $in_telephone;
		$param[] = $in_cellphone;
		$param[] = $in_email;
		$param[] = $in_zip_code;
		$param[] = $in_address;
		$param[] = $in_address_details;
		$param[] = $in_gender;
		$param[] = $in_birthdate;
		$param[] = $in_lunar_yn;
		$param[] = $in_sms_yn;
		$param[] = $in_email_yn;
		$param[] = $_SESSION['MALGUM_USER_SEQ'];

		$stmt = $pdo->prepare($var_SQL);
		$arrayStart = 1;
		for ($i = 0; $i < count($param); $i++) {
			$stmt->bindParam($arrayStart, $param[$i]);
			$arrayStart++;
		}
		//echo $mod->sql_debug($var_SQL, $param);
		$stmt->execute();

		// 비밀번호 수정
		if ($in_password != "") {
			$stmt = $pdo->prepare("SELECT HEX(AES_ENCRYPT(?, MD5('m2a0l1g5u0m6'))) pass");
			$stmt->bindParam(1, $in_password, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->bindColumn(1, $in_password);
			$stmt->fetch(PDO::FETCH_ASSOC);
			$stmt->closeCursor();

			$stmt = $pdo->prepare("UPDATE ".$BOARD_TABLENAME." SET PASSWORD=:PWD WHERE USER_SEQ=:USER_SEQ");
			$stmt->bindParam(":PWD", $in_password);
			$stmt->bindParam(":USER_SEQ", $_SESSION['MALGUM_USER_SEQ']);
			$stmt->execute();
		}

		$pdo->commit();
		$mod->javalo($DB_002,"myinfo_modify.php");

	} else {
		$mod->java($DB_001);
	}

} catch(Exception $e) {
	$pdo->rollback();
	echo $e->getMessage();
	$mod->javaAlerFunction($DB_003, "parent.button_recovery()");
	exit;
}
?>