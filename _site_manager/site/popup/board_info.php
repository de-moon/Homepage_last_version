<?php
// 메뉴 구분
$MENU_DEPTH_1				= "SETTING";
$MENU_DEPTH_2				= "POPUP";
$MENU_BOARD					= "팝업관리";							// 메뉴명


// 게시판 정의
$BOARD_FILTERING			= $WORD_FILTERING;				// 필터링
$BOARD_TABLENAME		= "TB_POPUP";						// 테이블명
$BOARD_DIVISION				= "POPUP";								// 게시판 구분
$BOARD_PAGESIZE			= "10";									// 게시판 리스트 표시수

// 카테고리
$BOARD_CATEGORY = array(
	);

// 언어
$BOARD_LANGUAGE = array(
	"KOR"=>"KOR"
	, "ENG"=>"ENG"
	//, "CHN"=>"CHN"
	);

$BOARD_VIEW						= true;								// 노출여부
$BOARD_INPUT_TYPE				= true;								// 팝업내용 유형 선택 사용유무 / 기본은 이미지
$BOARD_REG_DATE				= false;								// 등록일 수정여부
$BOARD_FILE_PATH				= "/popup/";						// 업로드 경로
$BOARD_MOBILE_LINK			= true;								// 모바일 링크 사용여부

?>