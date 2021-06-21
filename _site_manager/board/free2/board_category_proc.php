<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/commonHeader.php";
include_once "./board_info.php";


try {

// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------

	$var_Mode								= $mod->trans3($_REQUEST, "mode", "NEW");
	$var_Num								= $mod->trans3($_REQUEST, "num", "");
	$search_division						= $BOARD_DIVISION;
	$search_fielw_yn					= $mod->trans3($_REQUEST, "search_view_yn", "");
	$search_language_type			= $mod->trans3($_REQUEST, "search_language_type", "KOR");
	$var_category_level					= $mod->trans3($_REQUEST, "category_level", 1);
	$var_category_num					= $mod->trans3($_REQUEST, "category_num", 0);

	$in_subject								= $mod->trans3($_REQUEST, "subject", "");


// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------

	if ($var_Mode == "NEW") {
		if ($in_subject == "") $mod->scalert("{$PARAMETER_002}");
		if ($var_category_level > 1 && $var_category_num == 0) $mod->scalert("{$PARAMETER_002}");
	}

	if ($var_Mode == "EDT") {
		if ($in_subject == "") $mod->scalert("{$PARAMETER_002}");
	}

	if ($var_Mode == "ODR") {

	}

	if ($var_Mode == "DEL" || $var_Mode == "EDT") {
		if ($var_Num == "") $mod->scalert("{$PARAMETER_002}");
	}

// ----------------------------------------------------------------------------------------------------
// ## 페이지 이동 파라미터
// ----------------------------------------------------------------------------------------------------

$setParams[] = "search_language_type=".$search_language_type;
if ($var_category_level != "") $setParams[] = "category_level=".$var_category_level;
if ($var_category_num != "") $setParams[] = "category_num=".$var_category_num;

$setParams = implode("&",$setParams);


// ----------------------------------------------------------------------------------------------------
// ## 필터링 체크
// ----------------------------------------------------------------------------------------------------

//	if ($var_Mode != "DEL") {
//		If ($BOARD_FILTERING != "") {
//			$arrFiltering = explode(",", $BOARD_FILTERING);
//			for ($i = 0; $i < sizeof($arrFiltering); $i++) {
//				if (strpos($in_subject, $arrFiltering[$i]) > -1) {
//					$mod->javaAlerFunction("{$BOARD_002}[ $arrFiltering[$i] ]", "parent.button_recovery()");
//				}
//				if (strpos($in_content, $arrFiltering[$i]) > -1) {
//					$mod->javaAlerFunction("{$BOARD_001}[ $arrFiltering[$i] ]", "parent.button_recovery()");
//				}
//			}
//		}
//	}


// ----------------------------------------------------------------------------------------------------
// ## DB 연결 / 트랜젝션
// ----------------------------------------------------------------------------------------------------

	$pdo->beginTransaction();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// ####################################################################################################
// ## 등록
// ####################################################################################################

	if ($var_Mode == "NEW") {

		// 카테고리 정보
		$var_SQL = " SELECT ";
		$var_SQL .= "   MAX(ORDER_NUM)+1 AS CATEGORY_ORDER ";
		$var_SQL .= " FROM ".$BOARD_TABLENAME."_CATEGORY A";
		$var_SQL .= " WHERE A.DEL_YN = 'N' AND DIVISION = ? AND LANGUAGE_TYPE = ? ";
		$param[] = $search_division;
		$param[] = $search_language_type;

		If ($var_category_num != 0) {
			$var_SQL .= " AND PARENT_CATEGORY_SEQ= ? ";
			$param[] = $var_category_num;
		} else {
			$var_SQL .= " AND PARENT_CATEGORY_SEQ IS NULL ";
		}

		$stmt = $pdo->prepare($var_SQL);
		$arrayStart = 1;
		for ($i = 0; $i < count($param); $i++) {
			$stmt->bindParam($arrayStart, $param[$i]);
			$arrayStart++;
		}

		$stmt->execute();
		$stmt->bindColumn(1, $col_order_num);
		$stmt->fetch(PDO::FETCH_ASSOC);
		$stmt->closeCursor();

		if (is_null($col_order_num)) {
			$col_order_num = 1;
		}

		if ($var_category_num == 0) {
			$var_category_num = null;
		}

		// 게시물 등록
		$var_SQL = " INSERT INTO ". $BOARD_TABLENAME ."_CATEGORY (";
		$var_SQL .= "   DIVISION, LEVEL, ORDER_NUM, SUBJECT, LANGUAGE_TYPE ";
		$var_SQL .= " , PARENT_CATEGORY_SEQ, DEL_YN, REG_DATE ";
		$var_SQL .= " ) VALUES ( ";
		$var_SQL .= "   ?, ?, ?, ?, ? ";
		$var_SQL .= " , ?, 'N', now() ";
		$var_SQL .= " ); ";

		$param = null;
		$param[] = $search_division;
		$param[] = $var_category_level;
		$param[] = $col_order_num;
		$param[] = $in_subject;
		$param[] = $search_language_type;
		$param[] = $var_category_num;

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
		$mod->javalo($DB_009,"board_category_list.php?".$setParams);



// ####################################################################################################
// ## 수정
// ####################################################################################################

	} else if ($var_Mode == "EDT") {

		$var_SQL = " UPDATE ".$BOARD_TABLENAME."_CATEGORY SET ";
		$var_SQL .= "   SUBJECT = ? ";
		$var_SQL .= " WHERE CATEGORY_SEQ = ? ";

		$param[] = $in_subject;
		$param[] = $var_Num;

		$stmt = $pdo->prepare($var_SQL);
		$arrayStart = 1;
		for ($i = 0; $i < count($param); $i++) {
			$stmt->bindParam($arrayStart, $param[$i]);
			$arrayStart++;
		}
		//echo $mod->sql_debug($var_SQL, $param);
		$stmt->execute();

		$pdo->commit();
		$mod->javalo($DB_002,"board_category_list.php?".$setParams);


// ####################################################################################################
// ## 순서 변경
// ####################################################################################################

	} else if ($var_Mode == "ODR") {

		$category_seq = $_REQUEST['category_seq'];

		for ($k = 0; $k < sizeof($category_seq); $k++) {
			$var_SQL = " UPDATE ".$BOARD_TABLENAME."_CATEGORY SET ";
			$var_SQL .= "   ORDER_NUM = ? ";
			$var_SQL .= " WHERE CATEGORY_SEQ = ? ";

			$param[] = $k+1;
			$param[] = $category_seq[$k];

			$stmt = $pdo->prepare($var_SQL);
			$arrayStart = 1;
			for ($i = 0; $i < count($param); $i++) {
				$stmt->bindParam($arrayStart, $param[$i]);
				$arrayStart++;
			}
			//echo $mod->sql_debug($var_SQL, $param);
			$stmt->execute();
			$param = null;
		}

		$pdo->commit();
		$mod->javalo("순서 변경이 완료되었습니다.","board_category_list.php?".$setParams);


// ####################################################################################################
// ## 삭제
// ####################################################################################################

	} else if ($var_Mode == "DEL") {

		$var_SQL = " UPDATE ".$BOARD_TABLENAME."_CATEGORY SET ";
		$var_SQL .= "   DEL_YN='Y' ";
		$var_SQL .= " WHERE CATEGORY_SEQ = ? ";

		$param[] = $var_Num;

		$stmt = $pdo->prepare($var_SQL);
		$arrayStart = 1;
		for ($i = 0; $i < count($param); $i++) {
			$stmt->bindParam($arrayStart, $param[$i]);
			$arrayStart++;
		}
		//echo $mod->sql_debug($var_SQL, $param);
		$stmt->execute();

		$pdo->commit();
		$mod->javalo($DB_006,"board_category_list.php?".$setParams);

	}

} catch(Exception $e) {
	$pdo->rollback();
	echo $e->getMessage();
	$mod->scalert($DB_003);
	exit;
}
?>