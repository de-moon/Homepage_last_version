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
$var_Mode									= $mod->trans3($_REQUEST, "mode", "NEW");
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

if ($var_Mode == "EDT") {
	if ($var_Num == "") $mod->java("{$PARAMETER_002}");
}


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


// ----------------------------------------------------------------------------------------------------
// ## 게시판 정보
// ----------------------------------------------------------------------------------------------------

if ($var_Mode == "EDT") {
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
	$stmt->bindColumn(45, $col_etc_10);
	$stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	$col_telephone = explode("-", $col_telephone);
	$col_cellphone = explode("-", $col_cellphone);
	$col_company_telephone = explode("-", $col_company_telephone);
	$col_company_fax = explode("-", $col_company_fax);
} else {
	$col_user_seq								= "";
	$col_user_division							= "";
	$col_user_name								= "";
	$col_user_id									= "";
	$col_password								= "";
	$col_telephone								= explode("-", "--");
	$col_cellphone								= explode("-", "--");
	$col_email										= "";
	$col_zip_code								= "";
	$col_address									= "";
	$col_address_details						= "";
	$col_gender									= "1";
	$col_birthdate									= "";
	$col_lunar_yn									= "Y";
	$col_sms_yn									= "Y";
	$col_email_yn								= "Y";
	$col_login_ip									= "";
	$col_login_check							= "";
	$col_login_date								= "";
	$col_login_fail_date							= "";
	$col_login_count								= "";
	$col_user_state								= "";
	$col_language_type							= "";
	$col_mod_date								= "";
	$col_reg_date									= "";
	$col_company_name						= "";
	$col_company_position					= "";
	$col_company_department				= "";
	$col_company_telephone					= explode("-", "--");
	$col_company_telephone_sub			= "";
	$col_company_fax							= explode("-", "--");
	$col_company_zip_code					= "";
	$col_company_address					= "";
	$col_company_address_details		= "";
	$col_company_homepage				= "";
	$col_etc_1										= "";
	$col_etc_2										= "";
	$col_etc_3										= "";
	$col_etc_4										= "";
	$col_etc_5										= "";
	$col_etc_6										= "";
	$col_etc_7										= "";
	$col_etc_8										= "";
	$col_etc_9										= "";
	$col_etc_10									= "";
}


include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/header.php";
?>

<link rel="stylesheet" type="text/css" href="<?=$COMMON_PATH?>/js/datetimepicker/jquery.datetimepicker.css"/>
<script src="<?=$COMMON_PATH?>/js/datetimepicker/jquery.datetimepicker.js"charset="utf-8"></script>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>

<script type="text/javascript">
//<![CDATA[

$(document).ready(function() {
	$('#birthdate').datetimepicker({
		lang:'ko',
		timepicker:false,
		yearOffset:-30,
		format:'Y-m-d'
	});
});

function check_register() {
	var f = document.frm_ins;

	<?php if($var_Mode == "NEW"){?>
	if ( !check_Id( f.user_id, 4, 20, true, '아이디' ) ) return false;
	if( f.dup_check_USER_ID_result.value !== "true" ) { alert("아이디 중복확인을 클릭해 주세요.."); return false; }
	if ( !check_Pwd( f.password,  f.password_re, 4, 30, true, '비밀번호' ) ) return false;
	<?php }else{ ?>
	if ( IsEmpty( f.password.value ) == false ) {
		if ( check_Pwd( f.password,  f.password_re, 4, 30, true, '비밀번호' ) == false )	return false;
	}
	<?php } ?>

	if ( !IsCheck(f.user_name, "이름을 입력해주세요.") ) return false;

	$("#button_submit").attr('value', '<?=($var_Mode == "NEW") ? "등록" : "수정" ?>중..'); 
	$("#button_submit").attr('type', 'button'); 

	f.action ="board_proc.php";
	f.target="frm_hiddenFrame";

	return true;
}

function fnZipCode(cKInd){
	new daum.Postcode({
		oncomplete: function(data) {
			var f = document.frm_ins;

			if (cKInd === "user") {
				f.zip_code.value = data.zonecode;
				f.address.value = data.address;
				f.address_details.focus();
			} else {
				f.company_zip_code.value = data.zonecode;
				f.company_address.value = data.address;
				f.company_address_details.focus();
			}
		}
	}).open();
}

function check_duplicate() {
	var f = document.frm_ins;

	if ( check_Id( f.user_id, 4, 20, true, '아이디' ) == false )	return;

	f.action = "board_duplicate_proc.php";
	f.target = "frm_hiddenFrame";
	f.submit();
}

function check_duplicate_true() {
	var f = document.frm_ins;
	f.dup_check_USER_ID_result.value = "true";
}

function check_duplicate_false() {
	var f = document.frm_ins;
	f.dup_check_USER_ID_result.value = "false";
}

function button_recovery() {
	$("#button_submit").attr('value', '<?=($var_Mode == "NEW") ? "등록" : "수정" ?>'); 
	$("#button_submit").attr('type', 'submit'); 
	$("#button_submit").attr('class', 'button rosy'); 
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
			<input type="hidden" name="page"							value="<?=$var_Page ?>" />
			<input type="hidden" name="search_field"					value="<?=$search_field ?>" />
			<input type="hidden" name="search_keyword"			value="<?=$search_keyword ?>" />
			<input type="hidden" name="search_user_division"		value="<?=$search_user_division ?>" />
			<input type="hidden" name="search_pagesize"			value="<?=$search_pagesize ?>">
			<input type="hidden" name="search_order_target"		value="<?=$search_order_target?>">
			<input type="hidden" name="search_order_action"		value="<?=$search_order_action?>">
			<input type="hidden" name="num"								value="<?=$var_Num ?>" />
			</form>

			<form name="frm_ins" action="" method="post" action="board_proc.php" target="frm_hiddenFrame" onsubmit="return check_register();">
			<input type="hidden" name="mode"							value="<?=$var_Mode ?>" />
			<input type="hidden" name="page"							value="<?=$var_Page ?>" />
			<input type="hidden" name="search_field"					value="<?=$search_field ?>" />
			<input type="hidden" name="search_keyword"			value="<?=$search_keyword ?>" />
			<input type="hidden" name="search_user_division"		value="<?=$search_user_division ?>" />
			<input type="hidden" name="search_pagesize"			value="<?=$search_pagesize ?>">
			<input type="hidden" name="search_order_target"		value="<?=$search_order_target?>">
			<input type="hidden" name="search_order_action"		value="<?=$search_order_action?>">
			<input type="hidden" name="num"								value="<?=$var_Num ?>" />
			<input type="hidden" name="language_type"				value="KOR" />
			<input type="hidden" name="user_division"					value="1" />
			<input type="hidden" name="authority_detail"				value="0" />
			<input type="hidden" name="dup_check_USER_ID_result" id="dup_check_USER_ID_result" value="false" />

			<table>
				<colgroup>
					<col width="110px" />
					<col width="*" />
				</colgroup>
				<tr>
					<th class="tl_round">아이디</th>
					<td class="tr_round tal">
						<?php if($var_Mode == "NEW"){?>
						<input type="text" id="" name="user_id" value="" maxlength="30" style="width:30%" placeholder="아이디를 입력하세요." required onchange="check_duplicate_false(); this.value = this.value.toLowerCase(); " />
						<input type="button" value="중복 확인" class="button green" onclick="check_duplicate();" />
						<?php }else{ ?>
						<?=$col_user_id?>
						<input type="hidden" name="user_id" value="<?=$col_user_id ?>" />
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th>비밀번호</th>
					<td class="tal"><input type="password" name="password" maxlength="50" style="width:20%" /></td>
				</tr>
				<tr>
					<th>비밀번호 확인</th>
					<td class="tal"><input type="password" name="password_re" maxlength="50" style="width:20%" /></td>
				</tr>
				<tr>
					<th>이름</th>
					<td class="tal"><input type="text" name="user_name" value="<?=$col_user_name?>" maxlength="30" style="width:20%" placeholder="이름을 입력하세요." required /></td>
				</tr>
				<tr>
					<th>유선전화</th>
					<td class="tal">
						<select title="국번" name="telephone_1" id="telephone_1">
							<option value="02"  <?php if($col_telephone[0] =="02") { ?>selected<?php } ?>>02</option>
							<option value="031" <?php if($col_telephone[0] =="031") { ?>selected<?php } ?>>031</option>
							<option value="032" <?php if($col_telephone[0] =="032") { ?>selected<?php } ?>>032</option>
							<option value="033" <?php if($col_telephone[0] =="033") { ?>selected<?php } ?>>033</option>
							<option value="041" <?php if($col_telephone[0] =="041") { ?>selected<?php } ?>>041</option>
							<option value="042" <?php if($col_telephone[0] =="042") { ?>selected<?php } ?>>042</option>
							<option value="043" <?php if($col_telephone[0] =="043") { ?>selected<?php } ?>>043</option>
							<option value="051" <?php if($col_telephone[0] =="051") { ?>selected<?php } ?>>051</option>
							<option value="052" <?php if($col_telephone[0] =="052") { ?>selected<?php } ?>>052</option>
							<option value="053" <?php if($col_telephone[0] =="053") { ?>selected<?php } ?>>053</option>
							<option value="054" <?php if($col_telephone[0] =="054") { ?>selected<?php } ?>>054</option>
							<option value="055" <?php if($col_telephone[0] =="055") { ?>selected<?php } ?>>055</option>
							<option value="061" <?php if($col_telephone[0] =="061") { ?>selected<?php } ?>>061</option>
							<option value="062" <?php if($col_telephone[0] =="062") { ?>selected<?php } ?>>062</option>
							<option value="063" <?php if($col_telephone[0] =="063") { ?>selected<?php } ?>>063</option>
							<option value="064" <?php if($col_telephone[0] =="064") { ?>selected<?php } ?>>064</option>
							<option value="010" <?php if($col_telephone[0] =="010") { ?>selected<?php } ?>>010</option>
							<option value="011" <?php if($col_telephone[0] =="011") { ?>selected<?php } ?>>011</option>
							<option value="016" <?php if($col_telephone[0] =="016") { ?>selected<?php } ?>>016</option>
							<option value="017" <?php if($col_telephone[0] =="017") { ?>selected<?php } ?>>017</option>
							<option value="018" <?php if($col_telephone[0] =="018") { ?>selected<?php } ?>>018</option>
							<option value="019" <?php if($col_telephone[0] =="019") { ?>selected<?php } ?>>019</option>
							<option value="070" <?php if($col_telephone[0] =="070") { ?>selected<?php } ?>>070</option>
						</select>
						- <input type="text" name="telephone_2" value="<?=$col_telephone[1]?>" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' />
						- <input type="text" name="telephone_3" value="<?=$col_telephone[2]?>" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' />
					</td>
				</tr>
				<tr>
					<th>휴대전화</th>
					<td class="tal">
						<select title="국번" name="cellphone_1" id="cellphone_1">
							<option value="010" <?php if($col_cellphone[0] =="010") { ?>selected<?php } ?>>010</option>
							<option value="011" <?php if($col_cellphone[0] =="011") { ?>selected<?php } ?>>011</option>
							<option value="016" <?php if($col_cellphone[0] =="016") { ?>selected<?php } ?>>016</option>
							<option value="017" <?php if($col_cellphone[0] =="017") { ?>selected<?php } ?>>017</option>
							<option value="018" <?php if($col_cellphone[0] =="018") { ?>selected<?php } ?>>018</option>
							<option value="019" <?php if($col_cellphone[0] =="019") { ?>selected<?php } ?>>019</option>
							<option value="070" <?php if($col_cellphone[0] =="070") { ?>selected<?php } ?>>070</option>
						</select>
						- <input type="text" name="cellphone_2" value="<?=$col_cellphone[1]?>" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' />
						- <input type="text" name="cellphone_3" value="<?=$col_cellphone[2]?>" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' />
						SMS수신 <input type="radio" id="sms_yn_y" name="sms_yn" value="Y" <?php if($col_sms_yn == "Y") { ?>checked<?php }?> /><label for="sms_yn_y">수신 함</label>&nbsp;&nbsp;&nbsp;
						<input type="radio" id="sms_yn_n" name="sms_yn" value="N" <?php if($col_sms_yn == "N") { ?>checked<?php }?> /><label for="sms_yn_n">수신 안함</label>
					</td>
				</tr>
				<tr>
					<th>이메일</th>
					<td class="tal">
						<input type="text" name="email" value="<?=$col_email ?>" maxlength="50" style="width:30%" />
						메일링수신 <input type="radio" id="email_yn_y" name="email_yn" value="Y" <?php if($col_email_yn == "Y") { ?>checked<?php }?> /><label for="email_yn_y">수신 함</label>&nbsp;&nbsp;&nbsp;
						<input type="radio" id="email_yn_n" name="email_yn" value="N" <?php if($col_email_yn == "N") { ?>checked<?php }?> /><label for="email_yn_n">수신 안함</label>
					</td>
				</tr>
				<tr>
					<th>주소</th>
					<td class="tal">
						<input type="text" id="" name="zip_code" value="<?=$col_zip_code ?>" maxlength="7" readonly="readonly" />
						<input type="button" value="우편번호 찾기" class="button blue" onclick="fnZipCode('user');" /><br/>
						<input type="text" id="" name="address" value="<?=$col_address ?>" maxlength="255" style="width:50%" readonly="readonly" onclick="fnZipCode('user'); return false;" /><br/>
						<input type="text" id="" name="address_details" value="<?=$col_address_details ?>" maxlength="255" style="width:50%" />
					</td>
				</tr>
				<tr>
					<th>성별</th>
					<td class="tal">
						<input type="radio" id="gender_1" name="gender" value="1" <?php if($col_gender == "1") { ?>checked<?php }?> /><label for="gender_1">남자</label>&nbsp;&nbsp;&nbsp;
						<input type="radio" id="gender_2" name="gender" value="2" <?php if($col_gender == "2") { ?>checked<?php }?> /><label for="gender_2">여자</label>
					</td>
				</tr>
				<tr>
					<th>생년월일</th>
					<td class="tal">
						<input type="text" title="생년월일" readonly="readonly" id="birthdate" name="birthdate" value="<?=$col_birthdate == "" ? "" : date("Y-m-d", strtotime($col_birthdate)) ?>">
						<input type="radio" id="lunar_yn_y" name="lunar_yn" value="Y" <?php if($col_lunar_yn == "Y") { ?>checked<?php }?> /><label for="lunar_yn_y">양력</label>&nbsp;&nbsp;&nbsp;
						<input type="radio" id="lunar_yn_n" name="lunar_yn" value="N" <?php if($col_lunar_yn == "N") { ?>checked<?php }?> /><label for="lunar_yn_n">음력</label>
					</td>
				</tr>
			</table>

			<div class="table_top tt1">
				<div class="left">
					추가 정보
				</div>
			</div>

			<table>
				<colgroup>
					<col width="8%" />
					<col width="" />
					<col width="7%" />
					<col width="" />
					<col width="7%" />
					<col width="" />
				</colgroup>
				<tr>
					<th class="tl_round">회사명</th>
					<td class="tr_round tal" colspan="5"><input type="text" id="" name="company_name" value="<?=$col_company_name ?>" maxlength="50" style="width:20%" /></td>
				</tr>
				<tr>
					<th>직급</th>
					<td class="tal" colspan="5"><input type="text" id="" name="company_position" value="<?=$col_company_position ?>" maxlength="50" style="width:20%" /></td>
				</tr>
				<tr>
					<th>부서</th>
					<td class="tal" colspan="5">
						<input type="text" id="" name="company_department" value="<?=$col_company_department?>" maxlength="200" style="width:30%" />
					</td>
				</tr>
				<tr>
					<th>전화번호</th>
					<td class="tal" colspan="7">
						<input type="text" id="" name="company_telephone_1" value="<?=$col_company_telephone[0]?>" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' /> - <input type="text" id="" name="company_telephone_2" value="<?=$col_company_telephone[1]?>" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' /> - <input type="text" id="" name="company_telephone_3" value="<?=$col_company_telephone[2]?>" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' />
						내선번호 : <input type="text" id="" name="company_telephone_sub" value="<?=$col_company_telephone_sub ?>" maxlength="10" />
					</td>
				</tr>
				<tr>
					<th>FAX</th>
					<td class="tal" colspan="7"><input type="text" id="" name="company_fax_1" value="<?=$col_company_fax[0]?>" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' /> - <input type="text" id="" name="company_fax_2" value="<?=$col_company_fax[1]?>" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' /> - <input type="text" id="" name="company_fax_3" value="<?=$col_company_fax[2]?>" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' /></td>
				</tr>
				<tr>
					<th>주소</th>
					<td class="tal">
						<input type="text" id="" name="company_zip_code" value="<?=$col_company_zip_code ?>" maxlength="7" readonly="readonly" />
						<input type="button" value="우편번호 찾기" class="button blue" onclick="fnZipCode('company');" /><br/>
						<input type="text" id="" name="company_address" value="<?=$col_company_address ?>" maxlength="255" style="width:50%" readonly="readonly" onclick="fnZipCode('company'); return false;" /><br/>
						<input type="text" id="" name="company_address_details" value="<?=$col_company_address_details ?>" maxlength="255" style="width:50%" />
					</td>
				</tr>
				<tr>
					<th>홈페이지</th>
					<td class="tal" colspan="5"><input type="url" id="" name="company_homepage" value="<?=$col_company_homepage ?>" maxlength="500" style="width:50%" /></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_1" value="<?=$col_etc_1 ?>" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_2" value="<?=$col_etc_2 ?>" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_3" value="<?=$col_etc_3 ?>" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_4" value="<?=$col_etc_4 ?>" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_5" value="<?=$col_etc_5 ?>" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_6" value="<?=$col_etc_6 ?>" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_7" value="<?=$col_etc_7 ?>" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_8" value="<?=$col_etc_8 ?>" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_9" value="<?=$col_etc_9 ?>" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr style="display:none;">
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_10" value="<?=$col_etc_10 ?>" maxlength="200" style="width:50%" /></td>
				</tr>
			</table>



			<div class="table_bottom">
				<div class="left">
					<a href="board_list.php?<?=$setParams ?>" class="button white">목록</a>
				</div>
				<div class="right">
					<?php if($var_Mode == "NEW"){?>
					<input type="submit" id="button_submit" value="등록" class="button rosy" />
					<a href="board_list.php?<?=$setParams ?>" class="button white">취소</a>
					<?php }else{ ?>
					<input type="submit" id="button_submit" value="수정" class="button rosy" />
					<a href="board_view.php?<?=$setParams ?>&num=<?=$var_Num ?>" class="button white">취소</a>
					<?php } ?>
				</div>
			</div>
			</form>
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