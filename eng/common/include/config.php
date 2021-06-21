<?php

// ----------------------------------------------------------------------------------------------------
// ## PHP 설정
// ----------------------------------------------------------------------------------------------------

// https://www.php.net/manual/en/errorfunc.constants.php
//error_reporting(0);
error_reporting(E_ALL);
//error_reporting(E_ERROR | E_PARSE);

// 보안설정이나 프레임이 달라도 쿠키가 통하도록 설정
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');

//php 최대 실행시간을 제한한다.
//php.ini에 max_execution_time 값
//초단위이며 0이면 무제한
if (!isset($set_time_limit)) $set_time_limit = 0;
@set_time_limit($set_time_limit);

// 짧은 환경변수를 지원하지 않는다면
// 짧은 변수로 사용할 전역변수를 세팅
if (isset($HTTP_POST_VARS) && !isset($_POST)) {
	$_POST   = &$HTTP_POST_VARS;
	$_GET    = &$HTTP_GET_VARS;
	$_SERVER = &$HTTP_SERVER_VARS;
	$_COOKIE = &$HTTP_COOKIE_VARS;
	$_ENV    = &$HTTP_ENV_VARS;
	$_FILES  = &$HTTP_POST_FILES;

	if (!isset($_SESSION))
		$_SESSION = &$HTTP_SESSION_VARS;
}

// 인젝션 공경 보안
// php.ini 의 magic_quotes_gpc 값이 FALSE 인 경우 addslashes() 적용
// SQL Injection 등으로 부터 보호
// 재귀함수로 재구성
if( !get_magic_quotes_gpc() ) {
	function siteQuotesDel(&$data) {
		if( is_array($data) ){
			foreach($data as $k => $v){
				if( is_array($data[$k]) ) {
					siteQuotesDel($data[$k]);
				} else {
					$data[$k] = addslashes($v);
				}
			}
			@reset($data);
		}
	}
	siteQuotesDel($_GET);
	//siteQuotesDel($_POST);
	siteQuotesDel($_COOKIE);
}


//==========================================================================================================================
// XSS(Cross Site Scripting) 공격에 의한 데이터 검증 및 차단
//--------------------------------------------------------------------------------------------------------------------------
function xss_clean($data)
{
    // If its empty there is no point cleaning it :\
    if(empty($data))
        return $data;

    // Recursive loop for arrays
    if(is_array($data))
    {
        foreach($data as $key => $value)
        {
            $data[$key] = xss_clean($value);
        }

        return $data;
    }

    // http://svn.bitflux.ch/repos/public/popoon/trunk/classes/externalinput.php
    // +----------------------------------------------------------------------+
    // | Copyright (c) 2001-2006 Bitflux GmbH                                 |
    // +----------------------------------------------------------------------+
    // | Licensed under the Apache License, Version 2.0 (the "License");      |
    // | you may not use this file except in compliance with the License.     |
    // | You may obtain a copy of the License at                              |
    // | http://www.apache.org/licenses/LICENSE-2.0                           |
    // | Unless required by applicable law or agreed to in writing, software  |
    // | distributed under the License is distributed on an "AS IS" BASIS,    |
    // | WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or      |
    // | implied. See the License for the specific language governing         |
    // | permissions and limitations under the License.                       |
    // +----------------------------------------------------------------------+
    // | Author: Christian Stocker <chregu@bitflux.ch>                        |
    // +----------------------------------------------------------------------+

    // Fix &entity\n;
    $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);

    if (function_exists("html_entity_decode"))
    {
        //$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
        $data = html_entity_decode($data);
    }
    else
    {
        $trans_tbl = get_html_translation_table(HTML_ENTITIES);
        $trans_tbl = array_flip($trans_tbl);
        $data = strtr($data, $trans_tbl);
    }

    // Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

    // Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

    // Remove namespaced elements (we do not need them)
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do
    {
        // Remove really unwanted tags
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    }
    while ($old_data !== $data);

    return $data;
}

/*
foreach($_GET as $key=>$value) {
    $_GET[$key] = xss_clean($value);
}
*/

$_GET = xss_clean($_GET);
//==========================================================================================================================


//==========================================================================================================================
// extract($_GET); 명령으로 인해 page.php?_POST[var1]=data1&_POST[var2]=data2 와 같은 코드가 _POST 변수로 사용되는 것을 막음
// 081029 : letsgolee 님께서 도움 주셨습니다.
//--------------------------------------------------------------------------------------------------------------------------
$ext_arr = array ('PHP_SELF', '_ENV', '_GET', '_POST', '_FILES', '_SERVER', '_COOKIE', '_SESSION', '_REQUEST',
                  'HTTP_ENV_VARS', 'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_POST_FILES', 'HTTP_SERVER_VARS',
                  'HTTP_COOKIE_VARS', 'HTTP_SESSION_VARS', 'GLOBALS');
$ext_cnt = count($ext_arr);
for ($i=0; $i<$ext_cnt; $i++) {
    // GET 으로 선언된 전역변수가 있다면 unset() 시킴
    if (isset($_GET[$ext_arr[$i]])) unset($_GET[$ext_arr[$i]]);
}
//==========================================================================================================================

// PHP 4.1.0 부터 지원됨
// php.ini 의 register_globals=off 일 경우
// 전역변수로 설정되어 있는 배열명들을 일반 변수화 한다.
@extract($_GET);
@extract($_POST);
@extract($_SERVER);


################## Session 관련 설정

//session_save_path($_Dir['FS_Session_Dir']);//로그인 세션 캐쉬가 저장될 위치

//세션이 지속되는 시간이 설정되어 있다면 세팅
if (isset($SESSION_CACHE_LIMITER))
    @session_cache_limiter($SESSION_CACHE_LIMITER);
else
    @session_cache_limiter("no-cache, must-revalidate");

//==============================================================================
// 공용 변수
//==============================================================================
// 기본환경설정
ini_set("session.cache_expire", 180); // 세션 캐쉬 보관시간 (분)
ini_set("session.gc_maxlifetime", 10800); // session data의 gabage collection 존재 기간을 지정 (초)

session_set_cookie_params(0, "/");
//ini_set("session.cookie_domain", $_Site['Cookie_Domain']);//해당 도메인 별로 세션을 관리하기 위해 세팅

@session_start();//세션 시작
#############################################






// ----------------------------------------------------------------------------------------------------
// ## 공통변수 및 사용자정의변수 정의
// ----------------------------------------------------------------------------------------------------

// 사이트 기본 정보
$SITENAME							= "IMBDx";
$SITE_DESCRIPTION				= "IMBDx";
$SITE_ENG_TITLE					= "IMBDx";
$SEO_TITLE							= $SITENAME;
$SEO_DESCRIPTION				= $SITE_DESCRIPTION;
$SEO_KEYWORDS					= "";
$SITE_LANGUAGE					= "ENG"; //KOR : 국문, ENG:영문, JPN:일문, CHN:중문
$SITE_DATEFORMAT				= "yyyy-mm-dd";
$SITE_FAVICON						= "";
$SITE_STATE							= "RUN";

// 서버 정보
$SERVER_DOCUMENT_ROOT	= $_SERVER['DOCUMENT_ROOT'];		// 서버 루트 위치
$HTTPS									= (isset($_SERVER['HTTPS'])?$_SERVER['HTTPS'] : "off");						// HTTPS 사용여부 / on, off
$USER_IP								= $_SERVER['REMOTE_ADDR'];			// 접속 아이피
$SERVER_NAME					= $_SERVER['SERVER_NAME'];			// 접속 도메인
$SERVER_PORT						= $_SERVER['SERVER_PORT'];			// 접속 포트
$THISURL								= $_SERVER['REQUEST_URI'];			// 현재 접속중인 URL / 도메인 제외
$PHP_SELF							= $_SERVER['PHP_SELF'];					// 현재 접속중인 URL / 페이지명만
$QUERY_STRING					= $_SERVER['QUERY_STRING'];			// 현재 접속중인 URL / 파라미터
$USER_AGENT						= $_SERVER['HTTP_USER_AGENT'];	// 에이전트정보
$THIS_SESSION_ID					= session_id();									// 사용자 세션ID
$THIS_TOKEN_SEC				= md5(uniqid(rand(), true));					// 로그인 토큰

// 공통 사용 폴더
$FRONTROOT						= "/eng/";													// 프론트 경로 지정
$ADMINROOT							= "/_site_manager";								// 관리자 경로 지정
$IMAGES_PATH						= "/eng/images";										// 프론트 이미지 경로 지정
$COMMON_PATH					= "/eng/common";										// 공통사용 폴더 선언
$UPLOAD_PATH						= "/upload_files";									// 업로드 폴더

// 사이트 URL
$SITEURL								= "";
$SITESSL								= "";

if ($HTTPS == "on") {
	$SITESSL = "https://" . $SERVER_NAME;
	if ($SERVER_PORT != "443") {
		$SITESSL = "https://" . $SERVER_NAME & ":" . $SERVER_PORT;
	}
} else {
	$SITESSL = "http://" . $SERVER_NAME .(($SERVER_PORT == "80") ? "" : ":" . $SERVER_PORT);
}

// 외부 서비스 관련
$SITE_SENDMAIL							= "info@malgum.com";													// 발송 메일 주소
$SMS_SEND_NUMBER					= "";													// 발송 SMS 번호

$GOOGLEANALYTICS						= "";													// 구글 어낼리틱스

$NAVER_LOGIN_CLIENT_ID				= "";
$NAVER_LOGIN_CLIENT_SECRET	= "";
$NAVER_LOGIN_CALLBACK_URL		= "";

$CP_SITE_CODE							= "";
$CP_SITE_PW								= "";

$IPIN_SITE_CODE							= "";
$IPIN_SITE_PW								= "";

$NEWRECAPTCHA							= true;
$NEWRECAPTCHA_SITEKEY			= "";
$NEWRECAPTCHA_SECRET			= "";

$DAUM_POSTCODE_URL					= "";													// 다음 주소 찾기

if ($HTTPS == "on") {
	$DAUM_POSTCODE_URL = "https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js";
} else {
	$DAUM_POSTCODE_URL = "http://dmaps.daum.net/map_js_init/postcode.v2.js";
}


// 브라우저 종류별 분기
If (strpos($USER_AGENT, "Swing") > 0) {
	$strUserBrowser = "Swing";
} else If (strpos($USER_AGENT, "MSIE 6") > 0 && strpos($USER_AGENT, "Trident") <= 0) {
	$strUserBrowser = "IE6";
} else If (strpos($USER_AGENT, "MSIE 7") > 0 && strpos($USER_AGENT, "Trident") <= 0) {
	$strUserBrowser = "IE7";
} else If (strpos($USER_AGENT, "Trident/4.0") > 0) {
	$strUserBrowser = "IE8";
} else If (strpos($USER_AGENT, "Trident/5.0") > 0) {
	$strUserBrowser = "IE9";
} else If (strpos($USER_AGENT, "Trident/6.0") > 0) {
	$strUserBrowser = "IE10";
} else If (strpos($USER_AGENT, "Trident/7.0") > 0) {
	$strUserBrowser = "IE11";
} else If (strpos($USER_AGENT, "Trident") > 0) {
	$strUserBrowser = "IE8+";
} else If (strpos($USER_AGENT, "Chrome") > 0) {
	$strUserBrowser = "Chrome";
} else If (strpos($USER_AGENT, "Safari") > 0) {
	$strUserBrowser = "Safari";
} else {
	$strUserBrowser = "기타";
}


// 접속 기기별 분기
$strUserDevice = "PC";
$mobileString		= array("iphone", "ipod", "iemobile", "mobile", "lgtelecom", "ppc", "blackberry", "sch-", "sph-", "lg-", "canu", "im-" ,"ev-","nokia", "mobi");
for ($i = 0; $i <sizeof($mobileString); $i++) {
	if (strpos(strtolower($USER_AGENT),$mobileString[$i]) > 0) {
		$strUserDevice = "mobile";
	}
}


// 모바일 보기
$_SESSION['is_mobile'] = false;
If ((isset($_REQUEST["device"]) ? $_REQUEST["device"] : "") == "pc") {
	$IS_MOBILE = false;
} Else If ((isset($_REQUEST["device"]) ? $_REQUEST["device"] : "") == "mobile") {
	$IS_MOBILE = true;
} Else If ($_SESSION['is_mobile'] == true) {
	$IS_MOBILE = true;
} Else If ($strUserDevice == "mobile") {
	$IS_MOBILE = true;
} Else {
	$IS_MOBILE = false;
}

$_SESSION['is_mobile'] = $IS_MOBILE;


// 모바일 페이지 이동
if (stristr($THISURL, "_site_manager") == false){
	if ($_SESSION['is_mobile']) {
		//Header("Location:/m" . $THISURL);
	}
}


// SQL 익젝션
//if (in_array(strtolower(ini_get('magic_quotes_gpc')), array('1', 'on'))){
//    $_POST		= array_map('stripslashes', $_POST);
//    $_GET		= array_map('stripslashes', $_GET);
//    $_COOKIE	= array_map('stripslashes', $_COOKIE);
//}


// 관리자 로그인 접근 아이피
$ADMIN_LOGIN_IP			= ""; // 기능을 사용하지 않을 경우 빈값 / , 로 구분


//타임존 세팅
date_default_timezone_set('Asia/Seoul');
$TODAY_DATE_YEAR			= date('Y');
$TODAY_DATE_MONTH		= date('m');
$TODAY_DATE_DAY			= date('d');
$THIS_TODAY_DATE_YMD	= date("Y-m-d");
$THIS_TODAY_DATE_YM		= date("Y-m");

$WORD_FILTERING = "18아,18놈,18새끼,18뇬,18노,18것,18넘,개년,개놈,개뇬,개새,개색끼,개세끼,개세이,개쉐이,개쉑,개쉽,개시키,개자식,개좆,게색기,게색끼,광뇬,뇬,눈깔,뉘미럴,니귀미,니기미,니미,도촬,되질래,뒈져라,뒈진다,디져라,디진다,디질래,병쉰,병신,뻐큐,뻑큐,뽁큐,삐리넷,새꺄,쉬발,쉬밸,쉬팔,쉽알,스패킹,스팽,시벌,시부랄,시부럴,시부리,시불,시브랄,시팍,시팔,시펄,실밸,십8,십쌔,십창,싶알,쌉년,썅놈,쌔끼,쌩쑈,썅,써벌,썩을년,쎄꺄,쎄엑,쓰바,쓰발,쓰벌,쓰팔,씨8,씨댕,씨바,씨발,씨뱅,씨봉알,씨부랄,씨부럴,씨부렁,씨부리,씨불,씨브랄,씨빠,씨빨,씨뽀랄,씨팍,씨팔,씨펄,씹,아가리,아갈이,엄창,접년,잡놈,재랄,저주글,조까,조빠,조쟁이,조지냐,조진다,조질래,존나,존니,좀물,좁년,좃,좆,좇,쥐랄,쥐롤,쥬디,지랄,지럴,지롤,지미랄,쫍빱,凸,퍽큐,뻑큐,빠큐,ㅅㅂㄹㅁ";

?>

<?php

// 개발 관련 처리
if ($SITE_STATE == "DEV") {
	$SITEURL										= "http://" . $SERVER_NAME .(($SERVER_PORT == "80") ? "" : ":" . $SERVER_PORT);
	$SITESSL										= "https://" . $SERVER_NAME .(($SERVER_PORT == "80") ? "" : ":" . $SERVER_PORT);

	$SITE_SENDMAIL							= "info@malgum.com";
	$SMS_SEND_NUMBER					= "02-2051-9551";
	$NAVER_LOGIN_CALLBACK_URL		= $SITEURL . "/member/sns_login_naver.asp";
	$PG_INIPAY_ID								= "";
	$PG_INIPAY_KEY							= "";
	$PG_INIPAY_SITEDOMAIN				= $SITEURL . "INIpay/INIStdweb";

	$NEWRECAPTCHA							= true;
	$NEWRECAPTCHA_SITEKEY			= "6LedalMUAAAAAKZmNLSqsD8ArO51xde6XGVy0vc3";
	$NEWRECAPTCHA_SECRET			= "6LedalMUAAAAACZb7B2cI8KKo1dBmmKuPU3-b_HT";
}

?>