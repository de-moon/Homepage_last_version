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
	$search_division						= $BOARD_DIVISION;
	$search_field							= $mod->trans3($_REQUEST, "search_field", "subject");
	$search_keyword					= $mod->trans3($_REQUEST, "search_keyword", "");
	$search_category					= $mod->trans3($_REQUEST, "search_category", "");
	$search_view_yn					= $mod->trans3($_REQUEST, "search_view_yn", "");
	$search_language_type			= $mod->trans3($_REQUEST, "search_language_type", "KOR");
	$search_pagesize					= $mod->trans3($_REQUEST, "search_pagesize", $BOARD_PAGESIZE);
	$search_order_target				= $mod->trans3($_REQUEST, "search_order_target", "BOARD_SEQ");
	$search_order_action				= $mod->trans3($_REQUEST, "search_order_action", "");

	$in_category							= $mod->trans3($_POST, "category", "");
	$in_subject								= $mod->trans3($_POST, "subject", "");
	$in_content								= $mod->html_filter2($_POST, "content");
	$in_hit									= $mod->trans3($_POST, "hit", "0");
	$in_notice_yn							= $mod->trans3($_POST, "notice_yn", "N");
	$in_view_yn							= $mod->trans3($_POST, "view_yn", "Y");
	$in_user_name						= $mod->trans3($_POST, "user_name", "");
	$in_password							= $mod->trans3($_POST, "password", "");
	$in_language_type					= $mod->trans3($_POST, "language_type", "KOR");
	$in_reg_date							= $mod->trans3($_POST, "reg_date", date("Y-m-d H:i:s", time()));
	$in_etc_1								= $mod->trans3($_POST, "etc_1", "");
	$in_etc_2								= $mod->trans3($_POST, "etc_2", "");
	$in_etc_3								= $mod->trans3($_POST, "etc_3", "");
	$in_etc_4								= $mod->trans3($_POST, "etc_4", "");
	$in_etc_5								= $mod->trans3($_POST, "etc_5", "");
	$in_etc_6								= $mod->trans3($_POST, "etc_6", "");
	$in_etc_7								= $mod->trans3($_POST, "etc_7", "");
	$in_etc_8								= $mod->trans3($_POST, "etc_8", "");
	$in_etc_9								= $mod->trans3($_POST, "etc_9", "");
	$in_etc_10								= $mod->trans3($_POST, "etc_10", "");
	$in_attach_one_count				= $mod->trans3($_POST, "attach_one_count", "0");
	$in_attach_images_count			= $mod->trans3($_POST, "attach_images_count", "0");
	$in_attach_all_count				= $mod->trans3($_POST, "attach_all_count", "0");
	$in_file_delete_list					= $mod->trans3($_POST, "check_delete_file", "0");

	if (strlen($in_reg_date) == 10) $in_reg_date = $in_reg_date ." " . date("H:i:s", time());

	if (!$BOARD_EDITOR) {
		$in_content								= $mod->trans3($_POST, "content", "");
	}


// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------

	if ($var_Mode == "NEW") {
		if ($search_division == "") $mod->javaAlerFunction("{$PARAMETER_002}[1]", "parent.button_recovery()");
	}

	if ($var_Mode != "DEL") {
		if ($in_subject == "") $mod->javaAlerFunction("{$PARAMETER_002}[2]", "parent.button_recovery()");
	}

	if ($var_Mode == "DEL" || $var_Mode == "EDT") {
		if ($var_Num == "") $mod->javaAlerFunction("{$PARAMETER_002}[3]", "parent.button_recovery()");
	}


// ----------------------------------------------------------------------------------------------------
// ## 페이지 이동 파라미터
// ----------------------------------------------------------------------------------------------------

$setParams[] = "page=".$var_Page;
if ($search_field != "subject") $setParams[] = "search_field=".$search_field;
if ($search_keyword != "") $setParams[] = "search_keyword=".$search_keyword;
if ($search_category != "") $setParams[] = "search_category=".$search_category;
if ($search_view_yn != "") $setParams[] = "search_view_yn=".$search_view_yn;
if ($search_language_type != "KOR") $setParams[] = "search_language_type=".$search_language_type;
if ($search_pagesize != $BOARD_PAGESIZE) $setParams[] = "search_pagesize=".$search_pagesize;
if ($search_order_target != "BOARD_SEQ") $setParams[] = "search_order_target=".$search_order_target;
if ($search_order_action != "") $setParams[] = "search_order_action=".$search_order_action;
if ($var_Mode == "EDT") $setParams[] = "num=".$var_Num;

$setParams = implode("&",$setParams);


// ----------------------------------------------------------------------------------------------------
// ## 필터링 체크
// ----------------------------------------------------------------------------------------------------

	if ($var_Mode != "DEL") {
		If ($BOARD_FILTERING != "") {
			$arrFiltering = explode(",", $BOARD_FILTERING);
			for ($i = 0; $i < sizeof($arrFiltering); $i++) {
				if (strpos($in_subject, $arrFiltering[$i]) > -1) {
					$mod->javaAlerFunction("{$BOARD_002}[ $arrFiltering[$i] ]", "parent.button_recovery()");
				}
				if (strpos($in_content, $arrFiltering[$i]) > -1) {
					$mod->javaAlerFunction("{$BOARD_001}[ $arrFiltering[$i] ]", "parent.button_recovery()");
				}
			}
		}
	}


// ####################################################################################################
// ## 업로드 파일 처리
// ####################################################################################################

	// 업로드 경로 설정
	$BOARD_FILE_PATH = $BOARD_FILE_PATH.$search_division;


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
		$var_SQL = " INSERT INTO ". $BOARD_TABLENAME ." (";
		$var_SQL .= "   DIVISION, CATEGORY, SUBJECT, CONTENT, HIT ";
		$var_SQL .= " , NOTICE_YN, VIEW_YN, USER_NAME, PASSWORD";
		$var_SQL .= " , REGISTER_IP, LANGUAGE_TYPE, REG_DATE ";
		$var_SQL .= " , ETC_1, ETC_2, ETC_3, ETC_4, ETC_5 ";
		$var_SQL .= " , ETC_6, ETC_7, ETC_8, ETC_9, ETC_10 ";
		$var_SQL .= " , USER_SEQ ";
		$var_SQL .= " ) VALUES ( ";
		$var_SQL .= "   ?, ?, ?, ?, ? ";
		$var_SQL .= " , ?, ?, ?, ? ";
		$var_SQL .= " , ?, ?, ? ";
		$var_SQL .= " , ?, ?, ?, ?, ? ";
		$var_SQL .= " , ?, ?, ?, ?, ? ";
		$var_SQL .= " , ? ";
		$var_SQL .= " ); ";

		$param[] = $search_division;
		$param[] = $in_category;
		$param[] = $in_subject;
		$param[] = $in_content;
		$param[] = $in_hit;
		$param[] = $in_notice_yn;
		$param[] = $in_view_yn;
		$param[] = $in_user_name;
		$param[] = $in_password;
		$param[] = $USER_IP;
		$param[] = $in_language_type;
		$param[] = $in_reg_date;
		$param[] = $in_etc_1;
		$param[] = $in_etc_2;
		$param[] = $in_etc_3;
		$param[] = $in_etc_4;
		$param[] = $in_etc_5;
		$param[] = $in_etc_6;
		$param[] = $in_etc_7;
		$param[] = $in_etc_8;
		$param[] = $in_etc_9;
		$param[] = $in_etc_10;
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

		// 게시판 파일 등록
		if($in_attach_one_count > 0) {
			$check_file_type = "attach_one";
			$attach_one_count = $in_attach_one_count;
			for($i=0; $i<$attach_one_count; $i++) {
				$attach_one_org_name	= $_REQUEST[$check_file_type . "_orgname_{$i}"];
				$attach_one_sav_name	= $_REQUEST[$check_file_type . "_tmpname_{$i}"];
				$attach_one_sav_flag		= $_REQUEST[$check_file_type . "_status_{$i}"];
				$attach_one_sav_size		= $_REQUEST[$check_file_type . "_size_{$i}"];
				$attach_one_sav_num		= $i;

				$var_SQL = " INSERT INTO ". $BOARD_TABLENAME ."_FILE (";
				$var_SQL .= "   FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, FILE_NO, REGISTER_IP, REG_DATE, BOARD_SEQ ";
				$var_SQL .= " ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? ) ";

				unset($param);
				$param[] = $BOARD_FILE_PATH;
				$param[] = $attach_one_org_name;
				$param[] = $attach_one_sav_name;
				$param[] = $attach_one_sav_size;
				$param[] = $check_file_type;
				$param[] = $attach_one_sav_num;
				$param[] = $USER_IP;
				$param[] = date("Y-m-d H:i:s", time());
				$param[] = $col_board_seq;

				$stmt = $pdo->prepare($var_SQL);
				$arrayStart = 1;
				for ($j = 0; $j < count($param); $j++) {
					$stmt->bindParam($arrayStart, $param[$j]);
					$arrayStart++;
				}
				//echo $mod->sql_debug($var_SQL, $param);
				$stmt->execute();
			}
		}

		if($in_attach_images_count > 0) {
			$check_file_type = "attach_images";
			$attach_one_count = $in_attach_images_count;
			for($i=0; $i<$attach_one_count; $i++) {
				$attach_one_org_name	= $_REQUEST[$check_file_type . "_orgname_{$i}"];
				$attach_one_sav_name	= $_REQUEST[$check_file_type . "_tmpname_{$i}"];
				$attach_one_sav_flag		= $_REQUEST[$check_file_type . "_status_{$i}"];
				$attach_one_sav_size		= $_REQUEST[$check_file_type . "_size_{$i}"];
				$attach_one_sav_num		= $i;

				$var_SQL = " INSERT INTO ". $BOARD_TABLENAME ."_FILE (";
				$var_SQL .= "   FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, FILE_NO, REGISTER_IP, REG_DATE, BOARD_SEQ ";
				$var_SQL .= " ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? ) ";

				unset($param);
				$param[] = $BOARD_FILE_PATH;
				$param[] = $attach_one_org_name;
				$param[] = $attach_one_sav_name;
				$param[] = $attach_one_sav_size;
				$param[] = $check_file_type;
				$param[] = $attach_one_sav_num;
				$param[] = $USER_IP;
				$param[] = date("Y-m-d H:i:s", time());
				$param[] = $col_board_seq;

				$stmt = $pdo->prepare($var_SQL);
				$arrayStart = 1;
				for ($j = 0; $j < count($param); $j++) {
					$stmt->bindParam($arrayStart, $param[$j]);
					$arrayStart++;
				}
				//echo $mod->sql_debug($var_SQL, $param);
				$stmt->execute();
			}
		}

		if($in_attach_all_count > 0) {
			$check_file_type = "attach_all";
			$attach_one_count = $in_attach_all_count;
			for($i=0; $i<$attach_one_count; $i++) {
				$attach_one_org_name	= $_REQUEST[$check_file_type . "_orgname_{$i}"];
				$attach_one_sav_name	= $_REQUEST[$check_file_type . "_tmpname_{$i}"];
				$attach_one_sav_flag		= $_REQUEST[$check_file_type . "_status_{$i}"];
				$attach_one_sav_size		= $_REQUEST[$check_file_type . "_size_{$i}"];
				$attach_one_sav_num		= $i;

				$var_SQL = " INSERT INTO ". $BOARD_TABLENAME ."_FILE (";
				$var_SQL .= "   FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, FILE_NO, REGISTER_IP, REG_DATE, BOARD_SEQ ";
				$var_SQL .= " ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? ) ";

				unset($param);
				$param[] = $BOARD_FILE_PATH;
				$param[] = $attach_one_org_name;
				$param[] = $attach_one_sav_name;
				$param[] = $attach_one_sav_size;
				$param[] = $check_file_type;
				$param[] = $attach_one_sav_num;
				$param[] = $USER_IP;
				$param[] = date("Y-m-d H:i:s", time());
				$param[] = $col_board_seq;

				$stmt = $pdo->prepare($var_SQL);
				$arrayStart = 1;
				for ($j = 0; $j < count($param); $j++) {
					$stmt->bindParam($arrayStart, $param[$j]);
					$arrayStart++;
				}
				//echo $mod->sql_debug($var_SQL, $param);
				$stmt->execute();
			}
		}


		$pdo->commit();
		$mod->javalo($DB_009,"board_list.php");



// ####################################################################################################
// ## 수정
// ####################################################################################################

	} else if ($var_Mode == "EDT") {

		// 기본 정보수정
		$var_SQL = " UPDATE ".$BOARD_TABLENAME." SET ";
		$var_SQL .= "   CATEGORY						= ? ";
		$var_SQL .= " , SUBJECT							= ? ";
		$var_SQL .= " , CONTENT						= ? ";
		$var_SQL .= " , NOTICE_YN						= ? ";
		$var_SQL .= " , VIEW_YN							= ? ";
		$var_SQL .= " , USER_NAME					= ? ";
		$var_SQL .= " , PASSWORD						= ? ";
		$var_SQL .= " , LANGUAGE_TYPE				= ? ";
		$var_SQL .= " , ETC_1								= ? ";
		$var_SQL .= " , ETC_2								= ? ";
		$var_SQL .= " , ETC_3								= ? ";
		$var_SQL .= " , ETC_4								= ? ";
		$var_SQL .= " , ETC_5								= ? ";
		$var_SQL .= " , ETC_6								= ? ";
		$var_SQL .= " , ETC_7								= ? ";
		$var_SQL .= " , ETC_8								= ? ";
		$var_SQL .= " , ETC_9								= ? ";
		$var_SQL .= " , ETC_10							= ? ";
		$var_SQL .= " WHERE BOARD_SEQ = ?; ";

		$param[] = $in_category;
		$param[] = $in_subject;
		$param[] = $in_content;
		$param[] = $in_notice_yn;
		$param[] = $in_view_yn;
		$param[] = $in_user_name;
		$param[] = $in_password;
		$param[] = $in_language_type;
		$param[] = $in_etc_1;
		$param[] = $in_etc_2;
		$param[] = $in_etc_3;
		$param[] = $in_etc_4;
		$param[] = $in_etc_5;
		$param[] = $in_etc_6;
		$param[] = $in_etc_7;
		$param[] = $in_etc_8;
		$param[] = $in_etc_9;
		$param[] = $in_etc_10;
		$param[] = $var_Num;

		$stmt = $pdo->prepare($var_SQL);
		$arrayStart = 1;
		for ($i = 0; $i < count($param); $i++) {
			$stmt->bindParam($arrayStart, $param[$i]);
			$arrayStart++;
		}
		//echo $mod->sql_debug($var_SQL, $param);
		$stmt->execute();

		// 게시판 파일 삭제
		if ( $in_file_delete_list ) {
			$file_delete_array		= explode(",", $in_file_delete_list);
			$file_delete_cnt			= count($file_delete_array);
			for ($f=0;$f<$file_delete_cnt;$f++) {
				$del_seqs	 = " Select FILE_SAVE";
				$del_seqs	.= ", FILE_PATH";
				$del_seqs	.= " From {$BOARD_TABLENAME}_FILE";
				$del_seqs	.= " Where FILE_SEQ=?";
				$stmds		= $pdo->prepare($del_seqs);
				$stmds->bindParam(1, $file_delete_array[$f]);
				$stmds->execute();
				$stmds->bindColumn(1, $del_file_save);
				$stmds->bindColumn(2, $del_file_path);
				$stmds->fetch(PDO::FETCH_ASSOC);
				$stmds->closeCursor();
				$delete_file_path = $_SERVER['DOCUMENT_ROOT'].$del_file_path."/".$del_file_save;

				@unlink($delete_file_path);
				
				$del_sql = " Delete From {$BOARD_TABLENAME}_FILE";
				$del_sql .= " Where FILE_SEQ=? ";
				$stmd = $pdo->prepare($del_sql);
				$stmd->bindParam(1, $file_delete_array[$f]);
				$stmd->execute();
			}
		}

		// 게시판 파일 등록
		if($in_attach_one_count > 0) {
			$check_file_type = "attach_one";
			$attach_one_count = $in_attach_one_count;

			// 기존 파일 등록 수
			$var_SQL	=	"SELECT COUNT(FILE_SEQ) as file_count FROM ".$BOARD_TABLENAME."_FILE WHERE FILE_TYPE='".$check_file_type."' and BOARD_SEQ = ?";
			$stm		= $pdo->prepare($var_SQL);
			$stm->bindParam(1, $var_Num);
			$stm->execute();
			$stm->bindColumn(1, $prev_attach_count);
			$stm->fetch(PDO::FETCH_ASSOC);
			$stm->closeCursor();

			for($i=0; $i<$attach_one_count; $i++) {
				$attach_one_org_name	= $_REQUEST[$check_file_type . "_orgname_{$i}"];
				$attach_one_sav_name	= $_REQUEST[$check_file_type . "_tmpname_{$i}"];
				$attach_one_sav_flag		= $_REQUEST[$check_file_type . "_status_{$i}"];
				$attach_one_sav_size		= $_REQUEST[$check_file_type . "_size_{$i}"];
				$attach_one_sav_num		= $prev_attach_count + $i;

				$var_SQL = " INSERT INTO ". $BOARD_TABLENAME ."_FILE (";
				$var_SQL .= "   FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, FILE_NO, REGISTER_IP, REG_DATE, BOARD_SEQ ";
				$var_SQL .= " ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? ) ";

				unset($param);
				$param[] = $BOARD_FILE_PATH;
				$param[] = $attach_one_org_name;
				$param[] = $attach_one_sav_name;
				$param[] = $attach_one_sav_size;
				$param[] = $check_file_type;
				$param[] = $attach_one_sav_num;
				$param[] = $USER_IP;
				$param[] = date("Y-m-d H:i:s", time());
				$param[] = $var_Num;

				$stmt = $pdo->prepare($var_SQL);
				$arrayStart = 1;
				for ($j = 0; $j < count($param); $j++) {
					$stmt->bindParam($arrayStart, $param[$j]);
					$arrayStart++;
				}
				//echo $mod->sql_debug($var_SQL, $param);
				$stmt->execute();
			}
		}

		if($in_attach_images_count > 0) {
			$check_file_type = "attach_images";
			$attach_one_count = $in_attach_images_count;

			// 기존 파일 등록 수
			$var_SQL	=	"SELECT COUNT(FILE_SEQ) as file_count FROM ".$BOARD_TABLENAME."_FILE WHERE FILE_TYPE='".$check_file_type."' and BOARD_SEQ = ?";
			$stm		= $pdo->prepare($var_SQL);
			$stm->bindParam(1, $var_Num);
			$stm->execute();
			$stm->bindColumn(1, $prev_attach_count);
			$stm->fetch(PDO::FETCH_ASSOC);
			$stm->closeCursor();

			for($i=0; $i<$attach_one_count; $i++) {
				$attach_one_org_name	= $_REQUEST[$check_file_type . "_orgname_{$i}"];
				$attach_one_sav_name	= $_REQUEST[$check_file_type . "_tmpname_{$i}"];
				$attach_one_sav_flag		= $_REQUEST[$check_file_type . "_status_{$i}"];
				$attach_one_sav_size		= $_REQUEST[$check_file_type . "_size_{$i}"];
				$attach_one_sav_num		= $prev_attach_count + $i;

				$var_SQL = " INSERT INTO ". $BOARD_TABLENAME ."_FILE (";
				$var_SQL .= "   FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, FILE_NO, REGISTER_IP, REG_DATE, BOARD_SEQ ";
				$var_SQL .= " ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? ) ";

				unset($param);
				$param[] = $BOARD_FILE_PATH;
				$param[] = $attach_one_org_name;
				$param[] = $attach_one_sav_name;
				$param[] = $attach_one_sav_size;
				$param[] = $check_file_type;
				$param[] = $attach_one_sav_num;
				$param[] = $USER_IP;
				$param[] = date("Y-m-d H:i:s", time());
				$param[] = $var_Num;

				$stmt = $pdo->prepare($var_SQL);
				$arrayStart = 1;
				for ($j = 0; $j < count($param); $j++) {
					$stmt->bindParam($arrayStart, $param[$j]);
					$arrayStart++;
				}
				//echo $mod->sql_debug($var_SQL, $param);
				$stmt->execute();
			}
		}

		if($in_attach_all_count > 0) {
			$check_file_type = "attach_all";
			$attach_one_count = $in_attach_all_count;

			// 기존 파일 등록 수
			$var_SQL	=	"SELECT COUNT(FILE_SEQ) as file_count FROM ".$BOARD_TABLENAME."_FILE WHERE FILE_TYPE='".$check_file_type."' and BOARD_SEQ = ?";
			$stm		= $pdo->prepare($var_SQL);
			$stm->bindParam(1, $var_Num);
			$stm->execute();
			$stm->bindColumn(1, $prev_attach_count);
			$stm->fetch(PDO::FETCH_ASSOC);
			$stm->closeCursor();

			for($i=0; $i<$attach_one_count; $i++) {
				$attach_one_org_name	= $_REQUEST[$check_file_type . "_orgname_{$i}"];
				$attach_one_sav_name	= $_REQUEST[$check_file_type . "_tmpname_{$i}"];
				$attach_one_sav_flag		= $_REQUEST[$check_file_type . "_status_{$i}"];
				$attach_one_sav_size		= $_REQUEST[$check_file_type . "_size_{$i}"];
				$attach_one_sav_num		= $prev_attach_count + $i;

				$var_SQL = " INSERT INTO ". $BOARD_TABLENAME ."_FILE (";
				$var_SQL .= "   FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, FILE_NO, REGISTER_IP, REG_DATE, BOARD_SEQ ";
				$var_SQL .= " ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? ) ";

				unset($param);
				$param[] = $BOARD_FILE_PATH;
				$param[] = $attach_one_org_name;
				$param[] = $attach_one_sav_name;
				$param[] = $attach_one_sav_size;
				$param[] = $check_file_type;
				$param[] = $attach_one_sav_num;
				$param[] = $USER_IP;
				$param[] = date("Y-m-d H:i:s", time());
				$param[] = $var_Num;

				$stmt = $pdo->prepare($var_SQL);
				$arrayStart = 1;
				for ($j = 0; $j < count($param); $j++) {
					$stmt->bindParam($arrayStart, $param[$j]);
					$arrayStart++;
				}
				//echo $mod->sql_debug($var_SQL, $param);
				$stmt->execute();
			}
		}

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
				$stmt = $pdo->prepare("UPDATE ".$BOARD_TABLENAME." SET DEL_YN = 'Y' WHERE BOARD_SEQ = :no");
				$stmt->bindParam(":no", $var_Num[$i]);
				$result = $stmt->execute();
			}
		} else {
			$stmt = $pdo->prepare("UPDATE ".$BOARD_TABLENAME." SET DEL_YN = 'Y' WHERE BOARD_SEQ = :no");
			$stmt->bindParam(":no", $var_Num);
			$stmt->execute();
		}

		$pdo->commit();
		$mod->javalo($DB_006,"board_list.php");

	}

} catch(Exception $e) {
	$pdo->rollback();
	echo $e->getMessage();
	$mod->javaAlerFunction($DB_003, "parent.button_recovery()");
	exit;
}
?>