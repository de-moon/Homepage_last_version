<!-- privacy policy popup -->
<?php include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/layer_popup.php"; ?>
<!-- privacy policy popup -->

<div id="footer">
	<div class="footer_inner">
		<div class="top_menu">
			<div class="f_logo"><img src="<?=$IMAGES_PATH ?>/common/f_logo.png" alt=""></div>
			<ul>
				<li class=""><a href="<?=$FRONTROOT ?>technology/technology.php">TECHNOLOGY</a></li>
				<li class=""><a href="<?=$FRONTROOT ?>tests/tests.php">TESTS</a></li>
				<li class=""><a href="<?=$FRONTROOT ?>products/products.php">PRODUCTS</a></li>
				<li class=""><a href="<?=$FRONTROOT ?>about/about.php">ABOUT</a></li>
				<li class=""><a href="<?=$FRONTROOT ?>board/news_press/board_list.php">NEWS</a></li>
			</ul>
		</div>
		<div class="bot_menu">
			<!-- <a href="" onclick="open_popup(); return false;">개인정보취급방침</a> -->
			<ul>
				<li>Address : 21F BYC Highcity Bldg A, 131 Gasandigital 1-ro, Geumcheon-gu, Seoul, Republic of Korea 08506</li>
				<li>Copyright ⓒ IMB Dx, Inc.  All Rights Reserved</li>
			</ul>
		</div>
	</div>
	<a  href="" id="scrTop" class="aniBox type_bot"><span>Go top</span></a>
</div>

<?php if ( $SITE_STATE == "RUN" && $GOOGLEANALYTICS != "" ) { ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=?=$GOOGLEANALYTICS ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?=$GOOGLEANALYTICS ?>');
</script>
<?php } ?>

<div <?php if ("::1" != $_SERVER[ 'REMOTE_ADDR']) { ?>style='display:none;'<?php } ?>>
<!--폼 처리용 히튼 프레임 시작-->
<iframe id="frm_hiddenFrame" name="frm_hiddenFrame" frameborder="0" scrolling="no" height="800" width="800" title="내용없음" ></iframe>
<!--폼 처리용 히튼 프레임 종료-->
</div>