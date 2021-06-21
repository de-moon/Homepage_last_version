<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/commonHeader.php";
include_once "./board_info.php";


try {

// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------

	$var_Page								= $mod->trans3($_REQUEST, "page", "1");
	$var_Mode								= $mod->trans3($_REQUEST, "mode", "NEW");
	$var_Num								= $mod->trans3($_REQUEST, "num", "");
	$search_field							= $mod->trans3($_REQUEST, "search_field", "user_id");
	$search_keyword					= $mod->trans3($_REQUEST, "search_keyword", "");
	$search_authority					= $mod->trans3($_REQUEST, "search_authority", "");
	$search_pagesize					= $mod->trans3($_REQUEST, "search_pagesize", $BOARD_PAGESIZE);
	$search_order_target				= $mod->trans3($_REQUEST, "search_order_target", "USER_SEQ");
	$search_order_action				= $mod->trans3($_REQUEST, "search_order_action", "");

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

	$in_telephone							= $in_telephone_1 . "-" . $in_telephone_2 . "-" . $in_telephone_3;
	$in_cellphone							= $in_cellphone_1 . "-" . $in_cellphone_2 . "-" . $in_cellphone_3;

	$in_receivemail						= $mod->trans3($_POST, "receivemail", "0");
		
// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------

	if ($var_Mode == "NEW") {
		if ($in_user_id == "") $mod->javaAlerFunction("{$PARAMETER_002}1","parent.button_recovery()");
	}

	if ($var_Mode == "NEW" || $var_Mode == "EDT") {
		if ($in_user_name == "") $mod->javaAlerFunction("{$PARAMETER_002}2","parent.button_recovery()");
	}

	if ($var_Mode == "DEL" || $var_Mode == "EDT" || $var_Mode == "PWC") {
		if ($var_Num == "") $mod->javaAlerFunction("{$PARAMETER_002}3","parent.button_recovery()");
	}


// ----------------------------------------------------------------------------------------------------
// ## 페이지 이동 파라미터
// ----------------------------------------------------------------------------------------------------

$setParams[] = "page=".$var_Page;
if ($search_field != "user_id") $setParams[] = "search_field=".$search_field;
if ($search_keyword != "") $setParams[] = "search_keyword=".$search_keyword;
if ($search_authority != "") $setParams[] = "search_authority=".$search_authority;
if ($search_pagesize != $BOARD_PAGESIZE) $setParams[] = "search_pagesize=".$search_pagesize;
if ($search_order_target != "USER_SEQ") $setParams[] = "search_order_target=".$search_order_target;
if ($search_order_action != "") $setParams[] = "search_order_action=".$search_order_action;
if ($var_Mode == "EDT" || $var_Mode == "PWC") $setParams[] = "num=".$var_Num;

$setParams = implode("&",$setParams);


// ----------------------------------------------------------------------------------------------------
// ## DB 연결 / 트랜젝션
// ----------------------------------------------------------------------------------------------------

	$pdo->beginTransaction();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// ####################################################################################################
// ## 등록
// ####################################################################################################

	if ($var_Mode == "NEW") {

		// 아이디 중복 확인
		$var_SQL = "SELECT COUNT(*) CNT FROM ".$BOARD_TABLENAME." WHERE USER_ID=:id";
		$stmt = $pdo->prepare($var_SQL);
		$stmt->bindParam(":id", $in_user_id);
		$stmt->execute();
		$stmt->bindColumn(1, $cnt);
		$stmt->fetch(PDO::FETCH_ASSOC);
		$stmt->closeCursor();

		if ($cnt > 0) {
			$mod->javaAlerFunction($MEMBER_001,"parent.check_duplicate_false(); parent.button_recovery()");
		}

		// 비밀번호 암호화
		$var_SQL = "SELECT HEX(AES_ENCRYPT(?, MD5('m2a0l1g5u0m6'))) pass";
		$stmt = $pdo->prepare($var_SQL);
		$stmt->bindParam(1, $in_password, PDO::PARAM_STR);
		$stmt->execute();
		$stmt->bindColumn(1, $in_password);
		$stmt->fetch(PDO::FETCH_ASSOC);
		$stmt->closeCursor();

		// 기본정보 등록
		$var_SQL = " INSERT INTO ". $BOARD_TABLENAME ." (";
		$var_SQL .= "   USER_DIVISION, USER_ID, PASSWORD, USER_NAME ";
		$var_SQL .= " , TELEPHONE, CELLPHONE, EMAIL, ZIP_CODE ";
		$var_SQL .= " , ADDRESS, ADDRESS_DETAILS, GENDER, BIRTHDATE ";
		$var_SQL .= " , LUNAR_YN, SMS_YN, EMAIL_YN, USER_STATE ";
		$var_SQL .= " , LANGUAGE_TYPE, REG_DATE ";
		$var_SQL .= " ) VALUES ( ";
		$var_SQL .= "   ?, ?, ?, ? ";
		$var_SQL .= " , ?, ?, ?, ? ";
		$var_SQL .= " , ?, ?, ?, ? ";
		$var_SQL .= " , ?, ?, ?, ? ";
		$var_SQL .= " , ?, now() ";
		$var_SQL .= " ); ";

		$param[] = $in_user_division;
		$param[] = $in_user_id;
		$param[] = $in_password;
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
		$param[] = $in_user_state;
		$param[] = $in_language_type;

		$stmt = $pdo->prepare($var_SQL);
		$arrayStart = 1;
		for ($i = 0; $i < count($param); $i++) {
			$stmt->bindParam($arrayStart, $param[$i]);
			$arrayStart++;
		}
		//echo $mod->sql_debug($var_SQL, $param);
		$stmt->execute();
		$col_user_seq = $pdo->lastInsertId();

		// 관리자 정보 등록
		$var_SQL = "INSERT INTO TB_ADMIN (USER_SEQ, AUTHORITY, AUTHORITY_DETAIL) VALUES (?,?,?)";
		$stmt = $pdo->prepare($var_SQL);
		$stmt->bindParam(1, $col_user_seq);
		$stmt->bindParam(2, $in_authority);
		$stmt->bindParam(3, $in_authority_detail);
		$stmt->execute();
		
		$var_SQL = "INSERT INTO TB_USER_ADD (USER_SEQ, ETC_1) VALUES (?,?)";
		$stmt = $pdo->prepare($var_SQL);
		$stmt->bindParam(1, $col_user_seq);
		$stmt->bindParam(2, $in_receivemail);
		$stmt->execute();

		$pdo->commit();
		$mod->javalo($DB_009,"board_list.php");


// ####################################################################################################
// ## 수정
// ####################################################################################################

	} else if ($var_Mode == "EDT") {

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
		$param[] = $var_Num;

		$stmt = $pdo->prepare($var_SQL);
		$arrayStart = 1;
		for ($i = 0; $i < count($param); $i++) {
			$stmt->bindParam($arrayStart, $param[$i]);
			$arrayStart++;
		}
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
			$stmt->bindParam(":USER_SEQ", $var_Num);
			$stmt->execute();
		}

		// 관리자 정보 수정
		$var_SQL = " UPDATE TB_ADMIN SET";
		$var_SQL .= " AUTHORITY=?, AUTHORITY_DETAIL=?";
		$var_SQL .= " WHERE USER_SEQ=?";

		$stmt = $pdo->prepare($var_SQL);
		$stmt->bindParam(1, $in_authority);
		$stmt->bindParam(2, $in_authority_detail);
		$stmt->bindParam(3, $var_Num);
		$stmt->execute();
		
		$var_SQL = "UPDATE TB_USER_ADD SET ETC_1 =:RECMAIL WHERE USER_SEQ =:USERSEQ";
		$stmt = $pdo->prepare($var_SQL);
		$stmt->bindParam(":RECMAIL",$in_receivemail);
		$stmt->bindParam(":USERSEQ",$var_Num);
		$stmt->execute();

		$pdo->commit();
		$mod->javalo($DB_002,"board_view.php?".$setParams);


// ####################################################################################################
// ## 삭제
// ####################################################################################################

	} else if ($var_Mode == "DEL") {

		if (strpos($var_Num, ",") > 0) {
			$var_Num = explode(",", $var_Num);
		}

		if (is_array($var_Num)) {
			for ($i = 0; $i < sizeof($var_Num); $i++) {
				$stmt = $pdo->prepare("UPDATE ".$BOARD_TABLENAME." SET USER_STATE = 9 WHERE USER_SEQ = :no");
				$stmt->bindParam(":no", $var_Num[$i]);
				$stmt->execute();
			}
		} else {
			$stmt = $pdo->prepare("UPDATE ".$BOARD_TABLENAME." SET USER_STATE = 9 WHERE USER_SEQ = :no");
			$stmt->bindParam(":no", $var_Num);
			$stmt->execute();
		}

		$pdo->commit();
		$mod->javalo($DB_006,"board_list.php");


// ####################################################################################################
// ## 비밀번호 초기화
// ####################################################################################################

	} else if ($var_Mode == "PWC") {

		$in_password = "1234567";
		$stmt = $pdo->prepare("SELECT HEX(AES_ENCRYPT(?, MD5('m2a0l1g5u0m6'))) pass");
		$stmt->bindParam(1, $in_password, PDO::PARAM_STR);
		$stmt->execute();
		$stmt->bindColumn(1, $in_password);
		$stmt->fetch(PDO::FETCH_ASSOC);
		$stmt->closeCursor();

		$stmt = $pdo->prepare("UPDATE ".$BOARD_TABLENAME." SET PASSWORD=:PWD WHERE USER_SEQ=:USER_SEQ");
		$stmt->bindParam(":PWD", $in_password);
		$stmt->bindParam(":USER_SEQ", $var_Num);
		$stmt->execute();

		$pdo->commit();
		$mod->scalert("{$MEMBER_003} [1234567]");

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