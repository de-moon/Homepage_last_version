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
$search_field					= $mod->trans3($_REQUEST, "search_field", "user_id");
$search_keyword			= $mod->trans3($_REQUEST, "search_keyword", "");
$search_authority			= $mod->trans3($_REQUEST, "search_authority", "");
$search_pagesize			= $mod->trans3($_REQUEST, "search_pagesize", $BOARD_PAGESIZE);
$search_order_target		= $mod->trans3($_REQUEST, "search_order_target", "USER_SEQ");
$search_order_action		= $mod->trans3($_REQUEST, "search_order_action", "");


// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------

if ($var_Num == "") $mod->java("{$PARAMETER_002}");


// ----------------------------------------------------------------------------------------------------
// ## 페이지 이동 파라미터
// ----------------------------------------------------------------------------------------------------

$setParams[] = "page=".$var_Page;
if ($search_field != "user_id") $setParams[] = "search_field=".$search_field;
if ($search_keyword != "") $setParams[] = "search_keyword=".$search_keyword;
if ($search_authority != "") $setParams[] = "search_authority=".$search_authority;
if ($search_pagesize != $BOARD_PAGESIZE) $setParams[] = "search_pagesize=".$search_pagesize;
if ($search_order_target != "USER_SEQ") $setParams[] = "search_order_target=".$search_order_target;
if ($search_order_action != "") $setParams[] = "search_order_action=".$search_order_action;

$setParams = implode("&amp;",$setParams);


// ####################################################################################################
// ## 게시판 정보
// ####################################################################################################

$var_SQL = "SELECT  ";
$var_SQL .= "   A.USER_SEQ, A.USER_DIVISION, A.USER_NAME, A.USER_ID, A.PASSWORD ";
$var_SQL .= " , A.TELEPHONE, A.CELLPHONE, A.EMAIL, A.ZIP_CODE, A.ADDRESS ";
$var_SQL .= " , A.ADDRESS_DETAILS, A.GENDER, A.BIRTHDATE, A.LUNAR_YN, A.SMS_YN ";
$var_SQL .= " , A.EMAIL_YN, A.LOGIN_IP, A.LOGIN_CHECK, A.LOGIN_DATE, A.LOGIN_FAIL_DATE ";
$var_SQL .= " , A.LOGIN_COUNT, A.USER_STATE, A.LANGUAGE_TYPE, A.MOD_DATE, A.REG_DATE ";
$var_SQL .= " , B.AUTHORITY, B.AUTHORITY_DETAIL ";
$var_SQL .= " , C.ETC_1 ";
$var_SQL .= " FROM TB_USER A INNER JOIN TB_ADMIN B ON A.USER_SEQ = B.USER_SEQ ";
$var_SQL .= " INNER JOIN TB_USER_ADD C ON A.USER_SEQ = C.USER_SEQ ";
$var_SQL .= " WHERE A.USER_DIVISION = 9 AND A.USER_STATE = 1 AND A.USER_SEQ = :no ";

$stmt = $pdo->prepare($var_SQL);
$stmt->bindParam(":no", $var_Num);
//echo $stmt->debugDumpParams();
$stmt->execute();
$stmt->bindColumn(1, $col_user_seq);
$stmt->bindColumn(2, $col_user_division);
$stmt->bindColumn(3, $col_user_name);
$stmt->bindColumn(4, $col_user_id);
$stmt->bindColumn(5, $col_password);
$stmt->bindColumn(6, $col_telephone);
$stmt->bindColumn(7, $col_cellphone);
$stmt->bindColumn(8, $col_email);
$stmt->bindColumn(9, $col_zip_code);
$stmt->bindColumn(10, $col_address);
$stmt->bindColumn(11, $col_address_details);
$stmt->bindColumn(12, $col_gender);
$stmt->bindColumn(13, $col_birthdate);
$stmt->bindColumn(14, $col_lunar_yn);
$stmt->bindColumn(15, $col_sms_yn);
$stmt->bindColumn(16, $col_email_yn);
$stmt->bindColumn(17, $col_login_ip);
$stmt->bindColumn(18, $col_login_check);
$stmt->bindColumn(19, $col_login_date);
$stmt->bindColumn(20, $col_login_fail_date);
$stmt->bindColumn(21, $col_login_count);
$stmt->bindColumn(22, $col_user_state);
$stmt->bindColumn(23, $col_language_type);
$stmt->bindColumn(24, $col_mod_date);
$stmt->bindColumn(25, $col_reg_date);
$stmt->bindColumn(26, $col_authority);
$stmt->bindColumn(27, $col_authority_detail);
$stmt->bindColumn(28, $col_receivemail);
$stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();


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

function check_pwc() {
	if(!confirm("비밀번호를 초기화 하시겠습니까?")) return;

	var f = document.frm_search;
	f.mode.value = "PWC"
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

		<h3><div><?=$BOARD_MENU?></div></h3>

		<div class="table_view_type01">

			<form name="frm_search" id="frm_search" method="get">
			<input type="hidden" name="mode"							value="">
			<input type="hidden" name="page"							value="<?=$var_Page ?>">
			<input type="hidden" name="search_field"					value="<?=$search_field ?>">
			<input type="hidden" name="search_keyword"			value="<?=$search_keyword ?>">
			<input type="hidden" name="search_authority"			value="<?=$search_authority ?>">
			<input type="hidden" name="search_pagesize"			value="<?=$search_pagesize ?>">
			<input type="hidden" name="search_order_target"		value="<?=$search_order_target?>">
			<input type="hidden" name="search_order_action"		value="<?=$search_order_action?>">
			<input type="hidden" name="num"								value="<?=$var_Num ?>" />
			</form>

			<table>
				<colgroup>
					<col width="128px" />
					<col width="*" />
				</colgroup>
				<tr>
					<th>아이디</th>
					<td class="tal"><?=$col_user_id ?></td>
				</tr>
                <tr>
					<th>비밀번호</th>
					<td class="tal" colspan="5">
						<input type="button" value="비밀번호 초기화" class="button orange" onclick="check_pwc();" />
					</td>
				</tr>
				<tr>
					<th>이름</th>
					<td class="tal"><?=$col_user_name ?></td>
				</tr>
				<!--tr>
					<th>유선전화</th>
					<td class="tal"><?=$col_telephone ?></td>
				</tr-->
				<tr>
					<th>휴대전화</th>
					<td class="tal"><?=$col_cellphone ?></td>
				</tr>
				<tr>
					<th>이메일</th>
					<td class=" tal"><?=$col_email ?></td>
				</tr>
				<tr>
					<th>온라인 상담 알람</th>
					<td class="tal"><?=$col_receivemail==1?"수신":"미수신"?></td>
				</tr>
				<tr>
					<th>관리 권한</th>
					<td class="tal" colspan="5">
						<?=($col_authority=="PART") ? "부분 관리자" : "최고 관리자" ?><br/>
						<?php If ((2 & $col_authority_detail) > 0 ) { ?>&nbsp;&nbsp;&nbsp;BOARD<br/><?php } ?>
						<?php If ((4 & $col_authority_detail) > 0 ) { ?>&nbsp;&nbsp;&nbsp;MEMBER<br/><?php } ?>
						<?php If ((8 & $col_authority_detail) > 0 ) { ?>&nbsp;&nbsp;&nbsp;SETTING<br/><?php } ?>
					</td>
				</tr>
				<tr>
					<th>등록일</th>
					<td class="tal"><?=date("Y-m-d", strtotime($col_reg_date)) ?></td>
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

	</div>
	<!-- //content -->
</div>
<!-- //wrap -->

<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/footer.php";
?>

</body>
</html>