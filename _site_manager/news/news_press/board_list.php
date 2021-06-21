<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/commonHeader.php";
include_once "./board_info.php";


// ----------------------------------------------------------------------------------------------------
// ## 공통변수 및 사용자정의변수 정의
// ----------------------------------------------------------------------------------------------------

$setParams		= array();
$param				= array();


// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------

$var_Page						= $mod->trans3($_REQUEST, "page", "1");
$search_division				= $BOARD_DIVISION;
$search_field					= $mod->trans3($_REQUEST, "search_field", "subject");
$search_keyword			= $mod->trans3($_REQUEST, "search_keyword", "");
$search_category			= $mod->trans3($_REQUEST, "search_category", "");
$search_view_yn			= $mod->trans3($_REQUEST, "search_view_yn", "");
$search_language_type	= $mod->trans3($_REQUEST, "search_language_type", "all");
$search_pagesize			= $mod->trans3($_REQUEST, "search_pagesize", $BOARD_PAGESIZE);
$search_order_target		= $mod->trans3($_REQUEST, "search_order_target", "BOARD_SEQ");
$search_order_action		= $mod->trans3($_REQUEST, "search_order_action", "");


// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------



// ----------------------------------------------------------------------------------------------------
// ## 페이지 이동 파라미터
// ----------------------------------------------------------------------------------------------------

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

// 게시판 기본 변수
$pagesize			= $search_pagesize;
$start_number		= ($var_Page - 1) * $pagesize;
$var_AddSQL		= "";

// 검색조건
$var_AddSQL		= " WHERE A.DEL_YN= 'N' AND A.DIVISION = '$search_division' ";

if ($BOARD_NOTICE) {
	$var_AddSQL .= " AND A.NOTICE_YN= 'N' ";
}

if ($search_keyword != "" && $search_field != "" ) {
	if ($search_field == "subject") {
		$var_AddSQL .= " AND A.SUBJECT LIKE CONCAT('%',:keyword,'%')";
		$param[] = array(":keyword" => $search_keyword);
	} else if ($search_field == "content") {
		$var_AddSQL .= " AND A.CONTENT LIKE CONCAT('%',:keyword,'%')";
		$param[] = array(":keyword" => $search_keyword);
	} else if ($search_field == "complex") {
		$var_AddSQL .= " AND (A.SUBJECT LIKE CONCAT('%',:keyword,'%') OR A.CONTENT LIKE CONCAT('%',:keyword,'%'))";
		$param[] = array(":keyword" => $search_keyword);
	}
}

if ($search_category != "") {
	$var_AddSQL .= " AND A.CATEGORY = :search_category ";
	$param[] = array(":search_category" => $search_category);
}

if ($search_view_yn != "") {
	$var_AddSQL .= " AND A.VIEW_YN = :search_view_yn ";
	$param[] = array(":search_view_yn" => $search_view_yn);
}

if ($search_language_type != "" && $search_language_type!="all") {
	$var_AddSQL .= " AND A.LANGUAGE_TYPE = :search_language_type ";
	$param[] = array(":search_language_type" => $search_language_type);
}

// 정렬 설정
$order_SQL	= "A.BOARD_SEQ DESC";

if($search_order_target && $search_order_action) {
	if($search_order_target == "BOARD_SEQ") {
		$order_SQL = "A.BOARD_SEQ DESC";
	} else{
		$order_SQL = "A.{$search_order_target} {$search_order_action}, A.BOARD_SEQ DESC";
	}
}

// 총 레코드 수 / 현재 글번호
$cntq = "SELECT COUNT(*) cnt FROM ".$BOARD_TABLENAME . " A {$var_AddSQL} ";
$stmt = $mod->select($pdo, $cntq, $param);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_record = $row["cnt"];
$stmt->closeCursor();
$num = $total_record - ($pagesize * ($var_Page -1));

// 게시물
$var_SQL = " SELECT ";
$var_SQL .= "   A.BOARD_SEQ, A.DIVISION, A.CATEGORY, A.SUBJECT, A.CONTENT ";
$var_SQL .= " , A.HIT, A.NOTICE_YN, A.VIEW_YN, A.USER_NAME, A.PASSWORD ";
$var_SQL .= " , A.REGISTER_IP, A.DEL_YN, A.LANGUAGE_TYPE, A.REG_DATE ";
$var_SQL .= " , A.ETC_1, A.ETC_2, A.ETC_3, A.ETC_4, A.ETC_5 ";
$var_SQL .= " , A.ETC_6, A.ETC_7, A.ETC_8, A.ETC_9, A.ETC_10 ";
$var_SQL .= " , ( SELECT COUNT(FILE_SEQ) FROM ".$BOARD_TABLENAME."_FILE B WHERE A.BOARD_SEQ = B.BOARD_SEQ) AS FILE_COUNT ";
$var_SQL .= " FROM ".$BOARD_TABLENAME." A ";
$var_SQL .= $var_AddSQL;
$var_SQL .= " ORDER BY ".$order_SQL ." LIMIT ".$start_number.",".$pagesize;
$result = $mod->select($pdo, $var_SQL, $param);
$cnt = $result->rowCount();

// 총 페이지 수
if ($total_record % $pagesize != 0) $tt_page = intval($total_record / $pagesize) + 1;
else $tt_page = intval($total_record / $pagesize);

// 디버그
//$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$mod->sql_debug($var_SQL, $param);


include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/header.php";
?>
<script type="text/javascript">
//<![CDATA[

function check_delete() {
	var f = document.frm_delete;

	if (0>=getChecked_Count(  f.del_num )) {
		alert("삭제할 게시물을 선택해 주세요.");
		return;
	} else {
		if(!confirm("정말 삭제 하시겠습니까?")) return;

		f.num.value = getChecked_Value( f.del_num );
		f.action = "board_proc.php";
		f.target="frm_hiddenFrame";
		f.submit();
	}
}

function search_page() {
	var f = document.frm_search;

	f.action = "board_list.php";
	f.submit();
}

function order_change(target, action) {
	var f = document.frm_search;
	
	if(target == undefined || target == "") {
		alert("사용할 수 없는 기능입니다.");
	} else {
		f.search_order_target.value = target;
		f.search_order_action.value = action;
		f.action = "board_list.php";
		f.submit();
	}
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

		<form name="frm_search" id="frm_search" method="get">
		<input type="hidden" name="page"							value="<?=$var_Page ?>" />
		<input type="hidden" name="num"								value="" />
		<input type="hidden" name="search_order_target"		value="<?=$search_order_target?>">
		<input type="hidden" name="search_order_action"		value="<?=$search_order_action?>">

		<div class="search_type01">

			<div class="col line">
				<div class="select_set" <?php if ( sizeof($BOARD_LANGUAGE) == 1 ) echo "style='display:none;'"; ?>>
					<strong>언어</strong>
					<select title="언어" name="search_language_type" onchange="search_page();">
					<option value="all">전체</option>
					<?php foreach($BOARD_LANGUAGE as $key => $value): ?>
					<option value="<?=$key ?>" <?php if($search_language_type==$key) echo "selected";?>><?=$value ?></option>
					<?php endforeach ?>
					</select>
				</div>
				<div class="select_set" <?php if ( sizeof($BOARD_CATEGORY) < 1 ) echo "style='display:none;'"; ?>>
					<strong>분류</strong>
					<select title="분류" name="search_category" onchange="search_page();">
					<option value="">전체</option>
					<?php foreach($BOARD_CATEGORY as $key => $value): ?>
					<option value="<?=$key ?>" <?php if($search_category==$key) echo "selected";?>><?=$value ?></option>
					<?php endforeach ?>
					</select>
				</div>
				<div class="select_set" <?php if (!$BOARD_VIEW) { ?>style="display:none;"<?php } ?>>
					<strong>노출 여부</strong>
					<select title="노출 여부" name="search_view_yn" onchange="search_page()">
						<option value="">전체</option>
						<option value="Y" <?php if($search_view_yn == "Y"){?>selected='selected'<?php }?>>노출</option>
						<option value="N" <?php if($search_view_yn == "N"){?>selected='selected'<?php }?>>노출 안함</option>
					</select>
				</div>
				<!--div class="select_set">
					<strong>리스트 표시수</strong>
					<select title="리스트 표시수" name="search_pagesize" onchange="search_page()">
						<option value="10"	<?php if ($search_pagesize == "10") { ?>selected<?php } ?>>10</option>
						<option value="30"	<?php if ($search_pagesize == "30") { ?>selected<?php } ?>>30</option>
						<option value="50"	<?php if ($search_pagesize == "50") { ?>selected<?php } ?>>50</option>
						<option value="100"	<?php if ($search_pagesize == "100") { ?>selected<?php } ?>>100</option>
					</select>
				</div-->
			</div>

			<div class="col">
				<div class="select_set">
					<strong>키워드</strong>
					<select title="검색키워드" name="search_field">
						<option value="subject"		<?php if($search_field == "subject"){?>selected="selected"<?php }?>>제목</option>
						<option value="content"		<?php if($search_field == "content"){?>selected="selected"<?php }?>>내용</option>
						<option value="complex"		<?php if($search_field == "complex"){?>selected<?php }?>>제목+내용</option>
					</select>
					<input type="text" title="검색어 입력창" name="search_keyword" value="<?=$search_keyword?>" placeholder="검색어를 입력해주세요." maxlength="50" onKeyDown="return setFunction_Call( 'search_page()' );"/>
				</div>
			</div>

			<input type="submit" value="검색" class="button white btn_search" />

			<?php if ( $setParams != "" ) { ?>
			<div class="col">
				<a href="board_list.php" class="button btn_search03">검색 초기화</a>
			</div>
			<?php } ?>
		</div>
		</form>
		<!-- //search_type01 -->

		<form name="frm_delete" id="frm_delete" method="post">
		<input type="hidden" name="mode" id="mode"			value="DEL" />
		<input type="hidden" name="page"							value="<?=$var_Page ?>">
		<input type="hidden" name="search_field"					value="<?=$search_field ?>">
		<input type="hidden" name="search_keyword"			value="<?=$search_keyword ?>">
		<input type="hidden" name="search_category"			value="<?=$search_category ?>">
		<input type="hidden" name="search_view_yn"			value="<?=$search_view_yn ?>">
		<input type="hidden" name="search_language_type"	value="<?=$search_language_type ?>">
		<input type="hidden" name="search_pagesize"			value="<?=$search_pagesize ?>">
		<input type="hidden" name="search_order_target"		value="<?=$search_order_target?>">
		<input type="hidden" name="search_order_action"		value="<?=$search_order_action?>">
		<input type="hidden" name="num"								value="" />

		<!-- 리스트 테이블 타입01 -->
		<div class="table_list_type01">

			<div class="table_top">
				<div class="left">
					<input type="button" value="삭제" class="button rosy" onclick="check_delete();" />
				</div>
				<div class="right">
					<a href="board_write.php?<?=$setParams ?>&page=<?=$var_Page ?>" class="button white">등록</a>
				</div>
			</div>

			<table>
				<colgroup>
					<col width="15px" />
					<col width="78px" />
					<?php if ( sizeof($BOARD_CATEGORY) > 0 ) echo "<col width='150px' />"; ?>
					<?php if ( sizeof($BOARD_LANGUAGE) > 0 ) echo "<col width='80px' />"; ?>
					<col width="" />
					<col width="100px" />
					<col width="120px" />
					<col width="120px" />
				</colgroup>
				<thead>
					<tr>
						<th><input type="checkbox" id="checkAll" onClick="setChecked_Reverse('del_num');" /></th>
						<th>번호</th>
						<?php if ( sizeof($BOARD_CATEGORY) > 0 ) { ?>
						<th>
							분류
							<a href="#none" onclick="order_change('CATEGORY', 'DESC');" <?php if($search_order_target == "CATEGORY" && $search_order_action == "DESC") {?>class="order_select"<?php } else { ?>class="order_none"<?php } ?>>▲</a>
							<a href="#none" onclick="order_change('CATEGORY', 'ASC');" <?php if($search_order_target == "CATEGORY" && $search_order_action == "ASC") {?>class="order_select"<?php } else { ?>class="order_none"<?php } ?>>▼</a>
						</th>
						<?php } ?>
						<?php if ( sizeof($BOARD_LANGUAGE) > 0 ) { ?>
						<th>
							언어
							<a href="#none" onclick="order_change('LANGUAGE_TYPE', 'DESC');" <?php if($search_order_target == "LANGUAGE_TYPE" && $search_order_action == "DESC") {?>class="order_select"<?php } else { ?>class="order_none"<?php } ?>>▲</a>
							<a href="#none" onclick="order_change('LANGUAGE_TYPE', 'ASC');" <?php if($search_order_target == "LANGUAGE_TYPE" && $search_order_action == "ASC") {?>class="order_select"<?php } else { ?>class="order_none"<?php } ?>>▼</a>
						</th>
						<?php } ?>
						<th>
							제목
							<a href="#none" onclick="order_change('SUBJECT', 'DESC');" <?php if($search_order_target == "SUBJECT" && $search_order_action == "DESC") {?>class="order_select"<?php } else { ?>class="order_none"<?php } ?>>▲</a>
							<a href="#none" onclick="order_change('SUBJECT', 'ASC');" <?php if($search_order_target == "SUBJECT" && $search_order_action == "ASC") {?>class="order_select"<?php } else { ?>class="order_none"<?php } ?>>▼</a>
						</th>
						<th>
							등록일
							<a href="#none" onclick="order_change('REG_DATE', 'DESC');" <?php if($search_order_target == "REG_DATE" && $search_order_action == "DESC") {?>class="order_select"<?php } else { ?>class="order_none"<?php } ?>>▲</a>
							<a href="#none" onclick="order_change('REG_DATE', 'ASC');" <?php if($search_order_target == "REG_DATE" && $search_order_action == "ASC") {?>class="order_select"<?php } else { ?>class="order_none"<?php } ?>>▼</a>
						</th>
						<!--th>
							조회수
							<a href="#none" onclick="order_change('HIT', 'DESC');" <?php if($search_order_target == "HIT" && $search_order_action == "DESC") {?>class="order_select"<?php } else { ?>class="order_none"<?php } ?>>▲</a>
							<a href="#none" onclick="order_change('HIT', 'ASC');" <?php if($search_order_target == "HIT" && $search_order_action == "ASC") {?>class="order_select"<?php } else { ?>class="order_none"<?php } ?>>▼</a>
						</th-->
						<th>
							노출 여부
							<a href="#none" onclick="order_change('VIEW_YN', 'DESC');" <?php if($search_order_target == "VIEW_YN" && $search_order_action == "DESC") {?>class="order_select"<?php } else { ?>class="order_none"<?php } ?>>▲</a>
							<a href="#none" onclick="order_change('VIEW_YN', 'ASC');" <?php if($search_order_target == "VIEW_YN" && $search_order_action == "ASC") {?>class="order_select"<?php } else { ?>class="order_none"<?php } ?>>▼</a>
						</th>
					</tr>
				</thead>
				<tbody>
				<?php if ($BOARD_NOTICE) { ?>
				<?php
					$var_SQL = " SELECT ";
					$var_SQL .= "   A.BOARD_SEQ, A.DIVISION, A.CATEGORY, A.SUBJECT, A.CONTENT ";
					$var_SQL .= " , A.HIT, A.NOTICE_YN, A.VIEW_YN, A.USER_NAME, A.PASSWORD ";
					$var_SQL .= " , A.REGISTER_IP, A.DEL_YN, A.LANGUAGE_TYPE, A.REG_DATE ";
					$var_SQL .= " , A.ETC_1, A.ETC_2, A.ETC_3, A.ETC_4, A.ETC_5 ";
					$var_SQL .= " , A.ETC_6, A.ETC_7, A.ETC_8, A.ETC_9, A.ETC_10 ";
					$var_SQL .= " , ( SELECT COUNT(FILE_SEQ) FROM ".$BOARD_TABLENAME."_FILE B WHERE A.BOARD_SEQ = B.BOARD_SEQ) AS FILE_COUNT ";
					$var_SQL .= " FROM ".$BOARD_TABLENAME." A ";
					$var_SQL .= " WHERE A.DEL_YN= 'N' AND A.NOTICE_YN= 'Y' AND A.DIVISION = '$search_division' AND A.LANGUAGE_TYPE = '$search_language_type' ";
					$var_SQL .= " ORDER BY BOARD_SEQ DESC ";

					$stmt = $pdo->prepare($var_SQL);
					$stmt->execute();
					$total_count = $stmt->rowCount();

					if ($total_count > 0) {
						for ($i = 0; $i < $total_count; $i++) {
							$row = $stmt->fetch(PDO::FETCH_ASSOC);
				?>
				<tr>
					<td><input type="checkbox" name="del_num" value="<?=$row['BOARD_SEQ'] ?>" /></td>
					<td>공지</td>
					<?php if ( sizeof($BOARD_CATEGORY) > 0 ) echo "<td>".(($row['CATEGORY'] != "") ? $BOARD_CATEGORY[$row['CATEGORY']] : "")."</td>"; ?>
					<?php if ( sizeof($BOARD_LANGUAGE) > 0 ) echo "<td>".(($row['BOARD_LANGUAGE'] != "") ? $BOARD_LANGUAGE[$row['BOARD_LANGUAGE']] : "")."</td>"; ?>
					<td class="tal"><a href="board_view.php?<?=$setParams ?>&page=<?=$var_Page ?>&num=<?=$row['BOARD_SEQ']?>"><strong><?=$row['SUBJECT'] ?></strong></a></td>
					<td><?=date("Y-m-d", strtotime($row['REG_DATE'])) ?></td>
					<!--td><?=number_format($row['HIT']) ?></td-->
					<td><?=$row['VIEW_YN'] == "Y" ? "노출" : "노출안함" ?></td>
				</tr>
				<?php
						}
					}
				?>
				<?php } ?>
				<?php
					If($cnt > 0){
						for ($i = 0; $i < $cnt; $i++) {
							$row = $result->fetch(PDO::FETCH_ASSOC);
							$print_num = $num--;
				?>
				<tr>
					<td><input type="checkbox" name="del_num" value="<?=$row['BOARD_SEQ'] ?>" /></td>
					<td><?=$print_num ?><?=sizeof($BOARD_LANGUAGE)?></td>
					<?php if ( sizeof($BOARD_CATEGORY) > 0 ) echo "<td>".(($row['CATEGORY'] != "") ? $BOARD_CATEGORY[$row['CATEGORY']] : "")."</td>"; ?>
					<?php if ( sizeof($BOARD_LANGUAGE) > 0 ) echo "<td>".$row['LANGUAGE_TYPE']."</td>"; ?>
					<td class="tal"><a href="board_view.php?<?=$setParams ?>&page=<?=$var_Page ?>&num=<?=$row['BOARD_SEQ']?>"><strong><?=$row['SUBJECT'] ?></strong></a></td>
					<td><?=date("Y-m-d", strtotime($row['REG_DATE'])) ?></td>
					<!--td><?=number_format($row['HIT']) ?></td-->
					<td><?=$row['VIEW_YN'] == "Y" ? "노출" : "노출안함" ?></td>
				</tr>
				<?php
						}
					} else {
				?>
					<tr height="120">
						<td colspan="9">
							<?=$DB_005 ?>
						</td>
					</tr>
				<?php
					}
				?>
				</tbody>
			</table>

			<div class="table_bottom">
				<div class="left">
					<input type="button" value="삭제" class="button rosy" onclick="check_delete();" />
				</div>
				<div class="right">
					<a href="board_write.php?<?=$setParams ?>&page=<?=$var_Page ?>" class="button white">등록</a>
				</div>
				<div class="group_paging">
					<?=$mod -> paging($var_Page, $tt_page, $setParams); ?>
				</div>
			</div>

		</div>
		<!-- //table_list_type01 -->
		</form>

	</div>
	<!-- //content -->
</div>
<!-- //wrap -->

<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/footer.php";
?>

</body>
</html>