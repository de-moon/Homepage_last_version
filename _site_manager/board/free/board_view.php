<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/commonHeader.php";
include_once "./board_info.php";


// ----------------------------------------------------------------------------------------------------
// ## 공통변수 및 사용자정의변수 정의
// ----------------------------------------------------------------------------------------------------

$setParams		= array();


// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------

$var_Page						= $mod->trans3($_REQUEST, "page", "1");
$var_Num						= $mod->trans3($_REQUEST, "num", "");
$search_division				= $BOARD_DIVISION;
$search_field					= $mod->trans3($_REQUEST, "search_field", "subject");
$search_keyword			= $mod->trans3($_REQUEST, "search_keyword", "");
$search_category			= $mod->trans3($_REQUEST, "search_category", "");
$search_view_yn			= $mod->trans3($_REQUEST, "search_view_yn", "");
$search_language_type	= $mod->trans3($_REQUEST, "search_language_type", "KOR");
$search_pagesize			= $mod->trans3($_REQUEST, "search_pagesize", $BOARD_PAGESIZE);
$search_order_target		= $mod->trans3($_REQUEST, "search_order_target", "BOARD_SEQ");
$search_order_action		= $mod->trans3($_REQUEST, "search_order_action", "");


// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------

if ($var_Num == "") $mod->java("{$PARAMETER_002}");


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





include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/header.php";
?>
<script type="text/javascript">
//<![CDATA[

function check_delete() {
	if(!confirm("정말 삭제 하시겠습니까?")) return;

	var f = document.frm_search;
	f.mode.value = "DEL"
	f.method = "post";
	f.action = "board_proc.php";
	f.target="frm_hiddenFrame";
	f.submit();
}

//]]>
</script>
</head>
<body>

<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/top.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/left.php";
?>
<div id="wrap">
	<div id="content">

		<h3><div><?=$MENU_BOARD?></div></h3>

		<div class="table_view_type01">

			<form name="frm_search" id="frm_search" method="get">
			<input type="hidden" name="mode"							value="">
			<input type="hidden" name="page"							value="<?=$var_Page ?>" />
			<input type="hidden" name="search_field"					value="<?=$search_field ?>">
			<input type="hidden" name="search_keyword"			value="<?=$search_keyword ?>">
			<input type="hidden" name="search_category"			value="<?=$search_category ?>">
			<input type="hidden" name="search_view_yn"			value="<?=$search_view_yn ?>">
			<input type="hidden" name="search_language_type"	value="<?=$search_language_type ?>">
			<input type="hidden" name="num"								value="<?=$var_Num ?>" />
			</form>

			<table>
				<colgroup>
					<col width="110px" />
					<col width="*" />
				</colgroup>
				<tr <?php if ( sizeof($BOARD_LANGUAGE) == 1 ) echo "style='display:none;'"; ?>>
					<th class="tl_round">언어</th>
					<td class="tr_round tal"><?=$col_language_type ?></td>
				</tr>
				<tr <?php if (!$BOARD_NOTICE) { ?>style="display:none;"<?php } ?>>
					<th class="">공지 여부</th>
					<td class=" tal"><?=$col_notice_yn == "Y" ? "공지" : "일반" ?></td>
				</tr>
				<tr <?php if (!$BOARD_VIEW) { ?>style="display:none;"<?php } ?>">
					<th>노출 여부</th>
					<td class="tal"><?=$col_view_yn == "Y" ? "노출 됨" : "노출 안됨" ?></td>
				</tr>
				<tr <?php if ( sizeof($BOARD_CATEGORY) < 1 ) echo "style='display:none;'"; ?>>
					<th>분류</th>
					<td class="tal"><?=($col_category != "") ? $BOARD_CATEGORY[$col_category] : "" ?></td>
				</tr>
				<tr>
					<th>제목</th>
					<td class="tal"><?=$col_subject ?></td>
				</tr>
				<tr <?php if (!$BOARD_CONTENT) { ?>style="display:none;"<?php } ?>>
					<th>내용</th>
					<td class="tal">
						<?//=nl2br($col_content) ?>
						<?=$col_content ?>
					</td>
				</tr>
				<tr <?php if (!$BOARD_UPLOAD_ONE) { ?>style="display:none;"<?php } ?>>
					<th>대표 이미지</th>
					<td class="tal">
						<?php
							$file_type = 'attach_one';

							$var_SQL = " SELECT ";
							$var_SQL .= " FILE_SEQ, FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, DOWN_COUNT, REG_DATE ";
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
							<img src='<?=$UPLOAD_PATH . $col_file_path . "/" . $col_file_save ?>' border='0' style='max-width:150px;'><br>
							<a href='/common/php/download.php?file=<?=$col_file_path ?>/<?=$col_file_save ?>&num=<?=$col_file_seq ?>' target='frm_hiddenFrame' title="파일 다운로드 하기"><?=$col_file_name ?>&nbsp;(<?=$mod->byteConvert($col_file_size) ?>)</a><br/><br/>
						<?php
								}
							} else {
						?>
						등록된 파일이 없습니다.
						<?php
							}
						?>
					</td>
				</tr>
				<tr <?php if (!$BOARD_UPLOAD_IMAGES) { ?>style="display:none;"<?php } ?>>
					<th>첨부 이미지</th>
					<td class="tal" colspan="5">
						<?php
							$file_type = 'attach_images';

							$var_SQL = " SELECT ";
							$var_SQL .= " FILE_SEQ, FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, DOWN_COUNT, REG_DATE ";
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
							<img src='<?=$UPLOAD_PATH . $col_file_path . "/" . $col_file_save ?>' border='0' style='max-width:150px;'><br>
							<a href='/common/php/download.php?file=<?=$col_file_path ?>/<?=$col_file_save ?>&num=<?=$col_file_seq ?>' target='frm_hiddenFrame' title="파일 다운로드 하기"><?=$col_file_name ?>&nbsp;(<?=$mod->byteConvert($col_file_size) ?>)</a><br/><br/>
						<?php
								}
							} else {
						?>
						등록된 파일이 없습니다.
						<?php
							}
						?>
					</td>
				</tr>
				<tr <?php if (!$BOARD_UPLOAD_ALL) { ?>style="display:none;"<?php } ?>>
					<th>첨부 파일</th>
					<td class="tal" colspan="5">
						<?php
							$file_type = 'attach_all';

							$var_SQL = " SELECT ";
							$var_SQL .= " FILE_SEQ, FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, DOWN_COUNT, REG_DATE ";
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
							<a href='/common/php/download.php?file=<?=$col_file_path ?>/<?=$col_file_save ?>&num=<?=$col_file_seq ?>' target='frm_hiddenFrame' title="파일 다운로드 하기"><?=$col_file_name ?>&nbsp;(<?=$mod->byteConvert($col_file_size) ?>)</a><br/><br/>
						<?php
								}
							} else {
						?>
						등록된 파일이 없습니다.
						<?php
							}
						?>
					</td>
				</tr>
				<tr>
					<th>조회수</th>
					<td class="tal"><?=number_format($col_hit) ?></td>
				</tr>
				<tr>
					<th>등록일</th>
					<td class="tal"><?=date("Y-m-d", strtotime($col_reg_date)) ?></td>
				</tr>
				<tr style="display:none;">
					<th>이름</th>
					<td class="tal"><?=$col_user_name ?></td>
				</tr>
				<tr style="display:none;">
					<th>비밀번호</th>
					<td class="tal"><?=$col_password ?></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_1) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><?=$col_etc_1 ?></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_2) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><?=$col_etc_2 ?></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_3) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><?=$col_etc_3 ?></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_4) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><?=$col_etc_4 ?></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_5) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><?=$col_etc_5 ?></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_6) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><?=$col_etc_6 ?></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_7) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><?=$col_etc_7 ?></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_8) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><?=$col_etc_8 ?></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_9) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><?=$col_etc_9 ?></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_10) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><?=$col_etc_10 ?></td>
				</tr>
			</table>

			<div class="table_bottom">
				<div class="left">
					<a href="board_list.php?<?=$setParams ?>" class="button white">목록</a>
				</div>
				<div class="right">
					<input type="button" value="삭제" class="button rosy" onclick="check_delete();" />
					<a href="board_write.php?<?=$setParams ?>&mode=EDT&num=<?=$var_Num?>" class="button white">수정</a>
				</div>
			</div>

		</div>

		<?php if ($col_notice_yn != "Y") { ?>
		<div class="table_view_type01">
			<table>
				<colgroup>
					<col width="7%" />
					<col width="" />
				</colgroup>
				<tr>
				<?php If ($col_next_board_seq <> "") { ?>
					<th class="tl_round"><a href="board_view.php?<?=$setParams ?>&num=<?=$col_next_board_seq?>">▲ 윗글</a></th>
					<td class="tr_round tal"><a href="board_view.php?<?=$setParams ?>&num=<?=$col_next_board_seq?>"><?=$col_next_subject ?></a></td>
				<?php } else { ?>
					<th class="tl_round">▲ 윗글</th>
					<td class="tr_round tal">윗글이 없습니다.</td>
				<?php } ?>
				</tr>
				<tr>
				<?php If ($col_prev_board_seq <> "") { ?>
					<th class=""><a href="board_view.php?<?=$setParams ?>&num=<?=$col_prev_board_seq?>">▼ 아랫글</a></th>
					<td class=" tal"><a href="board_view.php?<?=$setParams ?>&num=<?=$col_prev_board_seq?>"><?=$col_prev_subject ?></a></td>
				<?php } else { ?>
					<th class="">▼ 아랫글</th>
					<td class=" tal">아랫글이 없습니다.</td>
				<?php } ?>
				</tr>
			</table>
		</div>
		<?php } ?>

		<?php if ($BOARD_REPLY) { ?>
		<div>
			<div class="table_top">
				<div class="left">
					덧글
				</div>
			</div>
			<iframe name="replyList" id="replyList" src="board_reply_list.php?num=<?=$var_Num ?>" width="100%" height="100"
			marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no" ></iframe>
		</div>
		<?php } ?>

	</div>
	<!-- //content -->
</div>
<!-- //wrap -->

<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/footer.php";
?>

</body>
</html>