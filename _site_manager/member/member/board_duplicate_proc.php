<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/commonHeader.php";
include_once "./board_info.php";

try {

// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------

	$in_user_id						= $mod->trans3($_POST, "user_id", "");


// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------

	if ($in_user_id == "") $mod->java("{$PARAMETER_002}");


// ####################################################################################################
// ## 아이디 확인
// ####################################################################################################

	$query = "SELECT COUNT(*) CNT FROM ".$BOARD_TABLENAME." WHERE USER_ID=:id";
	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":id", $in_user_id);
	$stmt->execute();
	$stmt->bindColumn(1, $cnt);
	$stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();

	if ($cnt > 0) {
		$mod->javaAlerFunction($MEMBER_001,"parent.check_duplicate_false()");
	} else {
		$mod->javaAlerFunction($MEMBER_005,"parent.check_duplicate_true()");
	}
} catch(Exception $e) {
	echo $e->getMessage();
	exit;
}
?>