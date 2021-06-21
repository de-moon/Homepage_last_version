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
			<p>Blood-based liquid biopsy is a minimally invasive test for cancer diagnosis that requires a simple blood draw. <br>It has recently risen as a possible substitute for tissue biopsy which includes a surgical procedure to obtain a piece of tumor tissue for analysis. <br>
			The AlphaLiquid® series is an advanced liquid biopsy platform that utilizes IMB Dx’s optimized biochemical technology along <br>with Next Generation Sequencing, as well as AI-based bioinformatic pipeline.</p>
			<?php endif ; ?>
			<?php if($MENU_DEPTH_1 == "TESTS" ) : ?>
			<p class="big" style="max-width: 1000px;">The AlphaLiquid® series is a liquid biopsy platform that utilizes the most advanced tumor profiling technology along with Next Generation Sequencing, providing a comprehensive genomic solution for cancer patients.</p>
			<p style="max-width: 1000px;">AlphaLiquid® testing provides in-depth analysis of cancer-related genetic mutations within approximately 2 weeks from receiving the collected blood specimen. The resulting report assists healthcare professionals in making improved clinical decisions for progressive cancer patients.</p>
			<p style="max-width: 1000px;">The test offers a non-invasive and safer approach compared to tissue biopsy, and thus can be repeated whenever necessary. It can be applied for anticancer drug selection, recurrence monitoring, as well as early cancer detection in the near future.</p>
			<?php endif ; ?>

		</div>
	</div>
	<!--// subvisual area -->

	<?php } ?>
</div>
