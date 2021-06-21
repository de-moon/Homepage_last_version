<?php
include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/commonHeader.php";


// ----------------------------------------------------------------------------------------------------
// ## 공통변수 및 사용자정의변수 정의
// ----------------------------------------------------------------------------------------------------

$MENU_DEPTH_1 = "PRODUCTS";
$MENU_DEPTH_2 = "";
$MENU_DEPTH_3 = "";
$MENU_TITLE_1		= "Products";
$MENU_TITLE_2		= "AlphaLiquid®";
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
			<div class="contents ty_products">
				<div class="inner">
					<div class="subContWrap prodWrap">
						<div class="subContSec">
							<div class="prd-item item aniBox type_bot1">
								<div class="prdTit taC">
									<strong>The AlphaLiquid® Series</strong>
								</div>
								<div class="tblArea">
									<table>
										<colgroup>
											<col width="20%">
											<col>
											<col>
											<col>
											<col>
											<col>
										</colgroup>
										<thead>
											<tr>
												<th></th>
												<th>AlphaLiquid® <br>10</th>
												<th>AlphaLiquid® <br>100 </th>
												<th>AlphaLiquid® <br>1000</th>
												<th>AlphaLiquid® <br>Screening</th>
												<th>AlphaLiquid® <br>MRD</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Companion diagnostics</td>
												<td><span class="circle"></span></td>
												<td><span class="circle"></span></td>
												<td><span class="circle"></span></td>
												<td><span class="circle"></span></td>
												<td><span class="circle"></span></td>
											</tr>
											<tr>
												<td>Recurrence & metastasis <br class="mo_only">monitoring</td>
												<td><span class="circle"></span></td>
												<td><span class="circle"></span></td>
												<td><span class="circle"></span></td>
												<td><span class="circle"></span></td>
												<td><span class="circle"></span></td>
											</tr>
											<tr>
												<td>Biomarker discovery</td>
												<td></td>
												<td><span class="circle"></span></td>
												<td><span class="circle"></span></td>
												<td></td>
												<td></td>
											</tr>
											<tr>
												<td>Early diagnosis</td>
												<td></td>
												<td></td>
												<td></td>
												<td><span class="circle"></span></td>
												<td></td>
											</tr>
											<tr>
												<td>Personalized residual <br class="mo_only">disease monitoring</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td><span class="circle"></span></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>

							<div class="prd-item item2 aniBox type_bot">
								<div class="prdSpecial">
									<div class="left">
										<ul>
											<li><span>AlphaLiquid®<br>10</span></li>
											<li><span>AlphaLiquid®<br>100</span></li>
											<li><span>AlphaLiquid®<br>1000</span></li>
										</ul>
										<div class="txt_box">
											<p>Treatment selection</p>
											<p>Recurrence monitoring</p>
										</div>
									</div>
									<div class="right">
										<div class="img_box">
											<img src="<?=$IMAGES_PATH ?>/contents/img_prd1.png" alt="">
											<span>AlphaLiquid® <br>Screening </span>
										</div>
										<div class="txt_box">
											<p>Early detection</p>
										</div>
									</div>
									<div class="right">
										<div class="img_box">
											<img src="<?=$IMAGES_PATH ?>/contents/img_prd1.png" alt="">
											<span>AlphaLiquid® <br>MRD </span>
										</div>
										<div class="txt_box">
											<p>Personalized residual <br class="mo_only">disease monitoring</p>
										</div>
									</div>
								</div>
							</div>

							<div class="prd-item item3 aniBox type_bot">
								<!-- AlphaLiquid®10(Colon) -->
								<div class="prd-info">
									<div class="detail_box">
										<strong>AlphaLiquid®10(Colon)</strong>
										<ul class="bulList txtBox">
											<li>AlphaLiquid®10 is designed to detect mutations in 10 colorectal cancer-related genes. </li>
											<li>It can be used in companion diagnostics to provide information on whether recurrence or metastasis might be occurring after treatment.</li>
										</ul>
									</div>
									<div class="spec_box">
										<ul>
											<li>
												<div class="spec-list">
													<div class="list-inner">
														<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_prd-spec1.png" alt=""></div>
														<strong>Target cancer</strong>
														<p>Colorectal cancer</p>
													</div>
												</div>
											</li>
											<li>
												<div class="spec-list">
													<div class="list-inner">
														<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_prd-spec2.png" alt=""></div>
														<strong>Detectable mutations</strong>
														<p>SNV, Indel</p>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<!-- AlphaLiquid®100  -->
								<div class="prd-info ty_blue">
									<div class="detail_box">
										<strong>AlphaLiquid®100 </strong>
										<ul class="bulList txtBox">
											<li>AlphaLiquid®100 tests for variations in 106 guideline-recommended, cancer-related genes.</li>
											<li>It provides information about which anticancer drug associated with each gene, any clinical trial being conducted, and the type of mutations (SNV, Indel, CNV, fusion, as well as MSI) that occurred.</li>
										   <li>It can be used in companion diagnostics to detect and monitor signs of relapse and/or metastasis after beginning anticancer drug therapy.</li>
										</ul>
									</div>
									<div class="spec_box">
										<ul>
											<li>
												<div class="spec-list">
													<div class="list-inner">
														<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_prd-spec3.png" alt=""></div>
														<strong>Target cancers</strong>
														<p>Colorectal, lung, breast, ovarian, pancreatic, stomach, liver, skin cancer</p>
													</div>
												</div>
											</li>
											<li>
												<div class="spec-list">
													<div class="list-inner">
														<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_prd-spec4.png" alt=""></div>
														<strong>Detectable mutations</strong>
														<p>SNV, Indel, CNV, fusion, MSI(microsatellite instability)</p>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<!-- AlphaLiquid®1000 -->
								<div class="prd-info">
									<div class="detail_box">
										<strong>AlphaLiquid®1000</strong>
										<ul class="bulList txtBox">
											<li>AlphaLiquid®1000 is a pan-cancer assay for almost all known types of solid cancer patients, designed to examine more than a 1000 genes related to different cancers at once.</li>
											<li>It, too, can be used in companion diagnostics to detect and monitor signs of relapse and/or metastasis after beginning anticancer drug therapy.</li>
										</ul>
									</div>
									<div class="spec_box">
										<ul>
											<li>
												<div class="spec-list">
													<div class="list-inner">
														<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_prd-spec1.png" alt=""></div>
														<strong>Target cancers</strong>
														<p class="sameHeight">Colorectal, lung, breast, ovarian, stomach, pancreatic, prostate, brain, skin, thyroid, and most other cancers</p>
													</div>
												</div>
											</li>
											<li>
												<div class="spec-list">
													<div class="list-inner">
														<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_prd-spec2.png" alt=""></div>
														<strong>Detectable mutations</strong>
														<p class="sameHeight">SNV, Indel, fusion, CNV, MSI
														+
														TMB(tumor mutational burden)</p>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<!-- AlphaLiquid®Screening   -->
								<div class="prd-info ty_blue">
									<div class="detail_box">
										<strong>AlphaLiquid®Screening </strong>
										<ul class="bulList txtBox">
											<li>AlphaLiquid®Screening is able to detect cancer faster than imaging tests such as CT or MRI scan.</li>
											<li>It is designed to screen and detect cancer early by identifying where the cancer first originated in the body.</li>
										   <li>This allows the doctor to begin treatment at an earlier stage which increases the patient’s chances of survival.</li>
										</ul>
									</div>
									<div class="spec_box">
										<ul>
											<li>
												<div class="spec-list">
													<div class="list-inner">
														<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_prd-spec5.png" alt=""></div>
														<strong>Designed for</strong>
														<p>Cancer patients & healthy people</p>
													</div>
												</div>
											</li>
											<li>
												<div class="spec-list">
													<div class="list-inner">
														<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_prd-spec6.png" alt=""></div>
														<strong>Detectable variation</strong>
														<p>Changes in DNA methylation pattern</p>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<!-- AlphaLiquid®MRD -->
								<div class="prd-info">
									<div class="detail_box">
										<strong>AlphaLiquid®MRD</strong>
										<ul class="bulList txtBox">
											<li>AlphaLiquid®MRD is designed as a personalized tracking & monitoring test for cancer patients.</li>
											<li>It evaluates each individual patient’s mutational
											profile to search for residual tumor remaining in
											the patient after therapy, allowing fast and
											accurate detection of a possible relapse of cancer.</li>
										</ul>
									</div>
									<div class="spec_box">
										<ul>
											<li>
												<div class="spec-list">
													<div class="list-inner">
														<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_prd-spec1.png" alt=""></div>
														<strong>Target cancers</strong>
														<p class="sameHeight">Colorectal, lung, breast,
														ovarian, stomach,
														pancreatic, prostate,
														brain, skin, thyroid, and
														most other cancers</p>
													</div>
												</div>
											</li>
											<li>
												<div class="spec-list">
													<div class="list-inner">
														<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_prd-spec2.png" alt=""></div>
														<strong>Detectable biomarker</strong>
														<p class="sameHeight">Minimal Residual Disease(MRD)</p>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<!-- AlphaLiquid Tube™ -->
								<div class="prd-info ty_tube">
									<div class="detail_box">
										<strong>AlphaLiquid Tube™</strong>
										<ul class="bulList txtBox">
											<li>AlphaLiquid  Tube™ is a tube developed for convenient collection and storage of blood, as well as for effective cfDNA extraction. Collected blood can be stored in room temperature for up to 10 days.</li>
											<li>AlphaLiquid  Tube™ is made of break-resistant material, so there is lower risk of damage and/or leakage of sample during shipment.</li>
										</ul>
									</div>
									<div class="spec_box">
										<div class="img_box"><img src="<?=$IMAGES_PATH ?>/contents/img_prd-spec1.jpg" alt=""></div>
									</div>
								</div>

								<div class="btn_box">
									<a href="<?=$FRONTROOT ?>#contactUs" class="btn_round">In detail</a>
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

});
</script>
</body>
</html>