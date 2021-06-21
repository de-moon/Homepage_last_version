<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/commonHeader.php";
include_once "./board_info.php";


// ----------------------------------------------------------------------------------------------------
// ## 공통변수 및 사용자정의변수 정의
// ----------------------------------------------------------------------------------------------------



// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------

$var_Mode						= "EDT";


// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------



// ----------------------------------------------------------------------------------------------------
// ## 페이지 이동 파라미터
// ----------------------------------------------------------------------------------------------------



// ----------------------------------------------------------------------------------------------------
// ## 게시판 정보
// ----------------------------------------------------------------------------------------------------

$var_SQL = "SELECT  ";
$var_SQL .= "   A.USER_SEQ, A.USER_DIVISION, A.USER_NAME, A.USER_ID, A.PASSWORD ";
$var_SQL .= " , A.TELEPHONE, A.CELLPHONE, A.EMAIL, A.ZIP_CODE, A.ADDRESS ";
$var_SQL .= " , A.ADDRESS_DETAILS, A.GENDER, A.BIRTHDATE, A.LUNAR_YN, A.SMS_YN ";
$var_SQL .= " , A.EMAIL_YN, A.LOGIN_IP, A.LOGIN_CHECK, A.LOGIN_DATE, A.LOGIN_FAIL_DATE ";
$var_SQL .= " , A.LOGIN_COUNT, A.USER_STATE, A.LANGUAGE_TYPE, A.MOD_DATE, A.REG_DATE ";
$var_SQL .= " , B.AUTHORITY, B.AUTHORITY_DETAIL ";
$var_SQL .= " FROM TB_USER A INNER JOIN TB_ADMIN B ON A.USER_SEQ = B.USER_SEQ ";
$var_SQL .= " WHERE A.USER_DIVISION = 9 AND A.USER_STATE = 1 AND A.USER_SEQ = :no ";

$stmt = $pdo->prepare($var_SQL);
$stmt->bindParam(":no", $_SESSION['MALGUM_USER_SEQ']);
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
$stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();
$col_telephone = explode("-", $col_telephone);
$col_cellphone = explode("-", $col_cellphone);


include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/header.php";
?>

<script type="text/javascript">
//<![CDATA[
function check_register() {
	var f = document.frm_ins;

	if( !IsCheck(f.password_now, "현재 비밀번호를 입력해주세요.") ) return false;

	if ( IsEmpty( f.password.value ) == false ) {
		if ( check_Pwd( f.password,  f.password_re, 4, 30, true, '비밀번호' ) == false )	return false;
	}
	if ( !IsCheck(f.user_name, "이름을 입력해주세요.") ) return false;

	$("#button_submit").attr('value', '<?=($var_Mode == "NEW") ? "등록" : "수정" ?>중..'); 
	$("#button_submit").attr('type', 'button'); 

	f.action ="myinfo_proc.php";
	f.target="frm_hiddenFrame";

	return true;
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

			<form name="frm_ins" action="" method="post" action="myinfo_proc.php" target="frm_hiddenFrame" onsubmit="return check_register();">
			<input type="hidden" name="mode"				 	value="EDT" />

			<table>
				<colgroup>
					<col width="110px" />
					<col width="*" />
				</colgroup>
				<tr>
					<th class="tl_round">아이디</th>
					<td class="tr_round tal"><?=$col_user_id ?></td>
				</tr>
				<tr>
					<th>현재 비밀번호</th>
					<td class="tal" colspan="5"><input type="password" id="" name="password_now" value="" maxlength="50" style="width:20%" placeholder="현재 비밀번호를 입력하세요." required/></td>
				</tr>
				<tr>
					<th>비밀번호</th>
					<td class="tal"><input type="password" name="password" maxlength="50" style="width:20%" placeholder="변경할 비밀번호를 입력하세요." <?php if (!$BOARD_INFO_EDIT) { ?>required<?php } ?>/></td>
				</tr>
				<tr>
					<th>비밀번호 확인</th>
					<td class="tal"><input type="password" name="password_re" maxlength="50" style="width:20%" placeholder="비밀번호를 다시 입력하세요." <?php if (!$BOARD_INFO_EDIT) { ?>required<?php } ?>/></td>
				</tr>
				<tr <?php if (!$BOARD_INFO_EDIT) { ?>style="display:none;"<?php } ?>>
					<th>이름</th>
					<td class="tal"><input type="text" name="user_name" value="<?=$col_user_name?>" maxlength="30" style="width:20%" placeholder="이름을 입력하세요." required /></td>
				</tr>
				<tr <?php if (!$BOARD_INFO_EDIT) { ?>style="display:none;"<?php } ?>>
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
				<tr <?php if (!$BOARD_INFO_EDIT) { ?>style="display:none;"<?php } ?>>
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
					</td>
				</tr>
				<tr <?php if (!$BOARD_INFO_EDIT) { ?>style="display:none;"<?php } ?>>
					<th>이메일</th>
					<td class="tal"><input type="text" name="email" value="<?=$col_email ?>" maxlength="50" style="width:30%" /></td>
				</tr>
			</table>

			<div class="table_bottom">
				<div class="left">

				</div>
				<div class="right">
					<input type="submit" id="button_submit" value="수정" class="button rosy" />
					<a href="<?=$ADMINROOT ?>" class="button white">취소</a>
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