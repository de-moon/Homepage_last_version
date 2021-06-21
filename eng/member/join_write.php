<?php
include_once $_SERVER['DOCUMENT_ROOT']."/common/include/commonHeader.php";


// ----------------------------------------------------------------------------------------------------
// ## 공통변수 및 사용자정의변수 정의
// ----------------------------------------------------------------------------------------------------

$MENU_DEPTH_1 = "";
$MENU_DEPTH_2 = "";
$MENU_DEPTH_3 = "";


// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------



// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------



// ----------------------------------------------------------------------------------------------------
// ## 페이지 이동 파라미터
// ----------------------------------------------------------------------------------------------------



// ----------------------------------------------------------------------------------------------------
// ## 게시판 정보
// ----------------------------------------------------------------------------------------------------




include_once $_SERVER['DOCUMENT_ROOT']."/common/include/header.php";
?>

<link rel="stylesheet" type="text/css" href="<?=COMMON_PATH ?>/js/datetimepicker/jquery.datetimepicker.css"/>
<script src="<?=COMMON_PATH ?>/js/datetimepicker/jquery.datetimepicker.js"charset="utf-8"></script>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>

<script>
//<![CDATA[

$(document).ready(function() {
	$('#birthdate').datetimepicker({
		lang:'ko',
		timepicker:false,
		format:'Y-m-d'
	});
});

function check_register() {
	var f = document.frm_ins;

	if ( !check_Id( f.user_id, 4, 20, true, '아이디' ) ) return false;
	if( f.dup_check_USER_ID_result.value !== "true" ) { alert("아이디 중복확인을 클릭해 주세요.."); return false; }
	if ( !check_Pwd( f.password,  f.password_re, 4, 30, true, '비밀번호' ) ) return false;
	if( !IsCheck(f.user_name, "이름을 입력해주세요.") ) return false;
	if( !IsCheck(f.cellphone_1, "전화번호를 입력해주세요.") ) return false;
	if( !IsCheck(f.cellphone_2, "전화번호를 입력해주세요.") ) return false;
	if( !IsCheck(f.cellphone_3, "전화번호를 입력해주세요.") ) return false;
	if( !IsCheck(f.email, "이메일을 입력해주세요.") ) return false;
	if( !IsCheck(f.zip_code, "우편번호를 입력해주세요.") ) return false;
	if( !IsCheck(f.address_details, "상세 주소를 입력해주세요.") ) return false;

	return true;
}

function page_reflash() {
	goPageMoveUrl("<%=FRONTROOT %>");
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

	if ( !check_Id( f.user_id, 4, 20, true, '아이디' ) )	return;

	f.action = "join_duplicate_proc.php";
	f.target="frm_hiddenFrame";
	f.submit();
}

function check_duplicate_true() {
	var f = document.frm_ins;
	f.dup_check_USER_ID_result.value = "true";
	f.password.focus();
}

function check_duplicate_false() {
	var f = document.frm_ins;
	f.dup_check_USER_ID_result.value = "false";
}

//]]>
</script>
</head>
<body>

<?php include_once $_SERVER['DOCUMENT_ROOT']."/common/include/skipNav.php"; ?>

	<!-- wrap -->
	<div id="wrap">

		<?php include_once $_SERVER['DOCUMENT_ROOT']."/common/include/top.php"; ?>

		<!--container-->
		<div id="container">


			<form name="frm_ins" method="post" action="join_proc.php" target="frm_hiddenFrame" onsubmit="return check_register();">
			<input type="hidden" name="dup_check_USER_ID_result" id="dup_check_USER_ID_result" value="false">

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
					<th class="tl_round">아이디</th>
					<td class="tr_round tal" colspan="5">
						<input type="text" id="" name="user_id" value="" maxlength="30" style="width:30%" placeholder="아이디를 입력하세요." required onchange="check_duplicate_false(); this.value = this.value.toLowerCase(); " />
						<input type="button" value="중복 확인" class="button green" onclick="check_duplicate();" />
					</td>
				</tr>
				<tr>
					<th>비밀번호</th>
					<td class="tal" colspan="5"><input type="password" id="" name="password" value="" maxlength="50" style="width:20%" placeholder="비밀번호를 입력하세요." required /></td>
				</tr>
				<tr>
					<th>비밀번호 확인</th>
					<td class="tal" colspan="5"><input type="password" id="" name="password_re" value="" maxlength="50" style="width:20%" placeholder="비밀번호를 입력하세요." required /></td>
				</tr>
				<tr>
					<th>이름</th>
					<td class="tal" colspan="5"><input type="text" id="" name="user_name" value="" maxlength="30" style="width:20%" placeholder="이름을 입력하세요." required /></td>
				</tr>
				<tr>
					<th>연락처</th>
					<td class="tal" colspan="7">
						<select title="국번" name="telephone_1" id="telephone_1">
							<option value="02">02</option>
							<option value="031">031</option>
							<option value="032">032</option>
							<option value="033">033</option>
							<option value="041">041</option>
							<option value="042">042</option>
							<option value="043">043</option>
							<option value="051">051</option>
							<option value="052">052</option>
							<option value="053">053</option>
							<option value="054">054</option>
							<option value="055">055</option>
							<option value="061">061</option>
							<option value="062">062</option>
							<option value="063">063</option>
							<option value="064">064</option>
							<option value="010">010</option>
							<option value="011">011</option>
							<option value="016">016</option>
							<option value="017">017</option>
							<option value="018">018</option>
							<option value="019">019</option>
							<option value="070">070</option>
						</select>
						- <input type="tel" id="" name="telephone_2" value="" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' />
						- <input type="tel" id="" name="telephone_3" value="" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' />
					</td>
				</tr>

				<tr>
					<th>휴대전화</th>
					<td class="tal" colspan="7">
						<select name="cellphone_1" id="">
							<option value="010">010</option>
							<option value="011">011</option>
							<option value="016">016</option>
							<option value="017">017</option>
							<option value="018">018</option>
							<option value="019">019</option>
							<option value="070">070</option>
						</select>
						- <input type="tel" id="" name="cellphone_2" value="" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' />
						- <input type="tel" id="" name="cellphone_3" value="" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' />
						SMS수신 <input type="radio" id="sms_yn_y" name="sms_yn" value="Y" /><label for="sms_yn_y">수신 함</label>&nbsp;&nbsp;&nbsp;
						<input type="radio" id="sms_yn_n" name="sms_yn" value="N" checked/><label for="sms_yn_n">수신 안함</label>
					</td>
				</tr>
				<tr>
					<th>이메일</th>
					<td class="tal" colspan="5">
						<input type="email" id="" name="email" value="" maxlength="50" style="width:30%" />
						메일링수신 <input type="radio" id="email_yn_y" name="email_yn" value="Y" /><label for="email_yn_y">수신 함</label>&nbsp;&nbsp;&nbsp;
						<input type="radio" id="email_yn_n" name="email_yn" value="N" checked/><label for="email_yn_n">수신 안함</label>
					</td>
				</tr>
				<tr>
					<th>주소</th>
					<td class="tal">
						<input type="text" id="" name="zip_code" value="" maxlength="7" readonly="readonly" />
						<input type="button" value="우편번호 찾기" class="button blue" onclick="fnZipCode('user');" /><br/>
						<input type="text" id="" name="address" value="" maxlength="255" style="width:50%" readonly="readonly" onclick="fnZipCode('user'); return false;" /><br/>
						<input type="text" id="" name="address_details" value="" maxlength="255" style="width:50%" />
					</td>
				</tr>
				<tr>
					<th>성별</th>
					<td class="tal">
						<input type="radio" id="gender_1" name="gender" value="1" checked/><label for="gender_1">남자</label>&nbsp;&nbsp;&nbsp;
						<input type="radio" id="gender_2" name="gender" value="2" /><label for="gender_2">여자</label>
					</td>
				</tr>
				<tr>
					<th>생년월일</th>
					<td class="tal">
						<input type="text" title="생년월일" readonly="readonly" id="birthdate" name="birthdate" value="">
						<input type="radio" id="lunar_yn_y" name="lunar_yn" value="Y" checked /><label for="lunar_yn_y">양력</label>&nbsp;&nbsp;&nbsp;
						<input type="radio" id="lunar_yn_n" name="lunar_yn" value="N" /><label for="lunar_yn_n">음력</label>
					</td>
				</tr>
			</table>

			<div class="table_top">
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
					<td class="tr_round tal" colspan="5"><input type="text" id="" name="company_name" value="" maxlength="50" style="width:20%" /></td>
				</tr>
				<tr>
					<th>직급</th>
					<td class="tal" colspan="5"><input type="text" id="" name="company_position" value="" maxlength="50" style="width:20%" /></td>
				</tr>
				<tr>
					<th>부서</th>
					<td class="tal" colspan="5">
						<input type="text" id="" name="company_department" value="" maxlength="200" style="width:30%" />
					</td>
				</tr>
				<tr>
					<th>전화번호</th>
					<td class="tal" colspan="7">
						<input type="tel" id="" name="company_telephone_1" value="" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' /> - <input type="tel" id="" name="company_telephone_2" value="" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' /> - <input type="tel" id="" name="company_telephone_3" value="" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' />
						내선번호 : <input type="tel" id="" name="company_telephone_sub" value="" maxlength="10" />
					</td>
				</tr>
				<tr>
					<th>FAX</th>
					<td class="tal" colspan="7"><input type="tel" id="" name="company_fax_1" value="" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' /> - <input type="tel" id="" name="company_fax_2" value="" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' /> - <input type="tel" id="" name="company_fax_3" value="" maxlength="4" onkeypress='SetNum(this)' onblur='SetNum(this)' /></td>
				</tr>
				<tr>
					<th>주소</th>
					<td class="tal">
						<input type="text" id="" name="company_zip_code" value="" maxlength="7" readonly="readonly" />
						<input type="button" value="우편번호 찾기" class="button blue" onclick="fnZipCode('company');" /><br/>
						<input type="text" id="" name="company_address" value="" maxlength="255" style="width:50%" readonly="readonly" onclick="fnZipCode('company'); return false;" /><br/>
						<input type="text" id="" name="company_address_details" value="" maxlength="255" style="width:50%" />
					</td>
				</tr>
				<tr>
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="company_homepage" value="" maxlength="500" style="width:50%" /></td>
				</tr>
				<tr>
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_1" value="" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr>
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_2" value="" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr>
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_3" value="" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr>
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_4" value="" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr>
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_5" value="" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr>
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_6" value="" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr>
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_7" value="" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr>
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_8" value="" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr>
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_9" value="" maxlength="200" style="width:50%" /></td>
				</tr>
				<tr>
					<th>기타</th>
					<td class="tal" colspan="5"><input type="text" id="" name="etc_10" value="" maxlength="200" style="width:50%" /></td>
				</tr>
			</table>

			<input type="submit" value="등록" class="button rosy" />
			<input type="button" value="취소" class="button rosy" onclick="page_reflash(); " />

			</form>




		</div>
		<!--//contents-->

		<?php include_once $_SERVER['DOCUMENT_ROOT']."/common/include/footer.php"; ?>

	</div>
	<!-- //wrap -->

</body>
</html>