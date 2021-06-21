<?php
include_once $_SERVER['DOCUMENT_ROOT']."/common/include/commonHeader.php";


// ----------------------------------------------------------------------------------------------------
// ## 공통변수 및 사용자정의변수 정의
// ----------------------------------------------------------------------------------------------------

$MENU_DEPTH_1 = "TECHNOLOGY";
$MENU_DEPTH_2 = "";
$MENU_DEPTH_3 = "";
$MENU_TITLE_1		= "Technology";
$MENU_TITLE_2		= "액체생검 기반 초정밀 암 진단 기술 ";
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

</head>
<body>

<?php include_once $_SERVER['DOCUMENT_ROOT']."/common/include/skipNav.php"; ?>
	<!-- wrap -->
	<div id="wrap" class="sub">
		<?php include_once $_SERVER['DOCUMENT_ROOT']."/common/include/top.php"; ?>
		<!--container-->
		<div id="container">
		<?php include_once $_SERVER['DOCUMENT_ROOT']."/common/include/location.php"; ?>
			<div class="contents">
				<div class="inner">
					<div class="subContWrap">
						<div class="subContSec techSec aniBox type_bot">
							<div class="tabBox">
								<a href="" class="on"><span>생화학적 <br class="mo_only">실험 기술</span></a>
								<a href=""><span>인공지능 <br class="mo_only">기반 분석 기술</span></a>
								<a href=""><span>임상검체 분석에 <br class="mo_only">최적화된 기술 </span></a>
							</div>
							<div class="tabCont taC ty_tech">
								<!-- 생화학적 실험 기술 -->
								<div class="tCont cont1" style="display: block;">
									<div class="img_box img1"><img src="<?=$IMAGES_PATH ?>/contents/icon_tech01.png" alt=""></div>
									<div class="txtBox tech_txt">
										<strong>500% 향상된 실험 효율성 </strong>
										<span>– 통계모델 적용되어 실험 효율성을 극대화 -</span>
										<p>원천특허 기술인 UniqSeq®의 생화학적 실험 기술을 통해 적은 양의 DNA를 높은 효율로 <br class="pc_only">
										균형있게 증폭하여 기존 검사 대비 효율성 높은 암 진단 검사를 할 수 있습니다. </p>
									</div>

									<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/info_tech01.png" alt=""></div>
								</div>
								<!-- 인공지능 기반 분석 기술 -->
								<div class="tCont cont2">
									<div class="img_box img1"><img src="<?=$IMAGES_PATH ?>/contents/icon_tech02.png" alt=""></div>
									<div class="txtBox tech_txt">
										<strong>높은 분석 정확도</strong>
										<span>– 99% 이상의 민감도, 특이도 -</span>
										<p>자체 개발한 AI기반 분석기술로 검사를 통해 획득한 유전체 정보를 지속적으로 업그레이드하는 진화형 빅데이터 시스템을 구축하고 있습니다. <br>
										이를 통해서 개개인에게 유전체-후성유전체 변이정보와 함께 가장 알맞은 치료제 정보를 제공합니다.</p>
									</div>

									<div class="techList col3List">
										<ul>
											<li>
												<div class="txt_box">
													<span>돌연변이 <br class="mo_only">검출 한계</span>
													<strong>0.1% <br>이상</strong>
												</div>
											</li>
											<li>
												<div class="txt_box">
													<span>민감도</span>
													<strong>99% <br>이상</strong>
												</div>
											</li>
											<li>
												<div class="txt_box">
													<span>특이도</span>
													<strong>99% <br>이상</strong>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<!-- 임상검체 분석에 최적화된 기술 -->
								<div class="tCont cont3">
									<div class="img_box img1"><img src="<?=$IMAGES_PATH ?>/contents/icon_tech03.png" alt=""></div>
									<div class="txtBox tech_txt">
										<strong>임상 검증된 기술 </strong>
										<span>– 실제 임상에서도 암유전체-후성유전체 변이를 정확하게 탐지 -</span>
										<p>국내 유수의 종합병원 암환자 2,000명 이상의 샘플을 분석하였으며, <br class="mo_only">
										이러한 임상 검증을 통해 실제 진단에서 활용하고 있습니다.</p>
									</div>
									<div class="techInfo">
										<div class="info">
											<div class="info_inner">
												<span>누적 임상 검체 <br>분석 건수</span>
												<strong>2,000건 <br>이상</strong>
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
		<?php include_once $_SERVER['DOCUMENT_ROOT']."/common/include/footer.php"; ?>
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