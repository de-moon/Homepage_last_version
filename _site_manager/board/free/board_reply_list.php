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
$var_Num						= $mod->trans3($_REQUEST, "num", "");
$search_division				= $BOARD_DIVISION;
$search_field					= $mod->trans3($_REQUEST, "search_field", "");
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



// ----------------------------------------------------------------------------------------------------
// ## 페이지 이동 파라미터
// ----------------------------------------------------------------------------------------------------

if ($search_field != "") $setParams[] = "search_field=".$search_field;
if ($search_keyword != "") $setParams[] = "search_keyword=".$search_keyword;
if ($search_category != "") $setParams[] = "search_category=".$search_category;
if ($search_view_yn != "") $setParams[] = "search_view_yn=".$search_view_yn;
if ($search_language_type != "") $setParams[] = "search_language_type=".$search_language_type;
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
$var_AddSQL		= " WHERE A.DEL_YN= 'N' AND A.BOARD_SEQ = {$var_Num}";

if ($search_keyword != "" && $search_field != "" ) {
	$var_AddSQL .= " AND A.".$search_keyword." LIKE CONCAT('%',:keyword,'%')";
	$param[] = array(":keyword" => $search_keyword);
}

// 정렬 설정
$order_SQL	= "A.REPLY_SEQ DESC";

// 총 레코드 수 / 현재 글번호
$cntq = "SELECT COUNT(*) cnt FROM ".$BOARD_TABLENAME . "_REPLY A {$var_AddSQL} ";
$stmt = $mod->select($pdo, $cntq, $param);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_record = $row["cnt"];
$stmt->closeCursor();
$num = $total_record - ($pagesize * ($var_Page -1));

// 게시물
$var_SQL = " SELECT ";
$var_SQL .= "   A.REPLY_SEQ, A.USER_NAME, A.PASSWORD, A.REPLY_CONTENT, A.USER_DIVISION ";
$var_SQL .= " , A.REGISTER_IP, A.DEL_YN, A.MOD_DATE, A.REG_DATE, A.BOARD_SEQ, A.USER_SEQ ";
$var_SQL .= " , (SELECT B.USER_NAME FROM TB_USER B WHERE B.USER_SEQ = A.USER_SEQ)  AS WRITER_USER ";
$var_SQL .= " FROM ".$BOARD_TABLENAME."_REPLY A ";
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

function check_delete(nNum) {
	var f = document.frm_delete;

	if (nNum != "") {
		$('input:checkbox[id="replynum_'+nNum+'"]').attr("checked", true);
	}

	if (0>=getChecked_Count( f.del_replynum )) {
		alert("삭제할 게시물을 선택해 주세요.");
		return;
	} else {
		if(!confirm("정말 삭제 하시겠습니까?")) return;

		f.replynum.value = getChecked_Value( f.del_replynum );
		f.action = "board_reply_proc.php";
		f.target="frm_hiddenFrame2";
		f.submit();
	}
}

function search_page() {
	var f = document.frm_search;

	f.action = "board_reply_list.php";
	f.submit();
}

function check_register() {
	var f = document.frm_ins;

	if( !IsCheck(f.reply_content, "내용을 입력해주세요.") ) return false;

	$("#button_submit").attr('value', '등록중..'); 
	$("#button_submit").attr('type', 'button'); 
	$("#button_submit").attr('class', 'button red'); 

	f.action ="board_reply_proc.php";
	f.target="frm_hiddenFrame2";

	return true;
}

function button_recovery() {
	$("#button_submit").attr('value', '등록'); 
	$("#button_submit").attr('type', 'submit'); 
	$("#button_submit").attr('class', 'button rosy'); 
}

function setContent(nNum, sContent) {
	var f = document.frm_ins;

	f.mode.value = "EDT";
	f.replynum.value = nNum;
	f.reply_content.value = sContent.replace(/(<br>|<br\/>|<br \/>)/g, '\r\n');
	f.reply_content.focus();

	$("#button_submit").attr('value', '수정'); 
}
//]]>
</script>
<style type="text/css">
	body {position:relative;height:100%;background:#ffffff }
</style>
</head>
<body>

<div id="wrap">

	<div class="table_view_type01">

		<form name="frm_ins" method="post" action="board_reply_proc.php" target="frm_hiddenFrame2" onsubmit="return check_register();">
		<input type="hidden" name="mode" id="mode"	value="NEW">
		<input type="hidden" name="page"					value="<?=$var_Page ?>">
		<input type="hidden" name="num" 					value="<?=$var_Num ?>">
		<input type="hidden" name="replynum" 				value="">

		<table>
			<colgroup>
				<col width="100px" />
				<col width="" />
				<col width="120px" />
			</colgroup>
			<tr>
				<th class="tl_round">덧글 내용</th>
				<td class=" tal">
					<textarea name="reply_content" style="width:99%; " placeholder="내용을 입력하세요." maxlength="1000" required></textarea>
				</td>
				<td class="tr_round tal">
					<input type="submit" id="button_submit" value="등록" class="button rosy" />
					<input type="reset" value="취소" class="button white" />
				</td>
			</tr>
		</table>

		</form>

	</div>

	<form name="frm_search" id="frm_search" method="get">
		<input type="hidden" name="page"					value="<?=$var_Page ?>">
		<input type="hidden" name="num" 					value="<?=$var_Num ?>">
	</form>

	<form name="frm_delete" id="frm_delete" method="post">
	<input type="hidden" name="mode"					value="DEL" />
	<input type="hidden" name="page"					value="<?=$var_Page ?>">
	<input type="hidden" name="num"						value="<?=$var_Num ?>">
	<input type="hidden" name="replynum"				value="">

	<!-- 리스트 테이블 타입01 -->
	<div class="table_list_type01">

		<table>
			<colgroup>
				<col width="15px" />
				<col width="70px" />
				<col width="" />
				<col width="100px" />
				<col width="100px" />
				<col width="120px" />
			</colgroup>
			<thead>
				<tr>
					<th><input type="checkbox" onClick="setChecked_Reverse('del_replynum');" /></th>
					<th>번호</th>
					<th>내용</th>
					<th>작성자</th>
					<th>등록일</th>
					<th>관리</th>
				</tr>
			</thead>
			<tbody>
			<?php
				If($cnt > 0){
					for ($i = 0; $i < $cnt; $i++) {
						$row = $result->fetch(PDO::FETCH_ASSOC);
						$print_num = $num--;
			?>
				<tr>
					<td><input type="checkbox" name="del_replynum" id="replynum_<?=$row['REPLY_SEQ'] ?>" value="<?=$row['REPLY_SEQ'] ?>" /></td>
					<td><?=$print_num ?></td>
					<td class="tal"><?=nl2br($row['REPLY_CONTENT']) ?></td>
					<td><?=$row['WRITER_USER'] ?></td>
					<td><?=date("Y-m-d", strtotime($row['REG_DATE'])) ?></td>
					<td>
						<input type="button" id="button_edt" value="수정" class="button white" onclick="setContent(<?=$row['REPLY_SEQ'] ?>, '<?=preg_replace("/\r\n|\r|\n/", "<br/>", $row['REPLY_CONTENT']) ?>'); return false;" />
						<input type="button" value="삭제" class="button rosy" onclick="check_delete('<?=$row['REPLY_SEQ'] ?>');" />
					</td>
				</tr>
			<?php
					}
				} else {
			?>
				<tr height="120">
					<td colspan="6">
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
				<input type="button" value="삭제" class="button rosy" onclick="check_delete('');" />
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
<!-- //wrap -->

<div <?php if ("112.220.102.26" != $_SERVER[ 'REMOTE_ADDR']) { ?>style='display:none;'<?php } ?>>
<!--폼 처리용 히튼 프레임 시작-->
<iframe id="frm_hiddenFrame2" name="frm_hiddenFrame2" frameborder="0" scrolling="no" height="1800" width="1800" title="내용없음"></iframe>
<!--폼 처리용 히튼 프레임 종료-->
</div>

<script type='text/javascript'>
	parent.document.all.replyList.height = document.body.scrollHeight;
</script>

</body>
</html>