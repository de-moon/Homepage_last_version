<?php
include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/commonHeader.php";
include_once "./board_info.php";


// ----------------------------------------------------------------------------------------------------
// ## 공통변수 및 사용자정의변수 정의
// ----------------------------------------------------------------------------------------------------



// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------



// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------



// ----------------------------------------------------------------------------------------------------
// ## 페이지 이동 파라미터
// ----------------------------------------------------------------------------------------------------



// ####################################################################################################
// ## 게시판 정보
// ####################################################################################################



include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/header.php";
?>
<?php if ( $NEWRECAPTCHA ) { ?><script src='https://www.google.com/recaptcha/api.js'></script><?php } ?>

<script type="text/javascript">
//<![CDATA[

function check_register() {
	var f = document.frm_ins;

	if( getChecked_Value( f.user_agree ) != "Y") { alert("개인정보 취급방침에 동의해 주세요."); return false;}
	if( !IsCheck(f.subject, "관련벤더를 입력해주세요.") ) return false;
	if( !IsCheck(f.etc_1, "회사를 입력해주세요.") ) return false;
	if( !IsCheck(f.etc_2, "부서를 입력해주세요.") ) return false;
	if( !IsCheck(f.etc_3, "성함을 입력해주세요.") ) return false;
	if( !IsCheck(f.etc_4, "직책을 입력해주세요.") ) return false;
	if( !IsCheck(f.etc_5, "연락처를 입력해주세요.") ) return false;
	if( !IsCheck(f.etc_6, "이메일을 입력해주세요.") ) return false;
	if( !IsCheck(f.content, "문의내용을를 입력해주세요.") ) return false;

	<?php if ( $NEWRECAPTCHA ) { ?>
	var captcha = grecaptcha.getResponse();
	if (captcha.length == 0) {
		alert("자동등록방지를 확인해 주세요.");
		return false;
	}
	<?php } ?>

	$("#button_submit").attr('value', '등록중..');
	$("#button_submit").attr('type', 'button');

	f.action ="board_proc.php";
	f.target="frm_hiddenFrame";

	return true;
}

function button_recovery() {
	$("#button_submit").attr('value', '등록');
	$("#button_submit").attr('type', 'submit');
}

//]]>
</script>
</head>
<body>

<?php include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/skipNav.php"; ?>

	<!-- wrap -->
	<div id="wrap" class="sub history">

		<?php include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/top.php"; ?>

		<!--container-->
		<div id="container">
			<?php include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/location.php"; ?>
			<div class="contents">
				<div class="inner">
					<div class="subTit">
						<h2><?=$MENU_TITLE_2 ?></h2>
						<p>PNDINC 홈페이지를 방문해 주셔서 감사드립니다. <br>당사에 대한 문의 사항이나 제품관련문의 사항이 있을 경우 아래의 양식을 작성 하신 후 하단 확인 버튼을 눌러주세요. 보내주신 의견 및 문의에 대해 빠른 답변을 드리겠습니다.</p>
					</div>
					<form name="frm_ins" method="post" enctype="multipart/form-data" action="board_proc.php" target="frm_hiddenFrame" onsubmit="return check_register();">

					<div class="subContWrap ty2 board">
						<div class="subContSec">
							<div class="tit_set1">
								<h3>제품문의</h3>
								<p>문의사항을 기재하시어 제출해주시면, PNDINC 담당자가 확인 후 답변 드리겠습니다.</p>
							</div>
							<div class="type_table">
								<div>
									<div class="boardViewTop_item">
										<strong>관련벤더(제품)*</strong>
										<div class="type_td"><input type="text" class="input_ty1" name="subject" value="" maxlength="100" required></div>
									</div>
								</div>
								<div class="col2">
									<div class="boardViewTop_item">
										<strong>회사*</strong>
										<div class="type_td"><input type="text" class="input_ty1" name="etc_1" value="" maxlength="100" required></div>
									</div>
									<div class="boardViewTop_item">
										<strong>부서*</strong>
										<div class="type_td"><input type="text" class="input_ty1" name="etc_2" value="" maxlength="100" required></div>
									</div>
								</div>
								<div class="col2">
									<div class="boardViewTop_item">
										<strong>성함*</strong>
										<div class="type_td"><input type="text" class="input_ty1" name="etc_3" value="" maxlength="100" required></div>
									</div>
									<div class="boardViewTop_item">
										<strong>직책*</strong>
										<div class="type_td"><input type="text" class="input_ty1" name="etc_4" value="" maxlength="100" required></div>
									</div>
								</div>
								<div class="col2">
									<div class="boardViewTop_item">
										<strong>연락처(휴대폰)*</strong>
										<div class="type_td"><input type="tel" class="input_ty1" name="etc_5" value="" maxlength="100" required></div>
									</div>
									<div class="boardViewTop_item">
										<strong>이메일*</strong>
										<div class="type_td"><input type="email" class="input_ty1" name="etc_6" value="" maxlength="100" required></div>
									</div>
								</div>
								<div>
									<div class="boardViewTop_item">
										<strong>문의내용*</strong>
										<div class="type_td">
											<textarea name="content" id="content_" class="ta_ty1" required></textarea>
										</div>
									</div>
								</div>
								<?php if ( $NEWRECAPTCHA ) { ?>
								<div>
									<div class="boardViewTop_item">
										<strong>자동등록방지</strong>
										<div class="type_td"><div class="g-recaptcha" data-sitekey="<?=$NEWRECAPTCHA_SITEKEY ?>"></div></div>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="subContSec">
							<div class="tit_set1">
								<h3>개인정보처리방침*</h3>
							</div>
							<div class="termsArea">
								<strong>[제공받는 자]</strong>
								<strong>PNDINC</strong><br>

								<strong>[수집 및 이용 목적] </strong>
								(1) 제품 정보, 고객 행사 및 보안 세미나, 세일즈 프로모션, 보안 관련 뉴스 정보 제공, 제품 교육, 새로운 서비스 안내 등의 e-mail 제공 및 전화를 통한 안내와 고객 관리 및 마케팅 활동을 목적으로 귀하의 개인정보를 수집 및 활용하는 것에 동의합니다. <br>
								(2) 귀하의 정보가 전자 마케팅 활동 및 기타 용도로 사용될 수 있고, 처리를 위해 거주 국가 이외 지역으로 전송될 수 있으며, 이러한 지역의 데이터 보호 표준이 거주 국가와 다를 수 있음을 이해하고 인정합니다. <br><br>

								<strong>[수집 항목]</strong>
								회사명, 성명, 부서, 직책, 연락처, 이메일<br><br>

								<strong>[보유 기간]</strong>
								정보주체의 탈회 요청 및 개인정보 활용 거부 의사 표현시까지<br><br>

								<strong>[이용에 대한 거부권리 및 불이익]</strong>
								귀하는 위 항목에 해당하는 개인정보의 수집 및 이용에 대한 동의를 거부할 수 있으며, 동의를 거부한 경우 상기 수집 및 이용 목적에 명시된 서비스 및 혜택은 제공되지 않습니다.
							</div>
							<div class="inquiry_agree  ">
								<label class="type_radio"><input type="radio" id="" name="user_agree" value="Y" required><span class="fake_radio"></span> 동의합니다.</label>
								<label class="type_radio"><input type="radio" id="" name="user_agree" value="N"><span class="fake_radio"></span> 동의하지 않습니다.</label>
							</div>
						</div>
						<div class="btn_box taC">
							<input type="submit" id="button_submit" value="등록" class="btn_ty2 ">
						</div>
					</div>

					</form>
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