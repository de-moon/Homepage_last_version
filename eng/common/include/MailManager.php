<?
	class MailManager {

/*
	$arr[userfile]
	$arr[userfile_name]
	$arr[userfile_type]
	$arr[to]
	$arr[name]
	$arr[from]
	$arr[subject]
	$arr[body]
	$arr[mode]
*/

		function sendMail($arr) {

			if($arr[name]) {
				$name	= $arr[name];
				$name	= iconv("UTF-8", "EUC-KR", $name);
			}
			else $name="WTM";

			if($arr[subject]) {
				$subject	= $arr[subject];
				$subject	= iconv("UTF-8", "EUC-KR", $subject);
			}
			else $subject="안녕하세요 WTM입니다.";

			$bodytext	= $arr[body];
			$bodytext	= iconv("UTF-8", "EUC-KR", $bodytext);

			$mailheaders .="Return-Path: $arr[from]\r\n";
			$mailheaders .="From:$name<$arr[from]>\r\n";
			$mailheaders .="X-Mailer: Gfew Interface\r\n";

			if($arr[userfile] && $arr[userfile_size]) {

				$filename = $arr[userfile_name];
				$result = fopen($arr[userfile],"r");
				$file = fread($result,$arr[userfile_size]);
				fclose($result);
				if($arr[userfile_type]=="") $arr[userfile_type] = "application/octet-stream";
				$boundary="________".uniqid("part");
				$mailheaders.="MIME-Version: 1.0\r\n";
				$mailheaders.="Content-Type: multipart/mixed; boundary=\"$boundary\"";
				$bodytext="This is a multi-part message in MIME format.\r\n\r\n";
				$bodytext.="--$boundary\r\n";
				$bodytext.="Content-Type: text/html; charset=UTF-8\r\n";
				$bodytext.="Content-Transfer-Encoding: 8bit\r\n\r\n";
				$bodytext.=nl2br(stripslashes($bodytext)). "\r\n\r\n";
				$bodytext.="--$boundary\r\n";
				$bodytext.="Content-Type: $arr[userfile_type]; name=\"$filename\"\r\n";
				$bodytext.="Content-Transfer-Encoding: base64\r\n\r\n";
				$bodytext.=preg_replace("(.{80})","\\1\r\n",base64_encode($file));
				$bodytext.="\r\n--$bounday"."\r\n";

			} else {

                $mailheaders.="Content-Type: text/html; charset=UTF-8\r\n";
				//$mailheaders.="Content-Type: text/html; charset=EUC-KR\r\n";
				if ($arr[mode] == "HTML") {
					$bodytext = stripslashes($bodytext);
				} else {
					$bodytext = nl2br(stripslashes($bodytext));
				}
			}

			if ( mail($arr[to], $subject, $bodytext, $mailheaders) ) {
				return 1;
			} else return 0;
		}

	}
?>