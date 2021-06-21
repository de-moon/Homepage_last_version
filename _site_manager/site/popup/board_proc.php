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
	$search_order_target				= $mod->trans3($_REQUEST, "search_order_target", "POPUP_SEQ");
	$search_order_action				= $mod->trans3($_REQUEST, "search_order_action", "");

	$in_category							= $mod->trans3($_POST, "category", "");
	$in_view_yn							= $mod->trans3($_POST, "view_yn", "Y");
	$in_order_num						= $mod->trans3($_POST, "order_num", "1");
	$in_start_date							= $mod->trans3($_POST, "start_date", "");
	$in_end_date							= $mod->trans3($_POST, "end_date", "");
	$in_subject								= $mod->trans3($_POST, "subject", "");
	$in_input_type							= $mod->trans3($_POST, "input_type", "");
	$in_content								= $mod->html_filter2($_POST, "content");
	$in_link_url								= $mod->trans3($_POST, "link_url", "");
	$in_link_url_mobile					= $mod->trans3($_POST, "link_url_mobile", "");
	$in_link_target							= $mod->trans3($_POST, "link_target", "");
	$in_language_type					= $mod->trans3($_POST, "language_type", "KOR");
	$in_reg_date							= $mod->trans3($_POST, "reg_date", date("Y-m-d H:i:s", time()));
	$in_attach_one_count				= $mod->trans3($_POST, "attach_one_count", "0");
	$in_file_delete_list					= $mod->trans3($_POST, "check_delete_file", "0");

	if (strlen($in_reg_date) == 10) $in_reg_date = $in_reg_date ." " . date("H:i:s", time());


// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------

	if ($var_Mode == "NEW") {
		if ($search_division == "") $mod->javaAlerFunction("{$PARAMETER_002}[1]", "parent.button_recovery()");
		if ($in_input_type == "I" && $in_attach_one_count ==0) $mod->javaAlerFunction("{$PARAMETER_002}[이미지]", "parent.button_recovery()");
	}

	if ($var_Mode != "DEL") {
		if ($in_subject == "") $mod->javaAlerFunction("{$PARAMETER_002}[제목]", "parent.button_recovery()");
		if ($in_start_date == "") $mod->javaAlerFunction("{$PARAMETER_002}[시작일]", "parent.button_recovery()");
		if ($in_end_date == "") $mod->javaAlerFunction("{$PARAMETER_002}[종료일]", "parent.button_recovery()");
		if ($in_link_url == "") $mod->javaAlerFunction("{$PARAMETER_002}[링크]", "parent.button_recovery()");
		if ($in_link_url_mobile == "") $mod->javaAlerFunction("{$PARAMETER_002}[모바일 링크]", "parent.button_recovery()");
		if ($in_link_target == "") $mod->javaAlerFunction("{$PARAMETER_002}[링크 타겟]", "parent.button_recovery()");
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
if ($search_order_target != "POPUP_SEQ") $setParams[] = "search_order_target=".$search_order_target;
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
		$var_SQL .= "   DIVISION, ORDER_NUM, SUBJECT, CONTENT ";
		$var_SQL .= " , INPUT_TYPE, LINK_URL, LINK_URL_MOBILE, LINK_TARGET ";
		$var_SQL .= " , START_DATE, END_DATE, VIEW_YN, REGISTER_IP ";
		$var_SQL .= " , LANGUAGE_TYPE, REG_DATE ";
		$var_SQL .= " ) VALUES ( ";
		$var_SQL .= "   ?, ?, ?, ? ";
		$var_SQL .= " , ?, ?, ?, ? ";
		$var_SQL .= " , ?, ?, ?, ? ";
		$var_SQL .= " , ?, ? ";
		$var_SQL .= " ); ";

		$param[] = $search_division;
		$param[] = $in_order_num;
		$param[] = $in_subject;
		$param[] = $in_content;
		$param[] = $in_input_type;
		$param[] = $in_link_url;
		$param[] = $in_link_url_mobile;
		$param[] = $in_link_target;
		$param[] = $in_start_date;
		$param[] = $in_end_date;
		$param[] = $in_view_yn;
		$param[] = $USER_IP;
		$param[] = $in_language_type;
		$param[] = $in_reg_date;

		$stmt = $pdo->prepare($var_SQL);
		$arrayStart = 1;
		for ($i = 0; $i < count($param); $i++) {
			$stmt->bindParam($arrayStart, $param[$i]);
			$arrayStart++;
		}
		//echo $mod->sql_debug($var_SQL, $param);
		$stmt->execute();
		$col_popup_seq = $pdo->lastInsertId();

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
				$var_SQL .= "   FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, FILE_NO, REGISTER_IP, REG_DATE, POPUP_SEQ ";
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
				$param[] = $col_popup_seq;

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
		$var_SQL .= "   ORDER_NUM					= ? ";
		$var_SQL .= " , SUBJECT							= ? ";
		$var_SQL .= " , CONTENT						= ? ";
		$var_SQL .= " , INPUT_TYPE					= ? ";
		$var_SQL .= " , LINK_URL							= ? ";
		$var_SQL .= " , LINK_URL_MOBILE			= ? ";
		$var_SQL .= " , LINK_TARGET					= ? ";
		$var_SQL .= " , START_DATE					= ? ";
		$var_SQL .= " , END_DATE						= ? ";
		$var_SQL .= " , VIEW_YN							= ? ";
		$var_SQL .= " , LANGUAGE_TYPE				= ? ";
		$var_SQL .= " WHERE POPUP_SEQ = ?; ";

		$param[] = $in_order_num;
		$param[] = $in_subject;
		$param[] = $in_content;
		$param[] = $in_input_type;
		$param[] = $in_link_url;
		$param[] = $in_link_url_mobile;
		$param[] = $in_link_target;
		$param[] = $in_start_date;
		$param[] = $in_end_date;
		$param[] = $in_view_yn;
		$param[] = $in_language_type;
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
			$var_SQL	=	"SELECT COUNT(FILE_SEQ) as file_count FROM ".$BOARD_TABLENAME."_FILE WHERE FILE_TYPE='".$check_file_type."' and POPUP_SEQ = ?";
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
				$var_SQL .= "   FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, FILE_NO, REGISTER_IP, REG_DATE, POPUP_SEQ ";
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
				$stmt = $pdo->prepare("UPDATE ".$BOARD_TABLENAME." SET DEL_YN = 'Y' WHERE POPUP_SEQ = :no");
				$stmt->bindParam(":no", $var_Num[$i]);
				$result = $stmt->execute();
			}
		} else {
			$stmt = $pdo->prepare("UPDATE ".$BOARD_TABLENAME." SET DEL_YN = 'Y' WHERE POPUP_SEQ = :no");
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