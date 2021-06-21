<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/commonHeader.php";
include_once "./board_info.php";


try {

// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------

	$var_Page						= $mod->trans3($_REQUEST, "page", "1");
	$var_Mode						= $mod->trans3($_REQUEST, "mode", "NEW");
	$var_Num						= $mod->trans3($_REQUEST, "num", "");
	$var_ReplyNum				= $mod->trans3($_REQUEST, "replynum", "");
	$search_division				= $BOARD_DIVISION;
	$search_field					= $mod->trans3($_REQUEST, "search_field", "");
	$search_keyword			= $mod->trans3($_REQUEST, "search_keyword", "");
	$search_category			= $mod->trans3($_REQUEST, "search_category", "");
	$search_view_yn			= $mod->trans3($_REQUEST, "search_view_yn", "");
	$search_language_type	= $mod->trans3($_REQUEST, "search_language_type", "KOR");
	$search_pagesize			= $mod->trans3($_REQUEST, "search_pagesize", $BOARD_PAGESIZE);
	$search_order_target		= $mod->trans3($_REQUEST, "search_order_target", "BOARD_SEQ");
	$search_order_action		= $mod->trans3($_REQUEST, "search_order_action", "");

	$in_user_name				= $mod->trans3($_POST, "user_name", "");
	$in_password					= $mod->trans3($_POST, "password", "");
	$in_reply_content			= $mod->trans3($_POST, "reply_content", "");
	$in_user_division			= $mod->trans3($_POST, "user_division", "9");
	$in_reg_date					= $mod->trans3($_POST, "reg_date", date("Y-m-d H:i:s", time()));

	if (strlen($in_reg_date) == 10) $in_reg_date = $in_reg_date ." " . date("H:i:s", time());


// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------

	if ($var_Mode == "NEW") {
		if ($var_Num == "") $mod->javaAlerFunction("{$PARAMETER_002}[1]", "parent.button_recovery()");
	}

	if ($var_Mode != "DEL") {
		if ($in_reply_content == "") $mod->javaAlerFunction("{$PARAMETER_002}[2]", "parent.button_recovery()");
	}

	if ($var_Mode == "DEL" || $var_Mode == "EDT") {
		if ($var_Num == "") $mod->javaAlerFunction("{$PARAMETER_002}[3]", "parent.button_recovery()");
		if ($var_ReplyNum == "") $mod->javaAlerFunction("{$PARAMETER_002}[4]", "parent.button_recovery()");
	}


// ----------------------------------------------------------------------------------------------------
// ## 페이지 이동 파라미터
// ----------------------------------------------------------------------------------------------------

$setParams[] = "page=".$var_Page;
$setParams[] = "num=".$var_Num;
if ($search_field != "") $setParams[] = "search_field=".$search_field;
if ($search_keyword != "") $setParams[] = "search_keyword=".$search_keyword;
if ($search_category != "") $setParams[] = "search_category=".$search_category;
if ($search_view_yn != "") $setParams[] = "search_view_yn=".$search_view_yn;
if ($search_language_type != "") $setParams[] = "search_language_type=".$search_language_type;
if ($search_order_target != "BOARD_SEQ") $setParams[] = "search_order_target=".$search_order_target;
if ($search_order_action != "") $setParams[] = "search_order_action=".$search_order_action;

$setParams = implode("&",$setParams);


// ----------------------------------------------------------------------------------------------------
// ## 필터링 체크
// ----------------------------------------------------------------------------------------------------

	if ($var_Mode != "DEL") {
		If ($BOARD_FILTERING != "") {
			$arrFiltering = explode(",", $BOARD_FILTERING);
			for ($i = 0; $i < sizeof($arrFiltering); $i++) {
				if (strpos($in_reply_content, $arrFiltering[$i]) > -1) {
					$mod->javaAlerFunction("{$BOARD_001}[ $arrFiltering[$i] ]", "parent.button_recovery()");
				}
			}
		}
	}


// ----------------------------------------------------------------------------------------------------
// ## DB 연결 / 트랜젝션
// ----------------------------------------------------------------------------------------------------

	$pdo->beginTransaction();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// ####################################################################################################
// ## 등록
// ####################################################################################################

	if ($var_Mode == "NEW") {

		// 게시판 등록
		$var_SQL = " INSERT INTO ". $BOARD_TABLENAME ."_REPLY (";
		$var_SQL .= "   USER_NAME, PASSWORD, REPLY_CONTENT, USER_DIVISION, REGISTER_IP ";
		$var_SQL .= " , REG_DATE, BOARD_SEQ, USER_SEQ ";
		$var_SQL .= " ) VALUES ( ";
		$var_SQL .= "   ?, ?, ?, ?, ? ";
		$var_SQL .= " , ?, ?, ? ";
		$var_SQL .= " ); ";

		$param[] = $in_user_name;
		$param[] = $in_password;
		$param[] = $in_reply_content;
		$param[] = $in_user_division;
		$param[] = $USER_IP;
		$param[] = $in_reg_date;
		$param[] = $var_Num;
		$param[] = $_SESSION['MALGUM_USER_SEQ'];

		$stmt = $pdo->prepare($var_SQL);
		$arrayStart = 1;
		for ($i = 0; $i < count($param); $i++) {
			$stmt->bindParam($arrayStart, $param[$i]);
			$arrayStart++;
		}
		//echo $mod->sql_debug($var_SQL, $param);
		$stmt->execute();
		$col_board_seq = $pdo->lastInsertId();

		$pdo->commit();
		$mod->javalo($DB_009,"board_reply_list.php?".$setParams);



// ####################################################################################################
// ## 수정
// ####################################################################################################

	} else if ($var_Mode == "EDT") {

		// 기본 정보수정
		$var_SQL = " UPDATE ".$BOARD_TABLENAME."_REPLY SET ";
		$var_SQL .= "   REPLY_CONTENT			= ? ";
		$var_SQL .= " , REGISTER_IP					= ? ";
		$var_SQL .= " WHERE REPLY_SEQ = ?; ";

		$param[] = $in_reply_content;
		$param[] = $USER_IP;
		$param[] = $var_ReplyNum;

		$stmt = $pdo->prepare($var_SQL);
		$arrayStart = 1;
		for ($i = 0; $i < count($param); $i++) {
			$stmt->bindParam($arrayStart, $param[$i]);
			$arrayStart++;
		}
		//echo $mod->sql_debug($var_SQL, $param);
		$stmt->execute();

		$pdo->commit();
		$mod->javalo($DB_002,"board_reply_list.php?".$setParams);


// ####################################################################################################
// ## 삭제
// ####################################################################################################

	} else if ($var_Mode == "DEL") {

		if (strpos($var_ReplyNum, ",") > 0) {
			$var_ReplyNum = explode(",", $var_ReplyNum);
		}

		if (is_array($var_ReplyNum)) {
			for ($i = 0; $i < sizeof($var_ReplyNum); $i++) {
				$stmt = $pdo->prepare("UPDATE ".$BOARD_TABLENAME."_REPLY SET DEL_YN = 'Y' WHERE REPLY_SEQ = :no");
				$stmt->bindParam(":no", $var_ReplyNum[$i]);
				$result = $stmt->execute();
			}
		} else {
			$stmt = $pdo->prepare("UPDATE ".$BOARD_TABLENAME."_REPLY SET DEL_YN = 'Y' WHERE REPLY_SEQ = :no");
			$stmt->bindParam(":no", $var_ReplyNum);
			$stmt->execute();
		}

		$pdo->commit();
		$mod->javalo($DB_006,"board_reply_list.php?".$setParams);

	}

} catch(Exception $e) {
	$pdo->rollback();
	echo $e->getMessage();
	$mod->javaAlerFunction($DB_003, "parent.button_recovery()");
	exit;
}
?>