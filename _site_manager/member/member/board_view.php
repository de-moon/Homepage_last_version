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

$var_Page									= $mod->trans3($_REQUEST, "page", "1");
$var_Num									= $mod->trans3($_REQUEST, "num", "");
$search_field								= $mod->trans3($_REQUEST, "search_field", "user_id");
$search_keyword						= $mod->trans3($_REQUEST, "search_keyword", "");
$search_user_division					= $mod->trans3($_REQUEST, "search_user_division", "1");
$search_pagesize						= $mod->trans3($_REQUEST, "search_pagesize", $BOARD_PAGESIZE);
$search_order_target					= $mod->trans3($_REQUEST, "search_order_target", "USER_SEQ");
$search_order_action					= $mod->trans3($_REQUEST, "search_order_action", "");


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
if ($search_user_division != "1") $setParams[] = "search_user_division=".$search_user_division;
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
$var_SQL .= " , B.COMPANY_NAME, B.COMPANY_POSITION ";
$var_SQL .= " , B.COMPANY_DEPARTMENT, B.COMPANY_TELEPHONE ";
$var_SQL .= " , B.COMPANY_TELEPHONE_SUB, B.COMPANY_FAX, B.COMPANY_ZIP_CODE ";
$var_SQL .= " , B.COMPANY_ADDRESS, B.COMPANY_ADDRESS_DETAILS ";
$var_SQL .= " , B.COMPANY_HOMEPAGE, B.ETC_1, B.ETC_2, B.ETC_3, B.ETC_4 ";
$var_SQL .= " , B.ETC_5, B.ETC_6, B.ETC_7, B.ETC_8, B.ETC_9, B.ETC_10 ";
$var_SQL .= " FROM TB_USER A INNER JOIN TB_USER_ADD B ON A.USER_SEQ = B.USER_SEQ ";
$var_SQL .= " WHERE A.USER_STATE = 1 AND A.USER_SEQ = :no ";

$stmt = $pdo->prepare($var_SQL);
$stmt->bindParam(":no", $var_Num);
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
$stmt->bindColumn(26, $col_company_name);
$stmt->bindColumn(27, $col_company_position);
$stmt->bindColumn(28, $col_company_department);
$stmt->bindColumn(29, $col_company_telephone);
$stmt->bindColumn(30, $col_company_telephone_sub);
$stmt->bindColumn(31, $col_company_fax);
$stmt->bindColumn(32, $col_company_zip_code);
$stmt->bindColumn(33, $col_company_address);
$stmt->bindColumn(34, $col_company_address_details);
$stmt->bindColumn(35, $col_company_homepage);
$stmt->bindColumn(36, $col_etc_1);
$stmt->bindColumn(37, $col_etc_2);
$stmt->bindColumn(38, $col_etc_3);
$stmt->bindColumn(39, $col_etc_4);
$stmt->bindColumn(40, $col_etc_5);
$stmt->bindColumn(41, $col_etc_6);
$stmt->bindColumn(42, $col_etc_7);
$stmt->bindColumn(43, $col_etc_8);
$stmt->bindColumn(44, $col_etc_9);
$stmt->bindColumn(45, $etc_10);
$stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();

include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/header.php";
?>
<script type="text/javascript">
//<![CDATA[

function check_delete() {
	if(!confirm("정말 탈퇴 처리 하시겠습니까?")) return;

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

// 프린트
var initBody

var beforePrint = function() {
	initBody = document.body.innerHTML;
	document.body.innerHTML = document.getElementById('table_content_view').outerHTML;
};
var afterPrint = function() {
	document.body.innerHTML = initBody;
};

if (window.matchMedia) {
	var mediaQueryList = window.matchMedia('print');
	mediaQueryList.addListener(function(mql) {
		if (mql.matches) {
			beforePrint();
		} else {
			afterPrint();
		}
	});
}

window.onbeforeprint = beforePrint;
window.onafterprint = afterPrint;
//]]>
</script>
<style type="text/css" media="print">
body {background:#fff;}
    table th,
	table td {border:1px solid #000; padding:10px;}
</style>
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
			<input type="hidden" name="page"							value="<?=$var_Page ?>" />
			<input type="hidden" name="search_field"					value="<?=$search_field ?>" />
			<input type="hidden" name="search_keyword"			value="<?=$search_keyword ?>" />
			<input type="hidden" name="search_user_division"		value="<?=$search_user_division ?>" />
			<input type="hidden" name="num"								value="<?=$var_Num ?>" />
			</form>

			<table>
				<colgroup>
					<col width="110px" />
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
				<tr>
					<th>유선전화</th>
					<td class="tal"><?=$col_telephone ?></td>
				</tr>
				<tr>
					<th>휴대전화</th>
					<td class="tal"><?=$col_cellphone ?></td>
				</tr>
				<tr>
					<th>이메일</th>
					<td class=" tal"><?=$col_email ?></td>
				</tr>
				<tr>
					<th>주소</th>
					<td class="tal">
						[<?=$col_zip_code ?>] <?=$col_address ?> <?=$col_address_details ?>
					</td>
				</tr>
				<tr>
					<th>성별</th>
					<td class="tal">
						<?= $col_gender == "1" ? "남자" : "여자" ?>
					</td>
				</tr>
				<tr>
					<th>생년월일</th>
					<td class="tal">
						<?=date("Y-m-d", strtotime($col_birthdate)) ?>, <?= $col_lunar_yn == "Y" ? "양력" : "음력" ?>
					</td>
				</tr>
				<tr>
					<th>가입일</th>
					<td class="tal"><?=date("Y-m-d", strtotime($col_reg_date)) ?></td>
				</tr>
			</table>

			<div class="table_top tt1">
				<div class="left">
					추가 정보
				</div>
			</div>

			<table>
				<colgroup>
					<col width="110px" />
					<col width="*" />
				</colgroup>
				<tr>
					<th class="tl_round">회사명</th>
					<td class="tr_round tal" colspan="5"><?=$col_company_name ?></td>
				</tr>
				<tr>
					<th>직급</th>
					<td class="tal" colspan="5"><?=$col_company_position ?></td>
				</tr>
				<tr>
					<th>부서</th>
					<td class="tal" colspan="5"><?=$col_company_department?></td>
				</tr>
				<tr>
					<th>전화번호</th>
					<td class="tal" colspan="7"><?=$col_company_telephone ?>, 내선번호 : <?=$col_company_telephone_sub ?>
					</td>
				</tr>
				<tr>
					<th>FAX</th>
					<td class="tal" colspan="7"><?=$col_company_fax ?></td>
				</tr>
				<tr>
					<th>주소</th>
					<td class="tal">
						<?=$col_company_zip_code ?> <?=$col_company_address ?> <?=$col_company_address_details ?>
					</td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><?=$col_company_homepage ?></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><?=$col_etc_1 ?></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><?=$col_etc_2 ?></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><?=$col_etc_3 ?></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><?=$col_etc_4 ?></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><?=$col_etc_5 ?></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><?=$col_etc_6 ?></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><?=$col_etc_7 ?></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><?=$col_etc_8 ?></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><?=$col_etc_9 ?></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><?=$col_etc_10 ?></td>
				</tr>
			</table>

			<div class="table_bottom">
				<div class="left">
					<a href="board_list.php?<?=$setParams ?>" class="button white">목록</a>
				</div>
				<div class="right">
					<input type="button" value="탈퇴" class="button rosy" onclick="check_delete();" />
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