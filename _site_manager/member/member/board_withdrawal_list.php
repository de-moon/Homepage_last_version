<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/commonHeader.php";
include_once "./board_info.php";


// ----------------------------------------------------------------------------------------------------
// ## 공통변수 및 사용자정의변수 정의
// ----------------------------------------------------------------------------------------------------

$setParams		= array();
$param				= array();
$BOARD_MENU		= "탈퇴 회원";
$MENU_DEPTH_2	= "WITHDRAWAL";


// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------

$var_Page									= $mod->trans3($_REQUEST, "page", "1");
$search_field								= $mod->trans3($_REQUEST, "search_field", "user_id");
$search_keyword						= $mod->trans3($_REQUEST, "search_keyword", "");
$search_user_division					= $mod->trans3($_REQUEST, "search_user_division", "1");
$search_pagesize						= $mod->trans3($_REQUEST, "search_pagesize", $BOARD_PAGESIZE);
$search_order_target					= $mod->trans3($_REQUEST, "search_order_target", "USER_SEQ");
$search_order_action					= $mod->trans3($_REQUEST, "search_order_action", "");

// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------



// ----------------------------------------------------------------------------------------------------
// ## 페이지 이동 파라미터
// ----------------------------------------------------------------------------------------------------

if ($search_field != "user_id") $setParams[] = "search_field=".$search_field;
if ($search_keyword != "") $setParams[] = "search_keyword=".$search_keyword;
if ($search_user_division != "1") $setParams[] = "search_user_division=".$search_user_division;
if ($search_pagesize != $BOARD_PAGESIZE) $setParams[] = "search_pagesize=".$search_pagesize;
if ($search_order_target != "USER_SEQ") $setParams[] = "search_order_target=".$search_order_target;
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
$var_AddSQL		= " WHERE A.USER_STATE = 9 ";

if ($search_keyword != "" && $search_field != "" ) {
	if ($search_field == "user_id") {
		$var_AddSQL .= " AND A.USER_ID LIKE CONCAT('%',:keyword,'%')";
		$param[] = array(":keyword" => $search_keyword);
	} else if ($search_field == "user_name") {
		$var_AddSQL .= " AND A.USER_NAME LIKE CONCAT('%',:keyword,'%')";
		$param[] = array(":keyword" => $search_keyword);
	}
}

//if ($search_user_division != "") {
//	$var_AddSQL .= " AND A.USER_DIVISION = :USER_DIVISION ";
//	$param[] = array(":USER_DIVISION" => $search_user_division);
//}

// 정렬 설정
$order_SQL	= "A.USER_SEQ DESC";

if($search_order_target && $search_order_action) {
	if($search_order_target == "USER_SEQ") {
		$order_SQL = "A.USER_SEQ DESC";
	} else{
		$order_SQL = "{$search_order_target} {$search_order_action}, A.USER_SEQ DESC";
	}
}

// 총 레코드 수 / 현재 글번호
$cntq = "SELECT COUNT(*) cnt FROM ".$BOARD_TABLENAME . " A INNER JOIN TB_USER_WITHDRAWAL B ON A.USER_SEQ = B.USER_SEQ {$var_AddSQL} ";
$stmt = $mod->select($pdo, $cntq, $param);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_record = $row["cnt"];
$stmt->closeCursor();
$num = $total_record - ($pagesize * ($var_Page -1));

// 게시물
$var_SQL = " SELECT ";
$var_SQL .= "   A.USER_SEQ, A.USER_DIVISION, A.USER_NAME, A.USER_ID, A.PASSWORD ";
$var_SQL .= " , A.TELEPHONE, A.CELLPHONE, A.EMAIL, A.ZIP_CODE, A.ADDRESS ";
$var_SQL .= " , A.ADDRESS_DETAILS, A.GENDER, A.BIRTHDATE, A.LUNAR_YN, A.SMS_YN ";
$var_SQL .= " , A.EMAIL_YN, A.LOGIN_IP, A.LOGIN_CHECK, A.LOGIN_DATE, A.LOGIN_FAIL_DATE ";
$var_SQL .= " , A.LOGIN_COUNT, A.USER_STATE, A.LANGUAGE_TYPE, A.MOD_DATE, A.REG_DATE ";
$var_SQL .= " , B.REASON, B.APPROVE_YN ";
$var_SQL .= " , B.APPROVE_DATE, B.REG_DATE AS WITHDRAWAL_REG_DATE ";
$var_SQL .= " FROM ".$BOARD_TABLENAME . " A INNER JOIN TB_USER_WITHDRAWAL B ON A.USER_SEQ = B.USER_SEQ ";
$var_SQL .= $var_AddSQL;
$var_SQL .= " ORDER BY ".$order_SQL ." LIMIT ".$start_number.",".$pagesize;
$result = $mod->select($pdo, $var_SQL, $param);
$cnt = $result->rowCount();

// 총 페이지 수
if ($total_record % $pagesize != 0) $tt_page = intval($total_record / $pagesize) + 1;
else $tt_page = intval($total_record / $pagesize);


include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/header.php";
?>
<script type="text/javascript">
//<![CDATA[

function check_delete() {
	var f = document.frm_delete;

	if (0>=getChecked_Count(  f.del_num )) {
		alert("탈퇴 처리할 사용자를 선택해 주세요.");
		return;
	} else {
		if(!confirm("정말 탈퇴 처리 하시겠습니까?")) return;

		f.num.value = getChecked_Value( f.del_num );
		f.action = "board_proc.php";
		f.target="frm_hiddenFrame";
		f.submit();
	}
}

function check_restore() {
	var f = document.frm_delete;

	if (0>=getChecked_Count(  f.del_num )) {
		alert("복구 처리할 사용자를 선택해 주세요.");
		return;
	} else {
		if(!confirm("정말 복구 처리 하시겠습니까?")) return;

		f.num.value = getChecked_Value( f.del_num );
		f.mode.value = "RESTORE";
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

		<h3><div><?=$BOARD_MENU?></div></h3>

		<form name="frm_search" id="frm_search" method="get">
		<input type="hidden" name="page"	value="<?=$var_Page ?>" />
		<input type="hidden" name="num"		value="" />

		<div class="search_type01">

			<div class="col">
				<div class="select_set">
					<strong>키워드</strong>
					<select title="검색키워드" name="search_field">
						<option value="user_id"		<?php if($search_field == "user_id"){?>selected="selected"<?php } ?>>아이디</option>
						<option value="user_name"	<?php if($search_field == "user_name"){?>selected="selected"<?php } ?>>이름</option>
					</select>
					<input type="text" title="검색어 입력창" name="search_keyword" value="<?=$search_keyword?>" placeholder="검색어를 입력해주세요." maxlength="50" onKeyDown="return setFunction_Call( 'search_page()' );"/>
				</div>
			</div>

			<input type="button" value="검색" class="button btn_search" onclick="search_page();" />
		</div>
		</form>
		<!-- //search_type01 -->

		<form name="frm_delete" id="frm_delete" method="post">
		<input type="hidden" name="mode" id="mode"			value="DEL" />
		<input type="hidden" name="page"							value="<?=$var_Page ?>">
		<input type="hidden" name="search_field"					value="<?=$search_field ?>">
		<input type="hidden" name="search_keyword"			value="<?=$search_keyword ?>">
		<input type="hidden" name="search_user_division"		value="<?=$search_user_division ?>">
		<input type="hidden" name="num"								value="" />

		<!-- 리스트 테이블 타입01 -->
		<div class="table_list_type01">

			<div class="table_top">
				<div class="left">
<!-- 					<input type="button" value="완전 삭제" class="button rosy" onclick="check_delete();" /> -->
					<input type="button" value="복구" class="button rosy" onclick="check_restore();" />
				</div>
				<div class="right">

				</div>
			</div>

			<table>
				<colgroup>
					<col width="15px" />
					<col width="78px" />
					<col width="" />
					<col width="" />
					<col width="" />
					<col width="" />
					<col width="" />
					<col width="" />
					<col width="" />
					<col width="" />
					<col width="" />
				</colgroup>
				<thead>
					<tr>
						<th><input type="checkbox" id="checkAll" onClick="setChecked_Reverse('del_num');" /></th>
						<th>번호</th>
						<th>회원등급</th>
						<th>아이디</th>
						<th>이름</th>
						<th>연락처</th>
						<th>휴대전화</th>
						<th>이메일</th>
						<th>등록일</th>
						<th>탈퇴사유</th>
						<th>탈퇴일</th>
					</tr>
				</thead>
				<tbody>
				<?php
				If($cnt > 0){
					for ($i = 0; $i < $cnt; $i++) {
						$row = $result->fetch(PDO::FETCH_ASSOC);
				?>
				<tr>
					<td><input type="checkbox" name="del_num" value="<?=$row['USER_SEQ']?>" /></td>
					<td><?=$num--;?></td>
					<td><?=($row['USER_DIVISION']=="1") ? "일반회원" : "기타회원" ?></td>
					<td><a href="board_view.php?<?=$setParams ?>&page=<?=$var_Page ?>&num=<?=$row['USER_SEQ']?>"><?=$row['USER_ID']?></a></td>
					<td><?=$row['USER_NAME']?></td>
					<td><?=$row['TELEPHONE']?></td>
					<td><?=$row['CELLPHONE']?></td>
					<td><?=$row['EMAIL']?></td>
					<td><?=date("Y-m-d", strtotime($row['REG_DATE'])) ?></td>
					<td><?=$row['REASON']?></td>
					<td><?=date("Y-m-d", strtotime($row['WITHDRAWAL_REG_DATE'])) ?></td>
				</tr>
				<?php
					}
				} else {
				?>
					<tr height="120">
						<td colspan="11">
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
<!-- 					<input type="button" value="완전 삭제" class="button rosy" onclick="check_delete();" /> -->
					<input type="button" value="복구" class="button rosy" onclick="check_restore();" />
				</div>
				<div class="right">

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