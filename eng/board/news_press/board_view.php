<?php
include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/commonHeader.php";
include_once "./board_info.php";


// ----------------------------------------------------------------------------------------------------
// ## 공통변수 및 사용자정의변수 정의
// ----------------------------------------------------------------------------------------------------

$setParams		= array();


// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------

$var_Page						= $mod->trans3($_REQUEST, "page", "");
$var_Num						= $mod->trans3($_REQUEST, "num", "");
$search_division				= $BOARD_DIVISION;
$search_field					= $mod->trans3($_REQUEST, "search_field", "subject");
$search_keyword			= $mod->trans3($_REQUEST, "search_keyword", "");
$search_category			= $mod->trans3($_REQUEST, "search_category", "");
$search_view_yn			= "Y";
$search_language_type	= $BOARD_LANGUAGE;
$search_pagesize			= $mod->trans3($_REQUEST, "search_pagesize", $BOARD_PAGESIZE);
$search_order_target		= $mod->trans3($_REQUEST, "search_order_target", "BOARD_SEQ");
$search_order_action		= $mod->trans3($_REQUEST, "search_order_action", "");


// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------

// if ($var_Num == "") $mod->java("{$PARAMETER_002}");


// ----------------------------------------------------------------------------------------------------
// ## 페이지 이동 파라미터
// ----------------------------------------------------------------------------------------------------

$setParams[] = "page=".$var_Page;
if ($search_field != "subject") $setParams[] = "search_field=".$search_field;
if ($search_keyword != "") $setParams[] = "search_keyword=".$search_keyword;
if ($search_category != "") $setParams[] = "search_category=".$search_category;
//if ($search_view_yn != "") $setParams[] = "search_view_yn=".$search_view_yn;
//if ($search_language_type != "") $setParams[] = "search_language_type=".$search_language_type;
if ($search_pagesize != $BOARD_PAGESIZE) $setParams[] = "search_pagesize=".$search_pagesize;
if ($search_order_target != "BOARD_SEQ") $setParams[] = "search_order_target=".$search_order_target;
if ($search_order_action != "") $setParams[] = "search_order_action=".$search_order_action;

$setParams = implode("&amp;",$setParams);


// ####################################################################################################
// ## 게시판 정보
// ####################################################################################################

$var_SQL = "SELECT  ";
$var_SQL .= "   A.BOARD_SEQ, A.DIVISION, A.CATEGORY, A.SUBJECT, A.CONTENT ";
$var_SQL .= " , A.HIT, A.NOTICE_YN, A.VIEW_YN, A.USER_NAME, A.PASSWORD ";
$var_SQL .= " , A.REGISTER_IP, A.DEL_YN, A.LANGUAGE_TYPE, A.REG_DATE ";
$var_SQL .= " , A.ETC_1, A.ETC_2, A.ETC_3, A.ETC_4, A.ETC_5 ";
$var_SQL .= " , A.ETC_6, A.ETC_7, A.ETC_8, A.ETC_9, A.ETC_10 ";
$var_SQL .= " FROM ".$BOARD_TABLENAME." A";
$var_SQL .= " WHERE A.DEL_YN = 'N' AND A.BOARD_SEQ = :no ";

$stmt = $pdo->prepare($var_SQL);
$stmt->bindParam(":no", $var_Num);
$stmt->execute();
$stmt->bindColumn(1, $col_board_seq);
$stmt->bindColumn(2, $col_division);
$stmt->bindColumn(3, $col_category);
$stmt->bindColumn(4, $col_subject);
$stmt->bindColumn(5, $col_content);
$stmt->bindColumn(6, $col_hit);
$stmt->bindColumn(7, $col_notice_yn);
$stmt->bindColumn(8, $col_view_yn);
$stmt->bindColumn(9, $col_user_name);
$stmt->bindColumn(10, $col_password);
$stmt->bindColumn(11, $col_register_ip);
$stmt->bindColumn(12, $col_del_yn);
$stmt->bindColumn(13, $col_language_type);
$stmt->bindColumn(14, $col_reg_date);
$stmt->bindColumn(15, $col_etc_1);
$stmt->bindColumn(16, $col_etc_2);
$stmt->bindColumn(17, $col_etc_3);
$stmt->bindColumn(18, $col_etc_4);
$stmt->bindColumn(19, $col_etc_5);
$stmt->bindColumn(20, $col_etc_6);
$stmt->bindColumn(21, $col_etc_7);
$stmt->bindColumn(22, $col_etc_8);
$stmt->bindColumn(23, $col_etc_9);
$stmt->bindColumn(24, $col_etc_10);
$stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();


// ####################################################################################################
// ## 게시판 정보 / 이전글, 이후글
// ####################################################################################################

if ($col_notice_yn != "Y") {

	// 검색 조건
	$var_AddSQL		= " WHERE A.DEL_YN= 'N' AND A.DIVISION = '$search_division' ";

	if ($BOARD_NOTICE) {
		$var_AddSQL .= " AND A.NOTICE_YN= 'N' ";
	}

	if ($search_keyword != "" && $search_field != "" ) {
		if ($search_field == "subject") {
			$var_AddSQL .= " AND A.SUBJECT LIKE CONCAT('%',?,'%')";
			$param[] = $search_keyword;
		} else if ($search_field == "content") {
			$var_AddSQL .= " AND A.CONTENT LIKE CONCAT('%',?,'%')";
			$param[] = $search_keyword;
		}
	}

	if ($search_category != "") {
		$var_AddSQL .= " AND A.CATEGORY = ? ";
		$param[] = $search_category;
	}

	if ($search_view_yn != "") {
		$var_AddSQL .= " AND A.VIEW_YN = ? ";
		$param[] = $search_view_yn;
	}

	if ($search_language_type != "") {
		$var_AddSQL .= " AND A.LANGUAGE_TYPE = ? ";
		$param[] = $search_language_type;
	}

	// 이전글
	$var_SQL = " SELECT ";
	$var_SQL .= "   A.BOARD_SEQ, A.SUBJECT ";
	$var_SQL .= " FROM ".$BOARD_TABLENAME." A ";
	$var_SQL .= $var_AddSQL;
	$var_SQL .= " AND A.BOARD_SEQ < $col_board_seq ";
	$var_SQL .= " ORDER BY A.BOARD_SEQ DESC LIMIT 1 ";

	$stmt = $pdo->prepare($var_SQL);
	$arrayStart = 1;
	for ($i = 0; $i < count($param); $i++) {
		$stmt->bindParam($arrayStart, $param[$i]);
		$arrayStart++;
	}

	$stmt->execute();
	$stmt->bindColumn(1, $col_prev_board_seq);
	$stmt->bindColumn(2, $col_prev_subject);
	$stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();

	// 이후글
	$var_SQL = " SELECT ";
	$var_SQL .= "   A.BOARD_SEQ, A.SUBJECT ";
	$var_SQL .= " FROM ".$BOARD_TABLENAME." A ";
	$var_SQL .= $var_AddSQL;
	$var_SQL .= " AND A.BOARD_SEQ > $col_board_seq ";
	$var_SQL .= " ORDER BY A.BOARD_SEQ LIMIT 1 ";

	$stmt = $pdo->prepare($var_SQL);
	$arrayStart = 1;
	for ($i = 0; $i < count($param); $i++) {
		$stmt->bindParam($arrayStart, $param[$i]);
		$arrayStart++;
	}

	$stmt->execute();
	$stmt->bindColumn(1, $col_next_board_seq);
	$stmt->bindColumn(2, $col_next_subject);
	$stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();

}





include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/header.php";
?>

</head>
<body>

<?php include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/skipNav.php"; ?>

	<!-- wrap -->
	<div id="wrap" class="sub">

		<?php include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/top.php"; ?>

		<!--container-->
		<div id="container">
			<?php include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/location.php"; ?>
			<div class="contents ty_products">
				<div class="inner">
					<div class="subContWrap">
						<div class="subContSec aniBox type_bot">
							<div class="boardViewWrap board">
								<div class="bvTop">
									<p class="bvTop_tit"><?=$col_subject ?></p>
									<div class="bvTop_info">
										<span class="date"><?=date("M,d,Y", strtotime($col_reg_date)) ?></span>
									</div>
								</div>
								<div class="bvCont txtBox" id="bo_v_atc">
									<?=$col_content ?>
								</div>

								<div class="bvFile" <?php if (!$BOARD_UPLOAD_ALL) { ?>style="display:none;"<?php } ?>>
									<ul class="bvFile_list">
										<?php
											$file_type = 'attach_all';

											$var_SQL = " SELECT ";
											$var_SQL .= " FILE_SEQ, FILE_PATH, FILE_NAME, FILE_SAVE, FILE_TYPE, FILE_SIZE, DOWN_COUNT, REG_DATE ";
											$var_SQL .= " FROM ". $BOARD_TABLENAME ."_FILE ";
											$var_SQL .= " WHERE FILE_TYPE='". $file_type ."' AND BOARD_SEQ = :no ";
											$var_SQL .= " ORDER BY FILE_SEQ ";

											$stmt = $pdo->prepare($var_SQL);
											$stmt->bindParam(":no", $var_Num);
											$stmt->execute();
											$total_count = $stmt->rowCount();

											if ($total_count > 0) {
												for ($i = 0; $i < $total_count; $i++) {
													$row							= $stmt->fetch(PDO::FETCH_OBJ);
													$col_file_seq				= trim($row->FILE_SEQ);
													$col_file_path				= trim($row->FILE_PATH);
													$col_file_name			= trim($row->FILE_NAME);
													$col_file_save				= trim($row->FILE_SAVE);
													$col_file_size				= trim($row->FILE_SIZE);
													$col_file_type				= trim($row->FILE_TYPE);
													$col_file_down_count	= trim($row->DOWN_COUNT);
													$col_file_reg_date		= trim($row->REG_DATE);
										?>
											<li class="file_item">
												<a href='/common/php/download.php?file=<?=$col_file_path ?>/<?=$col_file_save ?>&num=<?=$col_file_seq ?>' target='frm_hiddenFrame' title="파일 다운로드 하기"><em><?=$col_file_name ?></em></a>
											</li>
										<?php
												}
											} else {
										?>
										<?php
											}
										?>

									</ul>
								</div>

								<?php if ($col_notice_yn != "Y") { ?>
								<div class="bvNav">
									<ul>
										<li class="bvNav_prev">
											<?php If ($col_next_board_seq <> "") { ?>
											<span class="bvNav_arrow">이전글</span>
											<a href="board_view.php?<?=$setParams ?>&num=<?=$col_next_board_seq?>"><?=$col_next_subject ?></a>
											<?php } else { ?>
											<span class="bvNav_arrow">이전글</span>
											<a href="#">윗글이 없습니다.</a>
											<?php } ?>
										</li>
										<li class="bvNav_next">
											<?php If ($col_prev_board_seq <> "") { ?>
											<span class="bvNav_arrow">다음글</span>
											<a href="board_view.php?<?=$setParams ?>&num=<?=$col_prev_board_seq?>"><?=$col_prev_subject ?></a>
											<?php } else { ?>
											<span class="bvNav_arrow">다음글</span>
											<a href="#">아랫글이 없습니다.</a>
											<?php } ?>
										</li>
									</ul>
								</div>
								<?php } ?>
								<div class="btn_box taC">
									<a href="board_list.php?<?=$setParams ?>" class="btn_round " onclick="">LIST</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--//container-->

		<?php include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/footer.php"; ?>

	</div>
	<!-- //wrap -->
	<script>
		jQuery("#bo_v_atc a").each(function ()
		{ 
		console.log(jQuery(this).attr("target"));
		if (jQuery(this).attr("target") == "_self")
		return;
		else if (jQuery(this).attr("target") !== "_self")
		{jQuery(this).attr("target", "_blank");} 
		});

	</script>
</body>
</html>