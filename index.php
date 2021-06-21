<?php
include_once $_SERVER['DOCUMENT_ROOT']."/common/include/commonHeader.php";


// ----------------------------------------------------------------------------------------------------
// ## 공통변수 및 사용자정의변수 정의
// ----------------------------------------------------------------------------------------------------

$MENU_DEPTH_1 = "";
$MENU_DEPTH_2 = "";
$MENU_DEPTH_3 = "";
$MENU_TITLE_1		= "";
$MENU_TITLE_2		= "";
$MENU_TITLE_3		= "";

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
<script>
function check_register() {
	var f = document.frm_ins;
	if( getChecked_Value( f.user_agree ) != "Y") { alert("개인정보 취급방침에 동의해 주세요."); return false;}
	//if( !IsCheck(f.subject, "관련벤더를 입력해주세요.") ) return false;
	//if( !IsCheck(f.etc_1, "회사를 입력해주세요.") ) return false;
	//if( !IsCheck(f.etc_2, "부서를 입력해주세요.") ) return false;
	//if( !IsCheck(f.etc_3, "성함을 입력해주세요.") ) return false;
	//if( !IsCheck(f.etc_4, "직책을 입력해주세요.") ) return false;
	//if( !IsCheck(f.etc_5, "연락처를 입력해주세요.") ) return false;
	//if( !IsCheck(f.etc_6, "이메일을 입력해주세요.") ) return false;
	//if( !IsCheck(f.content, "문의내용을를 입력해주세요.") ) return false;

	//<?php if ( $NEWRECAPTCHA ) { ?>
	//var captcha = grecaptcha.getResponse();
	//if (captcha.length == 0) {
	//	alert("자동등록방지를 확인해 주세요.");
	//	return false;
	//}
	//<?php } ?>

	$("#button_submit").attr('value', '등록중..');
	$("#button_submit").attr('type', 'button');

	f.action ="/board/contact/board_proc.php";
	f.target="frm_hiddenFrame";

	return true;
}
</script>
</head>
<body>

<?php include_once $_SERVER['DOCUMENT_ROOT']."/common/include/skipNav.php"; ?>

	<!-- wrap -->
	<div id="wrap">

		<?php include_once $_SERVER['DOCUMENT_ROOT']."/common/include/top.php"; ?>

		<!--container-->
		<div id="container">
		<!-- mv -->
			<div class="mvWrap winH aniBox">
				<div class="mvCont aniBox">
					<div class="mv_vid">
						<video class="main_vid" autoplay  loop playsinline muted>
							<source src="/video/mv.mp4" type="video/mp4">
						   <!-- <source src="/video/mv.ogg" type="video/ogg"> -->
						    Your browser does not support the video tag
						</video>
					</div>
					<div class="mv_txt">
						<div class="mv_txt_inner">
							<strong><em>We understand</em></strong>
							<strong><em>You & Cancer</em></strong>
							<p>We’re with you in your journey <br class="mo_only">through fighting against cancer.</p>
						</div>
					</div>
					<div class="iconScr">
						<div>
							<span>Scroll down</span> <em></em>
						</div>
					</div>
				</div>
			</div>
			<!--// mv -->

			<!-- contents -->
			<div class="mainSecWrap">
				<!-- mainSec1 -->
				<div class="mainSec mainSec1 ">
					<div class="msCol2Wrap aniBox winH">
						<div class="col-txt">
							<div class="txt_box aniBox type_bot">
								<strong>How we can <br>understand <br class="mo_only">You</strong>
								<p>한 번의 채혈로 종양 DNA의 <br class="mo_only">다양한 유전자 변이를 검사합니다.  <br>
								치료에 도움이 되는 맞춤형 정보를 드립니다. <br>
								환자와 의료진에게 합리적인 가격으로 임상 서비스를 제공합니다.</p>
							</div>
						</div>
						<div class="col-img aniBox type_cv leftright">
							<span style="background-image: url(../../images/main/img_ms1-1.jpg);"></span>
						</div>
					</div>
					<div class="msCol2Wrap aniBox winH ty_rvs">
						<div class="col-txt ty_blue">
							<div class="txt_box aniBox type_bot">
								<strong>How we can <br>understand Cancer</strong>
								<p>자체 개발한 최적화된 실험/분석 기술을 통해 <br class="mo_only">암의 유전자 변이를
								정확히 분석합니다. <br>
								임상 Big Data를 인공지능(AI) 기술로 분석하여 <br class="mo_only">암의 예후 및
								치료 효과를 예측합니다. <br>
								암을 더 정확히 이해하기 위해 <br class="mo_only">끊임없이 기술을 개발하고 있습니다.</p>
								<a href="<?=$FRONTROOT ?>technology/technology.php"  class="btn_underline">View more</a>
							</div>
						</div>
						<div class="col-img aniBox type_cv rightleft">
							<span style="background-image: url(../../images/main/img_ms1-2.jpg);"></span>
						</div>
					</div>
				</div>
				<!-- mainSec2 -->
				<div class="mainSec mainSec2">
					<div class="ms_inner ms2">
						<div class="mainTit aniBox type_bot">
							<h2>How we can <br class="mo_only">help you</h2>
						</div>
						<div class="ms2Cont aniBox type_bot">
							<strong>AlphaLiquid®Test</strong>
							<div class="ms_testList col3List">
								<em></em>
								<ul>
									<li>
										<div class="list-item  aniBox2 type_bot delay02">
											<div class="icon_box icon1"></div>
											<strong>치료제 매칭</strong>
											<p>AlphaLiquid®test를 통해 환자의 유전자 변이에 <br>
											알맞은 치료제를 추천해드립니다. </p>
											<p>(치료기간 단축, 비용 절감 효과)</p>
										</div>
									</li>
									<li>
										<div class="list-item aniBox2 type_bot delay03">
											<div class="icon_box icon2"></div>
											<strong>재발 모니터링</strong>
											<p>간단한 혈액 검사로 <br>
											암의 재발 여부를 영상 진단 이전에 <br>
											확인하실 수 있습니다.</p>
										</div>
									</li>
									<li>
										<div class="list-item aniBox2 type_bot delay04">
											<div class="icon_box icon3"></div>
											<strong>암 조기진단</strong>
											<p>유전체 변이의 패턴 분석을 통해 <br>
											암 조기진단이 가능합니다.</p>
										</div>
									</li>
								</ul>
							</div>
							<div class="btn_box taC">
								<a href="<?=$FRONTROOT ?>tests/tests.php" class="btn_underline">View more</a>
							</div>
						</div>
					</div>
				</div>
				<!-- mainSec3 -->
				<div class="mainSec mainSec3">
					<div class="ms_inner ms3">
						<div class="mainTit aniBox type_bot">
							<h2>Test Process</h2>
						</div>
					</div>
					<div class="ms_testStep col4List">
						<div class="arr aniBox type_left"></div>
						<ul>
							<li>
								<div class="list-item aniBox2 type_bot delay02">
									<div class="img_box"><img src="<?=$IMAGES_PATH ?>/main/icon_ms3-1.png" alt=""></div>
									<span class="num">1</span>
									<strong>구비서류 작성</strong>
									<em class="dot"></em>
								</div>
							</li>
							<li>
								<div class="list-item aniBox2 type_bot delay03">
									<div class="img_box"><img src="<?=$IMAGES_PATH ?>/main/icon_ms3-2.png" alt=""></div>
									<span class="num">2</span>
									<strong>채혈 진행</strong>
									<em class="dot"></em>
								</div>
							</li>
							<li>
								<div class="list-item aniBox2 type_bot delay04">
									<div class="img_box"><img src="<?=$IMAGES_PATH ?>/main/icon_ms3-3.png" alt=""></div>
									<span class="num">3</span>
									<strong>검사 진행</strong>
									<em class="dot"></em>
								</div>
							</li>
							<li>
								<div class="list-item aniBox2 type_bot delay05">
									<div class="img_box"><img src="<?=$IMAGES_PATH ?>/main/icon_ms3-4.png" alt=""></div>
									<span class="num">4</span>
									<strong>결과 상담</strong>
									<em class="dot"></em>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<!-- mainSec4 -->
				<div class="mainSec mainSec4" id="contactUs">
					<div class="ms_inner ms4">
						<div class="mainTit ty_ms4 aniBox type_bot">
							<h2>Contact us</h2>
						</div>
						<div class="contactWrap aniBox type_bot">
							<form name="frm_ins" method="post" enctype="multipart/form-data" action="board_proc.php" target="frm_hiddenFrame" onsubmit="return check_register();">
							<div class="inputWrap col2List">
								<ul>
									<li>
										<div class="contact_list">
											<span class="essen">이름</span>
											<input type="text" class="input" id="etc_3" name="etc_3" required>
										</div>
									</li>
									<li>
										<div class="contact_list">
											<span class="essen">연락처</span>
											<input type="text" class="input" id="etc_5" name="etc_5" required>
										</div>
									</li>
									<li>
										<div class="contact_list">
											<span class="essen">국가</span>
											<input type="text" class="input" id="etc_2" name="etc_2" required>
										</div>
									</li>
									<li>
										<div class="contact_list">
											<span class="essen">이메일</span>
											<input type="text" class="input" id="etc_6" name="etc_6" required>
										</div>
									</li>
									<li>
										<div class="contact_list">
											<span class="essen">소속</span>
											<input type="text" class="input" id="etc_1" name="etc_1" required>
										</div>
									</li>
									<li>

										<div class="contact_list no_pd">
											<select name="etc_4" id="etc_4" class="select">
												<option value="-" selected>주제</option>
												<option value="AL-10(Colon)">AL-10(Colon)</option>
												<option value="AL-100">AL-100</option>
												<option value="AL-1000">AL-1000</option>
												<option value="AL-Screening">AL-Screening</option>
												<option value="AL Tube">AL Tube</option>
												<option value="기타">기타</option>
											</select>
										</div>
									</li>
									<li class="col1">
										<div class="contact_list no_pd">
											<textarea class="ta_ty1" placeholder="내용" id="content" name="content"></textarea>
										</div>
									</li>
								</ul>
							</div>
							<div class="termsWrap">
								<strong class="termsTit">개인정보 수집 및 이용에 대한 동의</strong>
								<div class="termsBox">
									<div class="termsBox_inner">
										<p>1. 개인정보의 수집 및 이용목적 <br>
										- 문의사항에 대한 본인 식별 <br>
										- 서비스(문의답변) 제공을 위한 의사소통 채널 확보 </p>

										<p>2. 수집하는 개인정보의 항목 <br>
										- 이름, 연락처, 국가, 이메일, 소속 </p>

										<p>3. 개인정보의 보유 및 이용기간<br>
										- 본 웹사이트 서비스 종료시까지 고객응대를 위해 보관 <br>
										- 본인 요청 시 즉시 삭제</p>

									</div>
								</div>
								<div class="terms_agree">
									<label class="type_checkbox"><input type="checkbox" class="input_hide" name="user_agree" value="Y" required><span class="fake_check"></span> 개인정보 제공에 동의합니다.</label>
								</div>
								<div class="btn_box">
									<input type="submit" id="button_submit" class="btn_round" value="제출하기" >
								</div>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!--// contents -->

		</div>
		<!--//container-->


		<?php include_once $_SERVER['DOCUMENT_ROOT']."/common/include/footer.php"; ?>

	</div>
	<!-- //wrap -->

<?php include_once $_SERVER['DOCUMENT_ROOT']."/common/include/popup.php"; ?>

</body>
</html>