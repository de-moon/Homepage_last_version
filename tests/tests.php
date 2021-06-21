<?php
include_once $_SERVER['DOCUMENT_ROOT']."/common/include/commonHeader.php";


// ----------------------------------------------------------------------------------------------------
// ## 공통변수 및 사용자정의변수 정의
// ----------------------------------------------------------------------------------------------------

$MENU_DEPTH_1 = "TESTS";
$MENU_DEPTH_2 = "";
$MENU_DEPTH_3 = "";
$MENU_TITLE_1		= "Tests";
$MENU_TITLE_2		= "AlphaLiquid® 검사";
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

						<!-- sec1 -->
						<div class="subContSec testSec_top aniBox type_bot">
							<div class="subTit aniBox">
								<strong>특징</strong>
							</div>

							<div class="testSpecial">
								<div class="imgArea img_box"><img src="<?=$IMAGES_PATH ?>/contents/img_test01.jpg" alt=""></div>
								<div class="txtArea">
									<ul>
										<li>
											<div class="txt-list">
												<span>1</span>
												<strong>혁신적인 혈액 내 종양
												유전체 분석 기술 적용</strong>
											</div>
										</li>
										<li>
											<div class="txt-list">
												<span>2</span>
												<strong>세계 최고수준의 분석적
												성능과 임상적 유의성</strong>
											</div>
										</li>
										<li>
											<div class="txt-list">
												<span>3</span>
												<strong>대규모 임상시험을 통해
												검증된 안정성과 활용도</strong>
											</div>
										</li>
										<li>
											<div class="txt-list">
												<span>4</span>
												<strong>높은 가격 경쟁력</strong>
											</div>
										</li>
									</ul>
								</div>
							</div>

							<div class="testList">
								<ul>
									<li>
										<div class="list-item">
											<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_test01.png" alt=""></div>
											<div class="txt_box">
												<p>논문 <strong>10건+</strong></p>
											</div>
										</div>
									</li>
									<li>
										<div class="list-item">
											<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_test02.png" alt=""></div>
											<div class="txt_box">
												<p>특허 <strong>6건+</strong></p>
											</div>
										</div>
									</li>
									<li>
										<div class="list-item">
											<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_test03.png" alt=""></div>
											<div class="txt_box">
												<p>협력병원 <strong>10기관+</strong></p>
											</div>
										</div>
									</li>
									<li>
										<div class="list-item">
											<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_test04.png" alt=""></div>
											<div class="txt_box">
												<p>임상시험 <strong>30건+</strong></p>
											</div>
										</div>
									</li>
									<li>
										<div class="list-item">
											<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_test05.png" alt=""></div>
											<div class="txt_box">
												<p>임상검체 분석 <strong>2000건+</strong></p>
											</div>
										</div>
									</li>
									<li>
										<div class="list-item">
											<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_test06.png" alt=""></div>
											<div class="txt_box">
												<p>식약처 체외진단기기 <br>인증 진행</p>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>

						<!-- sec2 -->
						<div class="subContSec testSec_mid aniBox type_bot">
							<div class="subTit aniBox no_mgb">
								<strong>검사 및 분석 과정</strong>
							</div>
							<div class="testStep">
								<span class="testInfo img_box"><img src="<?=$IMAGES_PATH ?>/contents/img_test02.png" alt=""></span>

								<div class="step step1 ty_right aniBox type_bot">
									<div class="step_inner">
										<div class="icon_box img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_test02-1.png" alt=""></div>
										<strong>혈액 검체 수집</strong>
										<ul class="bulList txtBox">
											<li>혈액 20ml (10ml X 2)</li>
											<li>전용 용기 상온보관(AlphaLiquid Tube™)</li>
										</ul>
									</div>
								</div>

								<div class="step step2 ty_left aniBox type_bot">
									<div class="step_inner">
										<div class="icon_box img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_test02-2.png" alt=""></div>
										<strong>UniqSeq® & NGS</strong>
										<ul class="bulList txtBox">
											<li>혈액 속 미량의 ctDNA를 UniqSeq®
											기술로 감지하여 차세대
											염기서열분석수행</li>
										</ul>
									</div>
								</div>

								<div class="step step3 ty_right aniBox type_bot">
									<div class="step_inner">
										<div class="icon_box img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_test02-3.png" alt=""></div>
										<strong>UniqSeq® 분석</strong>
										<ul class="bulList txtBox">
											<li>UniqSeq® 분석 파이프라인으로 정밀한
											SNV, Indel, fusion, CNV, MSI, TMB 분석 진행</li>
										</ul>
									</div>
								</div>

								<div class="step step4 ty_left aniBox type_bot">
									<div class="step_inner">
										<div class="icon_box img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_test02-4.png" alt=""></div>
										<strong>임상 결과 제공</strong>
										<ul class="bulList txtBox">
											<li>검출된 변이에 대한 치료제 옵션 제공</li>
											<li>정량적 변이 비율 안내</li>
										</ul>
									</div>
								</div>

							</div>
							<p class="lapse">10 Days</p>
						</div>

						<!-- sec3 -->
						<div class="subContSec testSec_bot aniBox type_bot">
							<div class="testTargetWrap">
								<div class="targetTit">
									<strong>AlphaLiquid®는 진행중인 고형암 환자를 위한 <br>
									고정밀 액체생검입니다.</strong>
									<p>한 번의 혈액 채취로 주요 암과 관련된 유전자의 돌연변이를 검사합니다. <br>
									항암제의 효과나 암의 재발 여부를 조기에 확인하여 암 모니터링 및 치료 옵션 변경에 도움을 드립니다.</p>
								</div>

								<div class="targetTop">
									<strong>검사 추천 대상</strong>
								</div>
								<div class="targetCont cont1">
									<div class="target2Col">
										<div class="col col-img img_box"><img src="<?=$IMAGES_PATH ?>/contents/img_test03.jpg" alt=""></div>
										<div class="col col-txt">
											<ul>
												<li>침습적인 조직생검을 하기 어려운 환자분</li>
												<li>종양 조직을 얻을 수 없는 환자분</li>
												<li>보관된 조직 또는 검사 결과가 오래된 환자분</li>
												<li>조직생검에서 하나 이상의 중요한 유전자 변이가 발견된 환자분 </li>
												<li>단일 유전자 검사만으로는 진단이나 치료가 어려운 환자분</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="targetCont cont2">
									<div class="qnaWrap">
										<!-- Q1 -->
										<div class="qna_box">
											<div class="qBox">
												<span class="unna">Q</span>AlphaLiquid® 검사는 임상적으로 어떻게 활용되나요?
											</div>
											<div class="aBox">
												<span class="unna">A</span>
												<strong>조직생검으로 관찰하기 어려운 부분도 정밀한 확인이 가능합니다. </strong>
												<p class="txtBox">암세포가 진화하는 과정에서 어떤 양상을 보이는지 추적하여 항암제의 선택과 변경에 있어 도움을 드릴 수 있습니다. <br>
												또한, 미세잔존질환(MRD)이라 불리는 치료 이후 혈액 내 존재하는 미량의 암을 초기에 발견하여 재발 위험에 대비할 수 있습니다.</p>
												<div class="tblArea">
													<table>
														<colgroup>
															<col width="33.333%">
															<col width="33.333%">
															<col width="33.333%">
														</colgroup>
														<thead>
															<tr>
																<th></th>
																<th>조직생검</th>
																<th>액체생검</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>치료제 반응성 모니터링</td>
																<td><span class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_no.png" alt=""></span></td>
																<td><span class="circle"></span></td>
															</tr>
															<tr>
																<td>치료제 저항성의 조기 발견</td>
																<td><span class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_no.png" alt=""></span></td>
																<td><span class="circle"></span></td>
															</tr>
															<tr>
																<td>재발이나 MRD의 조기 진단</td>
																<td><span class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_no.png" alt=""></span></td>
																<td><span class="circle"></span></td>
															</tr>
															<tr>
																<td>암세포의 진화 추적</td>
																<td><span class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_no.png" alt=""></span></td>
																<td><span class="circle"></span></td>
															</tr>
															<tr>
																<td>암의 조기 진단</td>
																<td><span class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_no.png" alt=""></span></td>
																<td><span class="circle"></span></td>
															</tr>
														</tbody>
													</table>
													<p class="taR desc">자료 출처: Heitzer et al., 2019 Nat Rev Genet</p>
												</div>
											</div>
										</div>
										<!-- Q2 -->
										<div class="qna_box">
											<div class="qBox">
												<span class="unna">Q</span>AlphaLiquid® 검사는 어떤 장점이 있나요?
											</div>
											<div class="aBox">
												<span class="unna">A</span>
												<ul>
													<li><span>1.</span>조직검사에 따른 출혈과 통증 등 합병증 없이 암 진단이 가능합니다.</li>
													<li><span>2.</span>항암치료 효과를 그 어느 검사보다 자세히 알 수 있습니다.</li>
													<li><span>3.</span>항암치료 중 발생하는 내성 기전을 밝혀서 암치료의 효과를 극대화합니다. </li>
													<li><span>4.</span>수술 후 재발 여부를 가장 빨리 알 수 있습니다.</li>
													<li><span>5.</span>암을 조기진단하고 검진하는 새로운 획기적인 검사법입니다.</li>
												</ul>
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
	/*
	$('.qna_box .qBox').click(function(){
		if( $(this).parent().hasClass('on') ){
			$(this).parent().removeClass('on');
			$(this).parent().find('.aBox').stop().slideUp(350);
		}else{
		//	$('.qna_box').removeClass('on');
			$(this).parent().addClass('on');
		//	$('.qna_box .aBox').stop().slideUp();
			$(this).parent().find('.aBox').stop().slideDown(350);
		}
	});*/
});
</script>
</body>
</html>