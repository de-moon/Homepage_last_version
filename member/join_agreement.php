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
<!--
	function Send() {
		var f = document.frm_join;

		if (getChecked_Value( f.agreeLicensing ) !== "Y") {
			alert("이용약관에 동의하십시오.");
			return false;
		}

		if (getChecked_Value( f.agreePrivacy ) !== "Y") {
			alert("개인정보보호정책에 동의하십시오.");
			return false;
		}

		return true;
	}
//-->
</script>
</head>
<body>

<?php include_once $_SERVER['DOCUMENT_ROOT']."/common/include/skipNav.php"; ?>

	<!-- wrap -->
	<div id="wrap">

		<?php include_once $_SERVER['DOCUMENT_ROOT']."/common/include/top.php"; ?>

		<!--container-->
		<div id="container">


			<form name="frm_join" method="post" action="join_write.php" onsubmit="return Send();">


			이용약관
			<label><input type="radio" name="agreeLicensing" value="Y"> 동의합니다.</label>
			<label><input type="radio" name="agreeLicensing" value="N" checked> 동의하지 않습니다.</label>

			<br>
			<br>

			개인정보보호정책
			<label><input type="radio" name="agreePrivacy" value="Y"> 동의합니다.</label>
			<label><input type="radio" name="agreePrivacy" value="N" checked> 동의하지 않습니다.</label>


			<input type="submit" value="가입하기" />

			</form>



		</div>
		<!--//contents-->

		<?php include_once $_SERVER['DOCUMENT_ROOT']."/common/include/footer.php"; ?>

	</div>
	<!-- //wrap -->

</body>
</html>