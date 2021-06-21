<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/commonHeader_nologin.php";



// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------

$var_returl								= $mod->trans3($_REQUEST, "returl", "");



include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/header.php";
?>
<script type="text/javascript">
//<![CDATA[
	function frm_check() {
		var f = document.frm_login;

		if(IsEmpty(f.ins_id.value) == true || f.ins_id.value == "아이디를 입력하세요.") {
			alert("아이디를 입력해 주세요.");
			f.ins_id.focus();
			return false;
		}
		
		if(IsEmpty(f.ins_password.value) == true || f.ins_password.value == "비밀번호를 입력하세요.") {
			alert("비밀번호를 입력해 주세요.");
			f.ins_password.focus();
			return false;
		}
		
		return true;
	}
//]]>
</script>
</head>
<body>

<div id="login_wrap">
	<div id="login_inner">

		<!-- 로그인  -->
		<div id="login_box">
			<form name="frm_login" id="frm_login" method="post" action="proc_login.php" onsubmit="return frm_check();">
			<input type="hidden" name="returl" value="<?=$var_returl ?>">
				<h2>관리자 로그인</h2>
				<input type="text" id="login-id" name="ins_id" class="txt" placeholder="아이디를 입력하세요." autofocus required />
				<input type="password" id="" name="ins_password" class="txt password" placeholder="비밀번호를 입력하세요." required onkeydown="javascript:if(event.keyCode == 13){frm_check();}" />
				<div class="login_bottom">
					<div class="btn"><input type="submit" value="Login" class="button blue" /></div>
				</div>
			</form>
		</div>
		<!-- //login_box -->

	</div>
	<!-- //login_inner -->
</div>
<!-- //login_wrap -->

<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/footer.php";
?>

</body>
</html> 