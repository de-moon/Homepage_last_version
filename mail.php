<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT']."/common/include/config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/common/include/db.php";
include_once $_SERVER['DOCUMENT_ROOT']."/common/include/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/common/include/class.phpmailer.php";

//인증에 성공한 경우에만 추가 프로세스 진행
//메일 발송
$thisDate	=	date("Y-m-d");

$message	=	"<!doctype html>";
$message	.=	"<html lang='en'>";
$message	.=	"<head>";
$message	.=	"<meta charset='UTF-8'>";
$message	.=	"<title>Contact Us</title>";
$message	.=	"</head>";
$message	.=	"<style>";
$message	.=	"html {height: 100%; overflow-y: auto;min-width:320px}";
$message	.=	"body {margin-top: 0 !important; height: 100%; font: 12px/14px 'Open Sans', 'Nanum Gothic', sans-serif; word-break: break-all; color: #181818; word-wrap: break-word; word-break: keep-all;font-family: 'Open Sans', 'Nanum Gothic',sans-serif;}";
$message	.=	"h1, h2, h3, h4, h5, h6 {font: bold 12px/14px 'Open Sans', 'Nanum Gothic', sans-serif;font-family: 'Open Sans', 'Nanum Gothic',sans-serif;}";
$message	.=	"body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, form, fieldset, input, textarea, blockquote, th, td, p, button {margin: 0; padding: 0; -webkit-text-size-adjust: none;}";
$message	.=	"</style>";
$message	.=	"<body style='word-break: break-all; color: #181818; word-wrap: break-word; word-break: keep-all;font-family: 'Open Sans', 'Nanum Gothic',sans-serif;'>";
$message	.=	"<div id='wrap'>";
$message	.=	"<div class='inner' style='width:1032px;margin:0 auto;padding-top:28px'>";
$message	.=	"<div class='mail_form'>";
$message	.=	"<div class='mfTop' style='text-align:center;margin-bottom:86px'>";
$message	.=	"<div class='logo'>";
$message	.=	"<img src='http://noul-malgumci.btbplus.com/images/common/malgum_logo.png' alt='' style='vertical-align: top;'/>";
$message	.=	"</div>";
$message	.=	"<h1 style='font-size:28px;line-height:28px;'>고객문의 접수</h1>";
$message	.=	"</div>";
$message	.=	"<div class='mfCont ci' style='margin-bottom:70px;'>";
$message	.=	"<table width='100%;' style='border-collapse: collapse; border-spacing: 0; table-layout: fixed;font-size:15px;line-height:30px;border-top:2px solid #474747'>";
$message	.=	"<caption></caption>";
$message	.=	"<colgroup>";
$message	.=	"<col width='160px' />";
$message	.=	"<col width='*'/>";
$message	.=	"</colgroup>";
$message	.=	"<tbody>";
$message	.=	"<tr >";
$message	.=	"<td style='border-bottom:1px solid #e1e1e1;padding:21px 0'>이름</td>";
$message	.=	"<td style='border-bottom:1px solid #e1e1e1'>홍길동</td>";
$message	.=	"</tr>";
$message	.=	"<tr >";
$message	.=	"<td style='border-bottom:1px solid #e1e1e1;padding:21px 0'>연락처</td>";
$message	.=	"<td style='border-bottom:1px solid #e1e1e1'>021231234</td>";
$message	.=	"</tr>";
$message	.=	"<tr >";
$message	.=	"<td style='border-bottom:1px solid #e1e1e1;padding:21px 0'>이메일</td>";
$message	.=	"<td style='border-bottom:1px solid #e1e1e1'>에미일주소</td>";
$message	.=	"</tr>";
$message	.=	"<tr >";
$message	.=	"<td style='border-bottom:1px solid #e1e1e1;padding:21px 0'>문의내용</td>";
$message	.=	"<td style='border-bottom:1px solid #e1e1e1'>사용자 문의내용</td>";
$message	.=	"</tr>";
$message	.=	"</tbody>";
$message	.=	"</table>";
$message	.=	"</div>";
$message	.=	"</div>";
$message	.=	"</div>";
$message	.=	"</div>";
$message	.=	"</body>";
$message	.=	"</html>";

$mail = new PHPMailer(true);// the true param means it will throw exceptions on errors, which we need to catch

$mail->CharSet = "utf-8";
$mail->Encoding = "base64";

$mail->IsSMTP();// telling the class to use SMTP

try {
	$mail->Host = "smtp.gmail.com"; // email 보낼때 사용할 서버
	$mail->SMTPAuth = true; // SMTP 인증 사용함
	$mail->Port = 465; // email 보낼때 사용할 포트 번호 
	$mail->SMTPSecure = "ssl"; // SSL 사용
	$mail->Username = "info@malgum.com"; // Gmail 계정
	$mail->Password = "malgum159"; // 패스워드
	$mail->SetFrom('info@malgum.com'); // 보내는 사람 email 주소와 표시될 이름(이름 생략 가능)
	$mail->AddAddress("jmkim@malgum.com"); // 받을 사람 email 주소와 표시될 이름(이름 생략 가능)
//				$mail->AddCC("chchorok@naver.com");
//				$mail->AddCC("chchorok@nate.com");
	$mail->IsHTML(true);
	$mail->Subject = '[맑음]고객 문의 접수'; // 메일 제목
	$mail->Body = $message; // 메일내용(HTML형식, 일반 텍스트 가능)
	$mail->Send();
}
catch (phpmailerException $e) {
	echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
	echo $e->getMessage(); //Boring error messages from anything else!
}
?>