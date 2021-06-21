<?php
$var_SQL = " SELECT ";
$var_SQL .= "   A.POPUP_SEQ, A.DIVISION, A.ORDER_NUM, A.SUBJECT, A.CONTENT ";
$var_SQL .= " , A.INPUT_TYPE, A.LINK_URL, A.LINK_URL_MOBILE, A.LINK_TARGET ";
$var_SQL .= " , A.START_DATE, A.END_DATE, A.VIEW_YN, A.REGISTER_IP ";
$var_SQL .= " , A.DEL_YN, A.LANGUAGE_TYPE, A.MOD_DATE, A.REG_DATE ";
$var_SQL .= " , ( SELECT CONCAT(CONCAT(FILE_PATH, '/'), FILE_SAVE) FROM TB_POPUP_FILE B WHERE A.POPUP_SEQ = B.POPUP_SEQ) AS FILE_NAME ";
$var_SQL .= " FROM TB_POPUP A ";
$var_SQL .= " WHERE A.DEL_YN= 'N' AND A.DIVISION = 'POPUP' ";
$var_SQL .= " AND A.VIEW_YN = 'Y' AND A.START_DATE <= now() AND A.END_DATE >= now() AND A.LANGUAGE_TYPE = '{$SITE_LANGUAGE}' ";
$var_SQL .= " ORDER BY ORDER_NUM, A.POPUP_SEQ DESC ";
$result = $mod->select($pdo, $var_SQL, "");
$cnt = $result->rowCount();
?>

<?php If($cnt > 0){ ?>

<link rel="stylesheet" href="">
<style type="text/css">

/* 슬라이드팝업 */
.slide_popup .popup_layer_wrap a{position: static;}
.slide_popup .popupBtn a{float: left;width: 50%;}
.slide_popup .popupBtn a:last-child{width: 100%;}


.popup_layer{position: absolute; top: 40px; z-index: 999999; visibility: hidden; left: 40px; max-width:485px; }
.popup_layer > a{text-indent: -9999px;position: absolute;width: 26px;height: 26px;background-image: url(<?=$IMAGES_PATH ?>/common/btn_close_pop.png);background-repeat: no-repeat;-webkit-background-size: cover;
background-size: cover;right:8px;top:8px;cursor:pointer;z-index: 999;}
.popup_layer > a.posL {left:8px;}
.popup_layer .close_pop{background-color: #a5a5a5c4;padding: 0 10px;}
.popup_layer .close_pop a{display: block;font-size: 14px;line-height: 30px;color: #fff;}
.popup_layer .close_pop #check{line-height: 30px;color: #fff;}
.popup_layer_wrap{position: relative;}


.popup_layer .slick-slide {max-height: 540px;text-align: center;background-color: #000;}
.popup_layer .slick-slide img {display: inline-block;vertical-align: top;max-width:100%}
.popup_layer .slick-dots{display:block !important;margin:0;position:static;background-color:#7e7e7e5c;text-align:center;}
.popup_layer .slick-dots li {display: inline-block;margin:5px;}
.popup_layer .slick-dots li button:before{display:none;}
.popup_layer .slick-dots li.slick-active button:before{display:none;}
.popup_layer .slick-dots li button{background-color:#FFF;border-radius:100%;padding:0;width:12px;height:12px;text-indent:-999px;}
.popup_layer .slick-dots li.slick-active button{background-color:#df375b;}
/*
.popup_layer_wrap p {color:#e00101; font-size:25px; font-weight:bold; position:absolute; top:23px; right:40px;}
*/
.popup_layer .slick-slide span {display: block;}
.popup_layer .slick-slide span * {max-width:100%}

@media screen and (max-width: 767px){
	.popup_layer {width: auto;left: 15px;right: 15px;top: 50px;}
}


</style>

<div id="main_layer_popup" class="popup_layer slide_popup" style="visibility:hidden;">
	<a href="javascript:closePop('main_layer_popup_close');" onclick="closePop('main_layer_popup_close');">닫기</a>
	<div class="popupSliderWrap" style="overflow:hidden">
		<div class="popupSlider" >
		<?php
			for ($i = 0; $i < $cnt; $i++) {
				$row = $result->fetch(PDO::FETCH_ASSOC);

				if ( $row['INPUT_TYPE'] == "I" ) {
		?>
			<div class="popupSlideritem" style="vertical-align:top;">
				<div class="popup_layer_wrap">
					<span>
						<?php If ( $row['LINK_URL'] != "" && $row['LINK_URL'] != "http://" ) { ?><a href="<?=$row['LINK_URL'] ?>" target="<?=$row['LINK_TARGET'] ?>"><?php } else { ?><a href="#"><?php } ?>
						<?php if ( $row['FILE_NAME'] != "" ) { ?><img src="<?=$UPLOAD_PATH . $row['FILE_NAME'] ?>" alt="<?=$row['SUBJECT'] ?>"><?php } ?>
						</a>
					</span>
				</div>
			</div>
		<?php
				} else {
		?>
			<div class="popupSlideritem" style="vertical-align:top;">
				<div class="popup_layer_wrap">
					<span>
						<?=$row['CONTENT'] ?>
					</span>
				</div>
			</div>
		<?php
				}
			}
		?>
		</div>
	</div>
	<div class="close_pop clearfix">
		<form name="pop_form">
			 <div id="check" style="float: left;"><label><input type="checkbox" name="main_layer_popup_close" id="main_layer_popup_close" value="checkbox" style="margin-right:5px;" onclick="closePop('main_layer_popup_close');">오늘 하루동안 보지 않기</label></div>
			<div id="close" style="float: right;" ><a href="javascript:closePop('main_layer_popup_close');" class="">닫기</a></div>
		</form>
	</div>
</div>


<script language="JavaScript">

function closePop(sName) {
	if ( IsChecked(document.getElementById(sName)) ){
		setCookie( sName, "done" , 1 );
	}
	if (sName == "main_layer_popup_close") document.all['main_layer_popup'].style.visibility = "hidden";
}

$(function(){
	$(window).on('load',function(){
		$('.popupSlider').slick({
			dots: true,
			infinite: true,
			//variableWidth: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			autoplay: true,
			autoplaySpeed: 6000,
			adaptiveHeight: true
		});

		cookiedata = document.cookie;
		if ( cookiedata.indexOf("main_layer_popup_close=done") < 0 ){
			document.all['main_layer_popup'].style.visibility = "visible";
		} else {
			document.all['main_layer_popup'].style.visibility = "hidden";
		}
	});
});

</script>

<?php } ?>
