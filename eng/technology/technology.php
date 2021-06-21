<?php
include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/commonHeader.php";


// ----------------------------------------------------------------------------------------------------
// ## 공통변수 및 사용자정의변수 정의
// ----------------------------------------------------------------------------------------------------

$MENU_DEPTH_1 = "TECHNOLOGY";
$MENU_DEPTH_2 = "";
$MENU_DEPTH_3 = "";
$MENU_TITLE_1		= "Technology";
$MENU_TITLE_2		= "Advanced liquid biopsy technology for <br class='pc_only'>cancer detection & monitoring";
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

</head>
<body>

<?php include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/skipNav.php"; ?>
	<!-- wrap -->
	<div id="wrap" class="sub">
		<?php include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/top.php"; ?>
		<!--container-->
		<div id="container">
		<?php include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/location.php"; ?>
			<div class="contents">
				<div class="inner">
					<div class="subContWrap">
						<div class="subContSec techSec aniBox type_bot">
							<div class="tabBox">
								<a href="" class="on"><span>UniqSeq®</span></a>
								<a href=""><span>AI-based <br class="mo_only">Bioinformatics </span></a>
								<a href=""><span>Clinical <br class="mo_only">Validation</span></a>
							</div>
							<div class="tabCont taC ty_tech">
								<!-- 생화학적 실험 기술 -->
								<div class="tCont cont1" style="display: block;">
									<div class="img_box img1"><img src="<?=$IMAGES_PATH ?>/contents/icon_tech01.png" alt=""></div>
									<div class="txtBox tech_txt">
										<strong>500% increase in experimental efficiency with statistical models applied</strong>
										<!-- <span>– 통계모델 적용되어 실험 효율성을 극대화 -</span> -->
										<p>IMB Dx’s proprietary UniqSeq® technology allows cancer diagnosis with only trace amount of tumor DNA, through uniform DNA amplification at much higher efficiency than previously done.</p>
									</div>

									<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/info_tech01.png" alt=""></div>
								</div>
								<!-- 인공지능 기반 분석 기술 -->
								<div class="tCont cont2">
									<div class="img_box img1"><img src="<?=$IMAGES_PATH ?>/contents/icon_tech02.png" alt=""></div>
									<div class="txtBox tech_txt">
										<strong>High Analytical Performance </strong>
										<span>99%+ sensitivity, specificity </span>
										<p>IMB Dx’s proprietary AI-driven analysis pipeline aims to build a Big Data system that evolves through constant accumulation of genomic information obtained from our services.<br>
										With this analyzed data, we can provide a personalized genome · epigenome mutational profile along with the most appropriate treatment options for the patient.</p>
									</div>

									<div class="techList col3List">
										<ul>
											<li>
												<div class="txt_box">
													<span>Limit of <br class="mo_only">Detection</span>
													<strong>> 0.1%</strong>
												</div>
											</li>
											<li>
												<div class="txt_box">
													<span>Sensitivity</span>
													<strong>> 99%</strong>
												</div>
											</li>
											<li>
												<div class="txt_box">
													<span>Specificity</span>
													<strong>> 99%</strong>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<!-- 임상검체 분석에 최적화된 기술 -->
								<div class="tCont cont3">
									<div class="img_box img1"><img src="<?=$IMAGES_PATH ?>/contents/icon_tech03.png" alt=""></div>
									<div class="txtBox tech_txt">
										<strong>Clinically validated technology</strong>
										<span>– Accurate detection of <br class="mo_only">genomic · epigenomic <br class="pc_only">mutations of <br class="mo_only">tumor in clinical trial cases -</span>
										<p>We have analyzed over 2000 samples of cancer patients from major hospitals within Korea. These results are currently being utilized for diagnosis and monitoring in clinical settings.</p>
									</div>
									<div class="techInfo">
										<div class="info">
											<div class="info_inner">
												<span>Cumulative # of clinical<br>samples analyzed</span>
												<strong>2,000 +</strong>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--//container-->
		<?php include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/footer.php"; ?>
	</div>
	<!-- //wrap -->

<script>
$(function(){
	$('.tabBox a').click(function(e){
		e.preventDefault();

		var idx = $(this).index();

		$(this).addClass('on').siblings('a').removeClass('on');
		$('.tabCont .tCont').eq(idx).show().siblings('.tCont').hide();
	});
});
</script>
</body>
</html>