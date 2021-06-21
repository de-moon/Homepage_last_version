<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/commonHeader.php";
include_once "./board_info.php";


// ----------------------------------------------------------------------------------------------------
// ## 공통변수 및 사용자정의변수 정의
// ----------------------------------------------------------------------------------------------------


// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------

$search_division				= $BOARD_DIVISION;
$search_language_type	= $mod->trans3($_REQUEST, "search_language_type", "KOR");
$var_level						= $mod->trans3($_REQUEST, "level", "");
$var_Num						= $mod->trans3($_REQUEST, "num", "");
$var_Parent					= $mod->trans3($_REQUEST, "parent", "");


// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------


// ----------------------------------------------------------------------------------------------------
// ## 페이지 이동 파라미터
// ----------------------------------------------------------------------------------------------------


// ####################################################################################################
// ## 게시판 정보
// ####################################################################################################


$var_level += 1;

if ($var_Num != "") {
	$var_SQL = " SELECT ";
	$var_SQL .= " _ID AS CATEGORY_SEQ, PARENT_CATEGORY_SEQ ";
	$var_SQL .= " FROM ( ";
	$var_SQL .= " 		SELECT ";
	$var_SQL .= " 				 @R AS _ID ";
	$var_SQL .= " 				, ( SELECT @R := PARENT_CATEGORY_SEQ FROM ".$BOARD_TABLENAME."_CATEGORY WHERE CATEGORY_SEQ = _ID) AS PARENT_CATEGORY_SEQ ";
	$var_SQL .= " 				, @L := @L + 1 AS LEVEL ";
	$var_SQL .= " 		FROM ( SELECT @R := $var_Num, @L := 0 ) VARS, ".$BOARD_TABLENAME."_CATEGORY H ";
	$var_SQL .= " 		WHERE @R IS NOT NULL ";
	$var_SQL .= " 		AND H.DEL_YN = 'N' AND H.DIVISION = ? AND H.LANGUAGE_TYPE = ?  ";
	$var_SQL .= " 		ORDER BY LEVEL DESC ";
	$var_SQL .= " 		) QI; ";

	$stmt = $pdo->prepare($var_SQL);
	$param[] = $search_division;
	$param[] = $search_language_type;
	$arrayStart = 1;
	for ($i = 0; $i < count($param); $i++) {
		$stmt->bindParam($arrayStart, $param[$i]);
		$arrayStart++;
	}
	$stmt->execute();
//	echo $mod->sql_debug($var_SQL, $param);
	$total_count = $stmt->rowCount();

	$checker = "";
	if ($total_count > 0) {
		for ($i = 0; $i < $total_count; $i++) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$checker .= trim($row["CATEGORY_SEQ"])."/";
		}
	}
	if ($checker != "") $checker = "/".$checker;
	$param = null;
}

if ($var_Parent != "") {
	$var_SQL = "SELECT ";
	$var_SQL .= "CATEGORY_SEQ, LEVEL, ORDER_NUM, SUBJECT, REG_DATE, PARENT_CATEGORY_SEQ";
	$var_SQL .= ", (SELECT COUNT(*) FROM ".$BOARD_TABLENAME."_CATEGORY B WHERE B.PARENT_CATEGORY_SEQ = A.CATEGORY_SEQ ) AS CHILD_COUNT";
	$var_SQL .= " FROM ".$BOARD_TABLENAME."_CATEGORY A";
	$var_SQL .= " WHERE DEL_YN='N' AND DIVISION=? AND LANGUAGE_TYPE=?";

	$param[] = $search_division;
	$param[] = $search_language_type;

	if ($var_Parent > 0) {
		$var_SQL .= " AND PARENT_CATEGORY_SEQ=?";
		$param[] = $var_Parent;
	} else {
		$var_SQL .= " AND PARENT_CATEGORY_SEQ IS NULL";
	}

	$var_SQL .= " ORDER BY ORDER_NUM, CATEGORY_SEQ";

	$stmt = $pdo->prepare($var_SQL);
	$arrayStart = 1;
	for ($i = 0; $i < count($param); $i++) {
		$stmt->bindParam($arrayStart, $param[$i]);
		$arrayStart++;
	}
	//echo $mod->sql_debug($var_SQL, $param);
	$stmt->execute();
	$total = $stmt->rowCount();
} else {
	$total = 0;
}

$result = "{".chr(10) . chr(13);
$result .= "\"list\": [ ".chr(10) . chr(13);
$k = 0;
$selected_idx = "";
$selected_name = "";

if ($total > 0) {
	for ($i = 0; $i < $total; $i++) {
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$col_category_seq					= trim($row["CATEGORY_SEQ"]);
		$col_category_level					= trim($row["LEVEL"]);
		$col_category_subject				= trim($row["SUBJECT"]);
		$col_category_reg_date			= trim($row["REG_DATE"]);
		$col_parent_category_seq		= trim($row["PARENT_CATEGORY_SEQ"]);
		$col_child_count						= trim($row["CHILD_COUNT"]);
		If ($col_child_count > 0) {
			$col_child_count = "1";
		}

		$searchPosition = strIpos($checker, "/".$col_category_seq."/");
		if ($searchPosition === false) {
			$searchPosition = -1;
		}

		if ($searchPosition > -1){
			$selected_idx = ($col_category_seq > 0) ? $col_category_seq : 0;
			$selected_name = $col_category_subject;
		}
		$result .= " {";
		$result .= "\"cate\": ".$col_category_seq.",";
		$result .= "\"name\": \"".str_replace('""', '\"',$col_category_subject)."\",";
		$result .= "\"child\": ".$col_child_count;
		$k = $k + 1;
		if ($total > $k) {
			$result .= " },".chr(10) . chr(13);
		} else {
			$result .= " }".chr(10) . chr(13);
		}
	}
}
$stmt->closeCursor();

$result .= "],".chr(10) . chr(13);
$result .= "\"depth\": ".$var_level.",".chr(10) . chr(13);
$result .= "\"selected\": {\"cate\": \"".$selected_idx."\",\"name\": \"".str_replace('""', '\"',$selected_name)."\"}".chr(10) . chr(13);
$result .= "}".chr(10) . chr(13);
echo $result;
?>