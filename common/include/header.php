<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
	<title><?=$SEO_TITLE ?></title>
	<?php If ($SEO_KEYWORDS != "") { ?><meta name="keywords" content="<?=$SEO_KEYWORDS ?>" /><?php } ?>
	<?php If ($SEO_DESCRIPTION != "") { ?><meta name="Description" content="<?=$SEO_DESCRIPTION ?>" /><?php } ?>
	<?php If ($SITE_FAVICON != "") { ?><link rel="shortcut icon" href="<?=$SITE_FAVICON ?>"><?php } ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no, target-densitydpi=medium-dpi" name="viewport" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<link rel="stylesheet" href="<?=$COMMON_PATH?>/css/common.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?=$COMMON_PATH?>/js/slick.min.js"></script>
	<script type="text/javascript" src="<?=$COMMON_PATH?>/js/swiper.min.js"></script>
	<script type="text/javascript" src="<?=$COMMON_PATH?>/js/common.js"></script>
	<script type="text/javascript" src="<?=$COMMON_PATH?>/js/_basicFunction.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-180313080-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-180313080-1');
	</script>