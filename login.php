<?php
include_once $_SERVER['DOCUMENT_ROOT']."/common/include/commonHeader.php";


// ----------------------------------------------------------------------------------------------------
// ## 공통변수 및 사용자정의변수 정의
// ----------------------------------------------------------------------------------------------------

$MENU_DEPTH_1 = "";
$MENU_DEPTH_2 = "";
$MENU_DEPTH_3 = "";


// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------

$var_returl						= $mod->trans2($_REQUEST["returl"], "");


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

<script>
//<![CDATA[
	function frm_check() {
		var f = document.frm_login;

		if(IsEmpty(f.in_id.value) === true || f.in_id.value === "아이디를 입력하세요.") {
			alert("아이디를 입력해 주세요.");
			f.in_id.focus();
			return false;
		}

		if(IsEmpty(f.in_password.value) === true || f.in_password.value === "비밀번호를 입력하세요.") {
			alert("비밀번호를 입력해 주세요.");
			f.in_password.focus();
			return false;
		}

		return true;
	}
//]]>
</script>
</head>
<body>

<?php include_once $_SERVER['DOCUMENT_ROOT']."/common/include/skipNav.php"; ?>

	<!-- wrap -->
	<div id="wrap">

		<?php include_once $_SERVER['DOCUMENT_ROOT']."/common/include/top.php"; ?>

		<!--container-->
		<div id="container">

			<div id="login_box">
				<form name="frm_login" id="frm_login" method="post" action="proc_login.php" onsubmit="return frm_check();">
				<input type="hidden" name="returl" value="<?=$var_returl ?>">
					<h2>로그인</h2>
					<input type="text" id="login-id" name="ins_id" class="txt" placeholder="아이디를 입력하세요." autofocus required />
					<input type="password" id="" name="ins_password" class="txt password" placeholder="비밀번호를 입력하세요." required onkeydown="javascript:if(event.keyCode == 13){frm_check();}" />
					<div class="login_bottom">
						<div class="btn"><input type="submit" value="Login" class="button blue" /></div>
					</div>
				</form>
			</div>

		</div>
		<!--//contents-->

		<?php include_once $_SERVER['DOCUMENT_ROOT']."/common/include/footer.php"; ?>

	</div>
	<!-- //wrap -->

</body>
</html>