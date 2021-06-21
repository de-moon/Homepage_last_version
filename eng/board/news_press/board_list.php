<?php
include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/commonHeader.php";
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
$search_view_yn			= "Y";
$search_language_type	= $BOARD_LANGUAGE;
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
//if ($search_view_yn != "") $setParams[] = "search_view_yn=".$search_view_yn;
//if ($search_language_type != "") $setParams[] = "search_language_type=".$search_language_type;
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

if ($search_language_type != "") {
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


include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/header.php";
?>
<script type="text/javascript">
//<![CDATA[

function search_page() {
	var f = document.frm_search;

	f.action = "board_list.php";
	f.submit();
}

//]]>
</script>

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
							<div class="boardSearchWrap">
								<form name="frm_search" id="frm_search" method="get">
								<input type="hidden" name="page"			value="<?=$var_Page ?>" />
								<input type="hidden" name="num"			value="" />

									<div class="boardSearch">
										<select name="search_field">
											<option value="subject"		<?php if($search_field == "subject"){?>selected="selected"<?php }?>>title</option>
											<option value="content"		<?php if($search_field == "content"){?>selected="selected"<?php }?>>content</option>
										</select>
										<div class="inputSearch">
											<input type="text" name="search_keyword" value="<?=$search_keyword?>" maxlength="50" onKeyDown="return setFunction_Call( 'search_page()' );">
											<input type="submit" value="" >
										</div>
									</div>
								</form>
							</div>

							<div class="newsList">
								<ul>
								<?php
									if ($BOARD_NOTICE) {
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
											}
										}
									}
									If($cnt > 0){
										for ($i = 0; $i < $cnt; $i++) {
											$row = $result->fetch(PDO::FETCH_ASSOC);
											$print_num = $num--;
									?>
									<li>
										<div class="list_item">
											<strong class="subject"><a href="board_view.php?<?=$setParams ?>&page=<?=$var_Page ?>&num=<?=$row['BOARD_SEQ']?>"><?=$row['SUBJECT'] ?></a></strong>
											<div class="content">
												<?=$row['CONTENT']?>
											</div>
											<!-- 출력값 > July 17, 2020 -->
											<div class="date"><?=date("M,d,Y", strtotime($row['REG_DATE'])) ?></div>
											<em><a href="<?=$row['ETC_1']?>" target="_blank"><img src="<?=$IMAGES_PATH ?>/contents/btn_news_arr.png" alt=""></a></em>
										</div>
									</li>
									<?php
										}
									} else {
									?>
									<li>
										<a href="#none" class="list_item">
											<p><?=$DB_005 ?></p>
										</a>
									</li>
									<?php
									}
									?>
								</ul>
							</div>
							<div class="pager_wrap">
								<div class="pager">
									<?=$mod -> paging_front($var_Page, $tt_page, $setParams); ?>
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

	</script>
</body>
</html>