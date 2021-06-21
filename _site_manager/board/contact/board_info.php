<?php
// 메뉴 구분
$MENU_DEPTH_1				= "BOARD";
$MENU_DEPTH_2				= "CONTACT";
$MENU_BOARD					= "고객문의";							// 메뉴명


// 게시판 정의
$BOARD_FILTERING			= $WORD_FILTERING;				// 필터링
$BOARD_TABLENAME		= "TB_BOARD_ALL";				// 테이블명
$BOARD_DIVISION				= "CONTACT";						// 게시판 구분
$BOARD_PAGESIZE			= "10";									// 게시판 리스트 표시수

// 카테고리
$BOARD_CATEGORY = array(
	"대기"=>"대기"
	, "답변"=>"답변"
	);

// 언어
$BOARD_LANGUAGE = array(
	"KOR"=>"KOR"
	//, "ENG"=>"ENG"
	//, "CHN"=>"CHN"
	);

$BOARD_NOTICE					= false;								// 공지여부
$BOARD_VIEW						= false;								// 노출여부
$BOARD_EDITOR					= false;								// 내용 에디터 사용여부
$BOARD_CONTENT				= true;								// 내용
$BOARD_REG_DATE				= false;								// 등록일 수정여부
$BOARD_FILE_PATH				= "/board/";						// 업로드 경로
$BOARD_UPLOAD_ONE			= false;								// 대표 이미지 허용 여부
$BOARD_UPLOAD_IMAGES		= false;								// 이미지 업로드 허용 여부
$BOARD_UPLOAD_ALL			= false;								// 일반 첨부 허용 여부
$BOARD_REPLY						= false;								// 댓글 기능 사용여부

$BOARD_ETC_1						= true;								// 추가컬럼
$BOARD_ETC_2						= true;								// 추가컬럼
$BOARD_ETC_3						= true;								// 추가컬럼
$BOARD_ETC_4						= true;								// 추가컬럼
$BOARD_ETC_5						= true;								// 추가컬럼
$BOARD_ETC_6						= true;								// 추가컬럼
$BOARD_ETC_7						= false;								// 추가컬럼
$BOARD_ETC_8						= false;								// 추가컬럼
$BOARD_ETC_9						= false;								// 추가컬럼
$BOARD_ETC_10					= false;								// 추가컬럼

?>