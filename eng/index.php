<?php
include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/commonHeader.php";


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




include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/header.php";
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

<?php include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/skipNav.php"; ?>

	<!-- wrap -->
	<div id="wrap">

		<?php include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/top.php"; ?>

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
								<p>We detect and analyze genomic profile of tumor DNA with a single draw of blood. With this comprehensive profile, we provide personalized and optimized analysis information that can be utilized in therapy selection and monitoring.
								Ultimately, we strive to offer our patients and healthcare professionals a powerful platform for conquering cancer through revolutionizing the way cancer is detected, monitored, and viewed.
								</p>
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
								<p>Our advanced molecular diagnostic technology enables accurate analysis of genomic alterations in cancer-related genes through optimized laboratory and bioinformatic pipeline.
								We use sophisticated analysis methods incorporating Artificial Intelligence technology to analyze clinical Big Data to predict cancer prognosis and treatment response.
								Our continued focus is on developing and improving technologies to better understand cancer.
								</p>
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
											<strong>Therapy Options</strong>
											<p>We offer different anticancer <br>drug treatment options that match the patient’s <br>cancer-related genomic alterations.</p>
										</div>
									</li>
									<li>
										<div class="list-item aniBox2 type_bot delay03">
											<div class="icon_box icon2"></div>
											<strong>Recurrence Monitoring</strong>
											<p>With a simple blood draw, <br>patients can check for possible recurrence <br>prior to going through diagnostic imaging tests.</p>
										</div>
									</li>
									<li>
										<div class="list-item aniBox2 type_bot delay04">
											<div class="icon_box icon3"></div>
											<strong>Early Detection</strong>
											<p>Early detection is possible <br>through advanced pattern <br>analysis of genomic mutations.</p>
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
									<strong>Talk to your doctor & <br>fill out <br class="pc_only">our service form</strong>
									<em class="dot"></em>
								</div>
							</li>
							<li>
								<div class="list-item aniBox2 type_bot delay03">
									<div class="img_box"><img src="<?=$IMAGES_PATH ?>/main/icon_ms3-2.png" alt=""></div>
									<span class="num">2</span>
									<strong>Blood draw</strong>
									<em class="dot"></em>
								</div>
							</li>
							<li>
								<div class="list-item aniBox2 type_bot delay04">
									<div class="img_box"><img src="<?=$IMAGES_PATH ?>/main/icon_ms3-3.png" alt=""></div>
									<span class="num">3</span>
									<strong>Genomic analyses <br>performed at IMBDx</strong>
									<em class="dot"></em>
								</div>
							</li>
							<li>
								<div class="list-item aniBox2 type_bot delay05">
									<div class="img_box"><img src="<?=$IMAGES_PATH ?>/main/icon_ms3-4.png" alt=""></div>
									<span class="num">4</span>
									<strong>Doctor consultation <br>for result review</strong>
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
											<span class="essen">Name</span>
											<input type="text" class="input" id="etc_3" name="etc_3" required>
										</div>
									</li>
									<li>
										<div class="contact_list">
											<span class="essen">Phone</span>
											<input type="text" class="input" id="etc_5" name="etc_5" required>
										</div>
									</li>
									<li>
										<div class="contact_list">
											<span class="essen">Country</span>
											<input type="text" class="input" id="etc_2" name="etc_2" required>
										</div>
									</li>
									<li>
										<div class="contact_list">
											<span class="essen">E-mail</span>
											<input type="text" class="input" id="etc_6" name="etc_6" required>
										</div>
									</li>
									<li>
										<div class="contact_list">
											<span class="essen">Company name</span>
											<input type="text" class="input" id="etc_1" name="etc_1" required>
										</div>
									</li>
									<li>

										<div class="contact_list no_pd">
											<select name="etc_4" id="etc_4" class="select">
												<option value="-" selected>Topic of Interest</option>
												<option value="AL-10(Colon)">AL-10(Colon)</option>
												<option value="AL-100">AL-100</option>
												<option value="AL-1000">AL-1000</option>
												<option value="AL-Screening">AL-Screening</option>
												<option value="AL Tube">AL Tube</option>
												<option value="Etc.">Etc.</option>
											</select>
										</div>
									</li>
									<li class="col1">
										<div class="contact_list no_pd">
											<textarea class="ta_ty1" placeholder="Content" id="content" name="content"></textarea>
										</div>
									</li>
								</ul>
							</div>
							<div class="termsWrap">
								<!-- <strong class="termsTit">개인정보 수집 및 이용에 대한 동의</strong>
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
								</div> -->
								<div class="btn_box">
									<input type="submit" id="button_submit" class="btn_round" value="Submit" >
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


		<?php include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/footer.php"; ?>

	</div>
	<!-- //wrap -->

<?php include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/popup.php"; ?>

</body>
</html>