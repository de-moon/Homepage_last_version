<?php if($MENU_DEPTH_1 != '' && $MENU_DEPTH_1 != null){ ?>
<div class="subVIsualWrap aniBox <?=$MENU_DEPTH_1 ?>">

	<!-- subvisual area -->
	<div class="subVisual aniBox <?=$MENU_DEPTH_1 ?>"></div>

	<div class="subVisualTxt aniBox type_bot">
		<div class="sv_icon img_box"><img src="<?=$IMAGES_PATH ?>/contents/icon_dna.png" alt=""></div>
		<div class="subVisualTxt_inner aniBox type_bot">
			<strong class=""><?=$MENU_TITLE_1 ?></strong>
			<span><?=$MENU_TITLE_2 ?></span>

			<?php if($MENU_DEPTH_1 == "TECHNOLOGY" ) : ?>
			<p>혈액 액체생검은 수술 없이 채혈만으로 암을 진단하는 기술로, 수술이나 시술을 통해 샘플을 획득해야 하는 조직생검의 대안으로 크게 주목받고 있습니다. <br>
			IMB Dx의 액체생검 기술은 최적화된 생화학적 실험 기술과 인공지능 기반 분석 기술, 임상검체 분석에 최적화된 기술이 적용된 초정밀 생물정보학 파이프라인이 <br>
			융합된 기술로 가격과 성능 모두를 만족시키는 최고급 액체생검 플랫폼입니다. </p>
			<?php endif ; ?>
			<?php if($MENU_DEPTH_1 == "TESTS" ) : ?>
			<p class="big">AlphaLiquid®는 차세대염기서열분석 기반의 가장 진보된 <br>암유전자변이 검출기술이 적용된 액체생검 통합 솔루션입니다.</p>
			<p>AlphaLiquid®은 채취된 혈액에서부터 약 2주 만에 전문적이고 종합적인 암유전자 변이 프로파일링 <br>
			결과 리포트를 임상의사들께 제공함으로써 더욱 정확한 임상적 결정을 내릴 수 있도록 도와드립니다.</p>
			<p>조직생검에 비해 안전하기 때문에 반복적 검사가 가능하며 초기 암 진단, 약제선정 및 <br>암 모니터링 등에 활용됩니다.</p>
			<?php endif ; ?>

		</div>
	</div>
	<!--// subvisual area -->

	<?php } ?>
</div>
