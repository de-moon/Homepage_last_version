<?php
include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/include/commonHeader.php";
include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/php/PHPMailer/class.phpmailer.php";
include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/php/PHPMailer/class.smtp.php";
include_once $_SERVER['DOCUMENT_ROOT']."/eng/common/php/PHPMailer/PHPMailerAutoload.php";
include_once "./board_info.php";


try {

// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------

	$var_Mode								= "NEW";

	$in_category							= $mod->trans3($_POST, "category", "대기");
	$in_subject								= $mod->trans3($_POST, "subject", "");
	$in_content								= $mod->html_filter2($_POST, "content");
	$in_hit									= $mod->trans3($_POST, "hit", "0");
	$in_notice_yn							= $mod->trans3($_POST, "notice_yn", "N");
	$in_view_yn							= $mod->trans3($_POST, "view_yn", "Y");
	$in_user_name						= $mod->trans3($_POST, "user_name", "");
	$in_password							= $mod->trans3($_POST, "password", "");
	$in_language_type					= $SITE_LANGUAGE;
	$in_reg_date							= $mod->trans3($_POST, "reg_date", date("Y-m-d H:i:s", time()));
	$in_etc_1								= $mod->trans3($_POST, "etc_1", "");
	$in_etc_2								= $mod->trans3($_POST, "etc_2", "");
	$in_etc_3								= $mod->trans3($_POST, "etc_3", "");
	$in_etc_4								= $mod->trans3($_POST, "etc_4", "");
	$in_etc_5								= $mod->trans3($_POST, "etc_5", "");
	$in_etc_6								= $mod->trans3($_POST, "etc_6", "");
	$in_etc_7								= $mod->trans3($_POST, "etc_7", "");
	$in_etc_8								= $mod->trans3($_POST, "etc_8", "");
	$in_etc_9								= $mod->trans3($_POST, "etc_9", "");
	$in_etc_10								= $mod->trans3($_POST, "etc_10", "");
	$in_attach_one_count				= $mod->trans3($_POST, "attach_one_count", "0");
	$in_attach_images_count			= $mod->trans3($_POST, "attach_images_count", "0");
	$in_attach_all_count				= $mod->trans3($_POST, "attach_all_count", "0");
	$in_file_delete_list					= $mod->trans3($_POST, "check_delete_file", "0");

	if (strlen($in_reg_date) == 10) $in_reg_date = $in_reg_date ." " . date("H:i:s", time());

	if (!$BOARD_EDITOR) {
		$in_content							= $mod->trans3($_POST, "content", "");
	}


// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------

	if ($var_Mode == "NEW") {
		//if ($in_subject == "") $mod->javaAlerFunction("{$PARAMETER_002}[1]", "parent.button_recovery()");
	}


// ----------------------------------------------------------------------------------------------------
// ## 자동등록 체크
// ----------------------------------------------------------------------------------------------------

if ( isset($_POST) ) {
	$captcha_response 		= htmlspecialchars($_POST['g-recaptcha-response']);
	$curl = curl_init();

	$captcha_verify_url = "https://www.google.com/recaptcha/api/siteverify";

	curl_setopt($curl, CURLOPT_URL,$captcha_verify_url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, "secret=".$NEWRECAPTCHA_SECRET."&response=".$captcha_response);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$captcha_output = curl_exec ($curl);
	curl_close ($curl);
	$decoded_captcha = json_decode($captcha_output);
	$captcha_status = $decoded_captcha->success; // store validation result to a variable.
	if($captcha_status === FALSE){
		$mod->javaAlerFunction($BOARD_004, "parent.button_recovery()");
	} else {
		echo '<h2>Success!</h2>';
	}
}


// ----------------------------------------------------------------------------------------------------
// ## 페이지 이동 파라미터
// ----------------------------------------------------------------------------------------------------




// ----------------------------------------------------------------------------------------------------
// ## 필터링 체크
// ----------------------------------------------------------------------------------------------------

	if ($var_Mode != "DEL" && $var_Mode != "EDT_CATEGORY") {
		If ($BOARD_FILTERING != "") {
			$arrFiltering = explode(",", $BOARD_FILTERING);
			for ($i = 0; $i < sizeof($arrFiltering); $i++) {
				if (strpos($in_subject, $arrFiltering[$i]) > -1) {
					$mod->javaAlerFunction("{$BOARD_002}[ $arrFiltering[$i] ]", "parent.button_recovery()");
				}
				if (strpos($in_content, $arrFiltering[$i]) > -1) {
					$mod->javaAlerFunction("{$BOARD_001}[ $arrFiltering[$i] ]", "parent.button_recovery()");
				}
			}
		}
	}


// ####################################################################################################
// ## 업로드 파일 처리
// ####################################################################################################

	// 업로드 경로 설정
	$BOARD_FILE_PATH = $BOARD_FILE_PATH.$BOARD_DIVISION;


// ----------------------------------------------------------------------------------------------------
// ## DB 연결 / 트랜젝션
// ----------------------------------------------------------------------------------------------------

	$pdo->beginTransaction();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// ####################################################################################################
// ## 등록
// ####################################################################################################

	if ($var_Mode == "NEW") {

		// 게시판 등록
		$var_SQL = " INSERT INTO ". $BOARD_TABLENAME ." (";
		$var_SQL .= "   DIVISION, CATEGORY, SUBJECT, CONTENT, HIT ";
		$var_SQL .= " , NOTICE_YN, VIEW_YN, USER_NAME, PASSWORD";
		$var_SQL .= " , REGISTER_IP, LANGUAGE_TYPE, REG_DATE ";
		$var_SQL .= " , ETC_1, ETC_2, ETC_3, ETC_4, ETC_5 ";
		$var_SQL .= " , ETC_6, ETC_7, ETC_8, ETC_9, ETC_10 ";
		$var_SQL .= " , USER_SEQ ";
		$var_SQL .= " ) VALUES ( ";
		$var_SQL .= "   ?, ?, ?, ?, ? ";
		$var_SQL .= " , ?, ?, ?, ? ";
		$var_SQL .= " , ?, ?, ? ";
		$var_SQL .= " , ?, ?, ?, ?, ? ";
		$var_SQL .= " , ?, ?, ?, ?, ? ";
		$var_SQL .= " , ? ";
		$var_SQL .= " ); ";

		$param[] = $BOARD_DIVISION;
		$param[] = $in_category;
		$param[] = $in_subject;
		$param[] = $in_content;
		$param[] = $in_hit;
		$param[] = $in_notice_yn;
		$param[] = $in_view_yn;
		$param[] = $in_user_name;
		$param[] = $in_password;
		$param[] = $USER_IP;
		$param[] = $in_language_type;
		$param[] = $in_reg_date;
		$param[] = $in_etc_1;
		$param[] = $in_etc_2;
		$param[] = $in_etc_3;
		$param[] = $in_etc_4;
		$param[] = $in_etc_5;
		$param[] = $in_etc_6;
		$param[] = $in_etc_7;
		$param[] = $in_etc_8;
		$param[] = $in_etc_9;
		$param[] = $in_etc_10;
		$param[] = $_SESSION['MALGUM_USER_SEQ'];

		$stmt = $pdo->prepare($var_SQL);
		$arrayStart = 1;
		for ($i = 0; $i < count($param); $i++) {
			$stmt->bindParam($arrayStart, $param[$i]);
			$arrayStart++;
		}
		//echo $mod->sql_debug($var_SQL, $param);
		$stmt->execute();
		$col_board_seq = $pdo->lastInsertId();

		// 게시판 파일 등록
		if($in_attach_one_count > 0) {
			$check_file_type = "attach_one";
			$attach_one_count = $in_attach_one_count;
			for($i=0; $i<$attach_one_count; $i++) {
				$attach_one_org_name	= $_REQUEST[$check_file_type . "_orgname_{$i}"];
				$attach_one_sav_name	= $_REQUEST[$check_file_type . "_tmpname_{$i}"];
				$attach_one_sav_flag		= $_REQUEST[$check_file_type . "_status_{$i}"];
				$attach_one_sav_size		= $_REQUEST[$check_file_type . "_size_{$i}"];
				$attach_one_sav_num		= $i;

				$var_SQL = " INSERT INTO ". $BOARD_TABLENAME ."_FILE (";
				$var_SQL .= "   FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, FILE_NO, REGISTER_IP, REG_DATE, BOARD_SEQ ";
				$var_SQL .= " ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? ) ";

				unset($param);
				$param[] = $BOARD_FILE_PATH;
				$param[] = $attach_one_org_name;
				$param[] = $attach_one_sav_name;
				$param[] = $attach_one_sav_size;
				$param[] = $check_file_type;
				$param[] = $attach_one_sav_num;
				$param[] = $USER_IP;
				$param[] = date("Y-m-d H:i:s", time());
				$param[] = $col_board_seq;

				$stmt = $pdo->prepare($var_SQL);
				$arrayStart = 1;
				for ($j = 0; $j < count($param); $j++) {
					$stmt->bindParam($arrayStart, $param[$j]);
					$arrayStart++;
				}
				//echo $mod->sql_debug($var_SQL, $param);
				$stmt->execute();
			}
		}

		if($in_attach_images_count > 0) {
			$check_file_type = "attach_images";
			$attach_one_count = $in_attach_images_count;
			for($i=0; $i<$attach_one_count; $i++) {
				$attach_one_org_name	= $_REQUEST[$check_file_type . "_orgname_{$i}"];
				$attach_one_sav_name	= $_REQUEST[$check_file_type . "_tmpname_{$i}"];
				$attach_one_sav_flag		= $_REQUEST[$check_file_type . "_status_{$i}"];
				$attach_one_sav_size		= $_REQUEST[$check_file_type . "_size_{$i}"];
				$attach_one_sav_num		= $i;

				$var_SQL = " INSERT INTO ". $BOARD_TABLENAME ."_FILE (";
				$var_SQL .= "   FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, FILE_NO, REGISTER_IP, REG_DATE, BOARD_SEQ ";
				$var_SQL .= " ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? ) ";

				unset($param);
				$param[] = $BOARD_FILE_PATH;
				$param[] = $attach_one_org_name;
				$param[] = $attach_one_sav_name;
				$param[] = $attach_one_sav_size;
				$param[] = $check_file_type;
				$param[] = $attach_one_sav_num;
				$param[] = $USER_IP;
				$param[] = date("Y-m-d H:i:s", time());
				$param[] = $col_board_seq;

				$stmt = $pdo->prepare($var_SQL);
				$arrayStart = 1;
				for ($j = 0; $j < count($param); $j++) {
					$stmt->bindParam($arrayStart, $param[$j]);
					$arrayStart++;
				}
				//echo $mod->sql_debug($var_SQL, $param);
				$stmt->execute();
			}
		}

		if($in_attach_all_count > 0) {
			$check_file_type = "attach_all";
			$attach_one_count = $in_attach_all_count;
			for($i=0; $i<$attach_one_count; $i++) {
				$attach_one_org_name	= $_REQUEST[$check_file_type . "_orgname_{$i}"];
				$attach_one_sav_name	= $_REQUEST[$check_file_type . "_tmpname_{$i}"];
				$attach_one_sav_flag		= $_REQUEST[$check_file_type . "_status_{$i}"];
				$attach_one_sav_size		= $_REQUEST[$check_file_type . "_size_{$i}"];
				$attach_one_sav_num		= $i;

				$var_SQL = " INSERT INTO ". $BOARD_TABLENAME ."_FILE (";
				$var_SQL .= "   FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, FILE_NO, REGISTER_IP, REG_DATE, BOARD_SEQ ";
				$var_SQL .= " ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? ) ";

				unset($param);
				$param[] = $BOARD_FILE_PATH;
				$param[] = $attach_one_org_name;
				$param[] = $attach_one_sav_name;
				$param[] = $attach_one_sav_size;
				$param[] = $check_file_type;
				$param[] = $attach_one_sav_num;
				$param[] = $USER_IP;
				$param[] = date("Y-m-d H:i:s", time());
				$param[] = $col_board_seq;

				$stmt = $pdo->prepare($var_SQL);
				$arrayStart = 1;
				for ($j = 0; $j < count($param); $j++) {
					$stmt->bindParam($arrayStart, $param[$j]);
					$arrayStart++;
				}
				//echo $mod->sql_debug($var_SQL, $param);
				$stmt->execute();
			}
		}


		$pdo->commit();


		// 메일발송 / 관리자
		if ( $SITE_STATE == "RUN" ) {
			$var_SQL = " SELECT ";
			$var_SQL .= "   A.USER_SEQ, A.USER_DIVISION, A.USER_NAME ";
			$var_SQL .= " , A.EMAIL , A.USER_STATE ";
			$var_SQL .= " , B.AUTHORITY, B.AUTHORITY_DETAIL ";
			$var_SQL .= " , C.ETC_1 AS CHECKMAIL";
			$var_SQL .= " FROM TB_USER A INNER JOIN TB_ADMIN B ON A.USER_SEQ = B.USER_SEQ ";
			$var_SQL .= " INNER JOIN TB_USER_ADD C ON A.USER_SEQ = C.USER_SEQ ";
			$var_SQL .= " WHERE C.ETC_1 = 1 AND A.USER_STATE = 1 AND A.EMAIL != ''";
			$result = $pdo->prepare($var_SQL);
			$result->execute();
			$cnt = $result->rowCount();
			echo $var_SQL."<br>";
			echo $cnt."<br>";
			if($cnt>0)
			{
				echo "into email confirm<br>";
				$subject = $MENU_BOARD." 에 새글이 등록되었습니다.";
				$message = "<!doctype html>";
				$message .= "<html lang='en'>";
				$message .= "<head>";
				$message .= "<meta charset='UTF-8'>";
				$message .= "<title>{$MENU_BOARD}</title>";
				$message .= "</head>";
				$message .= "<style>";
				$message .= "html {height: 100%; overflow-y: auto;min-width:320px}";
				$message .= "body {margin-top: 0 !important; height: 100%; font: 12px/14px 'Open Sans', 'Nanum Gothic', sans-serif; word-break: break-all; color: #181818; word-wrap: break-word; word-break: keep-all;font-family: 'Open Sans', 'Nanum Gothic',sans-serif;}";
				$message .= "h1, h2, h3, h4, h5, h6 {font: bold 12px/14px 'Open Sans', 'Nanum Gothic', sans-serif;font-family: 'Open Sans', 'Nanum Gothic',sans-serif;}";
				$message .= "body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, form, fieldset, input, textarea, blockquote, th, td, p, button {margin: 0; padding: 0; -webkit-text-size-adjust: none;}";
				$message .= "</style>";
				$message .= "<body style='word-break: break-all; color: #181818; word-wrap: break-word; word-break: keep-all;font-family: 'Open Sans', 'Nanum Gothic',sans-serif;'>";
				$message .= "<div id='wrap'>";
				$message .= "<div class='inner' style='width:1032px;margin:0 auto;padding-top:28px'>";
				$message .= "<div class='mail_form'>";
				$message .= "<div class='mfTop' style='text-align:center;margin-bottom:86px'>";
				$message .= "<h1 style='font-size:28px;line-height:28px;'>{$MENU_BOARD}</h1>";
				$message .= "</div>";
				$message .= "<div class='mfCont ci' style='margin-bottom:70px;'>";
				$message .= "<table width='100%;' style='border-collapse: collapse; border-spacing: 0; table-layout: fixed;font-size:15px;line-height:30px;border-top:2px solid #474747'>";
				$message .= "<caption></caption>";
				$message .= "<colgroup>";
				$message .= "<col width='160px' />";
				$message .= "<col width='*'/>";
				$message .= "</colgroup>";
				$message .= "<tbody>";
				$message .= "<tr >";
				$message .= "<td style='border-bottom:1px solid #e1e1e1;padding:21px 0'>제목</td>";
				$message .= "<td style='border-bottom:1px solid #e1e1e1'>{$in_subject}</td>";
				$message .= "</tr>";
				$message .= "<tr >";
				$message .= "<td style='border-bottom:1px solid #e1e1e1;padding:21px 0'>국가</td>";
				$message .= "<td style='border-bottom:1px solid #e1e1e1'>{$in_etc_2}</td>";
				$message .= "</tr>";
				$message .= "<tr >";
				$message .= "<td style='border-bottom:1px solid #e1e1e1;padding:21px 0'>소속</td>";
				$message .= "<td style='border-bottom:1px solid #e1e1e1'>{$in_etc_1}</td>";
				$message .= "</tr>";
				$message .= "<tr >";
				$message .= "<td style='border-bottom:1px solid #e1e1e1;padding:21px 0'>담당자</td>";
				$message .= "<td style='border-bottom:1px solid #e1e1e1'>{$in_etc_3}</td>";
				$message .= "</tr>";
				$message .= "<tr >";
				$message .= "<td style='border-bottom:1px solid #e1e1e1;padding:21px 0'>이메일</td>";
				$message .= "<td style='border-bottom:1px solid #e1e1e1'>{$in_etc_6}</td>";
				$message .= "</tr>";
				$message .= "<tr >";
				$message .= "<td style='border-bottom:1px solid #e1e1e1;padding:21px 0'>연락처(휴대폰)</td>";
				$message .= "<td style='border-bottom:1px solid #e1e1e1'>{$in_etc_5}</td>";
				$message .= "</tr>";
				$message .= "<tr >";
				$message .= "<td style='border-bottom:1px solid #e1e1e1;padding:21px 0'>주제</td>";
				$message .= "<td style='border-bottom:1px solid #e1e1e1'>{$in_etc_4}</td>";
				$message .= "</tr>";
				$message .= "<tr >";
				$message .= "<td style='border-bottom:1px solid #e1e1e1;padding:21px 0'>내용</td>";
				$message .= "<td style='border-bottom:1px solid #e1e1e1'>".nl2br($in_content)."</td>";
				$message .= "</tr>";
				$message .= "</tbody>";
				$message .= "</table>";
				$message .= "</div>";
				$message .= "</div>";
				$message .= "</div>";
				$message .= "</div>";
				$message .= "</body>";
				$message .= "</html>";

				$mail = new PHPMailer;
				$mail->CharSet = "utf-8";
				$mail->Encoding = "base64";
				$mail->isSMTP();
				$mail->SMTPDebug = 0;
				$mail->Debugoutput = 'html';
				$mail->Host = 'smtp.gmail.com';
				$mail->Port = 465;
				$mail->SMTPSecure = 'ssl';											// 일반 SMTP 일경우 주석 필요
				$mail->SMTPAuth = true;
				$mail->Username = $SITE_SENDMAIL;
				$mail->Password = "malgum159";
				$mail->setFrom($SITE_SENDMAIL, 'info');
				//$mail->addAddress('jmkim@malgum.com', 'jmkim');

				for ($i = 0; $i < $cnt; $i++) {
					$row = $result->fetch(PDO::FETCH_ASSOC);
					$mail->addAddress($row['EMAIL'], $row['USER_NAME']);
				}

				$mail->Subject = $subject;
				$mail->msgHTML($message, dirname(__FILE__));

				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					echo "Message sent!";
				}
			}
		}
		$mod->javalo($DB_009,"/");
	}

} catch(Exception $e) {
	$pdo->rollback();
	echo $e->getMessage();
	$mod->javaAlerFunction($DB_003, "parent.button_recovery()");
	exit;
}
?>