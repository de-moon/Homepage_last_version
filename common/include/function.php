<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/common/php/htmlpurifier/library/HTMLPurifier.auto.php";
#########################################################################################
#날짜 : 2007-11-22
#작성자 : 김남윤
#########################################################################################
class mod {

##################################자바스크립트경고창#####################################
	function java($msg) {
		echo("<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\n");
		echo("<script type='text/javascript'>\n");
		echo("alert('".$msg."');\n");
		echo("history.back();\n");
		echo("</script>\n");
		exit;
	}

	function scalert($msg) {
		echo("<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\n");
		echo("<script type='text/javascript'>\n");
		echo("alert('".$msg."');\n");
		echo("</script>\n");
		exit;
	}

	function trans($string) {
        return htmlentities($string, ENT_QUOTES, "UTF-8");
	}

	function trans2($string, $strValue) {
		$string = (strlen($string) != 0) ? $string : $strValue;

		if ( sizeof($string) < 2 ) {
			$string = trim($string);
			return htmlentities($string, ENT_QUOTES, "UTF-8");
		} else {
			return $string;
		}
	}

	function trans3($obj, $string, $strValue) {
		$return_str = "";

		if ( isset($obj[$string]) ) {
			$return_str = (strlen($obj[$string]) != 0) ? $obj[$string] : $strValue;

			if (is_array($return_str)){
				if ( sizeof($return_str) < 2 ) {
					$return_str = trim($return_str);
					$return_str = htmlentities($return_str, ENT_QUOTES, "UTF-8");
				}
			}
		} else {
			$return_str = $strValue;
		}

		return $return_str;
	}

    function mysql_fix_string($conn, $string) {
        if (get_magic_quotes_gpc()) $string = stripslashes($string);
        return $string;
    }

    function removesc($string) {
        $string = preg_replace("/<script>.*<\/script>/s", "", $string);
        $string = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $string);
        $string = preg_replace('~\<style(.*)\>(.*)\<\/style\>~', '', $string);
        return $string;
    }

    function html_filter($string) {
        // 기본 설정을 불러온 후 적당히 커스터마이징을 해줍니다.
        $config = HTMLPurifier_Config::createDefault();
        $config->set('Attr.EnableID', false);
        $config->set('Attr.DefaultImageAlt', '');

        // 인터넷 주소를 자동으로 링크로 바꿔주는 기능
        $config->set('AutoFormat.Linkify', true);

        // 이미지 크기 제한 해제 (한국에서 많이 쓰는 웹툰이나 짤방과 호환성 유지를 위해)
        $config->set('HTML.MaxImgLength', null);
        $config->set('CSS.MaxImgLength', null);

        // 다른 인코딩 지원 여부는 확인하지 않았습니다. EUC-KR인 경우 iconv로 UTF-8 변환후 사용하시는 게 좋습니다.
        $config->set('Core.Encoding', 'UTF-8');

        // 필요에 따라 DOCTYPE 바꿔쓰세요.
        $config->set('HTML.Doctype', 'XHTML 1.0 Transitional');

        // 플래시 삽입 허용
        $config->set('HTML.FlashAllowFullScreen', true);
        $config->set('HTML.SafeEmbed', true);
        $config->set('HTML.SafeIframe', true);
        $config->set('HTML.SafeObject', true);
        $config->set('Output.FlashCompat', true);

        // 최근 많이 사용하는 iframe 동영상 삽입 허용
        $config->set('URI.SafeIframeRegexp', '#^(?:https?:)?//(?:'.implode('|', array(
            'www\\.youtube(?:-nocookie)?\\.com/',
            'maps\\.google\\.com/',
            'player\\.vimeo\\.com/video/',
            'www\\.microsoft\\.com/showcase/video\\.aspx',
            '(?:serviceapi\\.nmv|player\\.music)\\.naver\\.com/',
            '(?:api\\.v|flvs|tvpot|videofarm)\\.daum\\.net/',
            'v\\.nate\\.com/',
            'play\\.mgoon\\.com/',
            'channel\\.pandora\\.tv/',
            'www\\.tagstory\\.com/',
            'play\\.pullbbang\\.com/',
            'tv\\.seoul\\.go\\.kr/',
            'ucc\\.tlatlago\\.com/',
            'vodmall\\.imbc\\.com/',
            'www\\.musicshake\\.com/',
            'www\\.afreeca\\.com/player/Player\\.swf',
            'static\\.plaync\\.co\\.kr/',
            'video\\.interest\\.me/',
            'player\\.mnet\\.com/',
            'sbsplayer\\.sbs\\.co\\.kr/',
            'img\\.lifestyler\\.co\\.kr/',
            'c\\.brightcove\\.com/',
            'www\\.slideshare\\.net/',
        )).')#');

        // 설정을 저장하고 필터링 라이브러리 초기화
        $purifier = new HTMLPurifier($config);

        // HTML 필터링 실행
        $string = $purifier->purify($string);
        return $string;
    }

    function html_filter2($obj, $string) {
		$return_str = "";

		if ( isset($obj[$string]) ) {
			// 기본 설정을 불러온 후 적당히 커스터마이징을 해줍니다.
			$config = HTMLPurifier_Config::createDefault();
			$config->set('Attr.EnableID', false);
			$config->set('Attr.DefaultImageAlt', '');

			// 인터넷 주소를 자동으로 링크로 바꿔주는 기능
			$config->set('AutoFormat.Linkify', true);

			// 이미지 크기 제한 해제 (한국에서 많이 쓰는 웹툰이나 짤방과 호환성 유지를 위해)
			$config->set('HTML.MaxImgLength', null);
			$config->set('CSS.MaxImgLength', null);

			// 다른 인코딩 지원 여부는 확인하지 않았습니다. EUC-KR인 경우 iconv로 UTF-8 변환후 사용하시는 게 좋습니다.
			$config->set('Core.Encoding', 'UTF-8');

			// 필요에 따라 DOCTYPE 바꿔쓰세요.
			$config->set('HTML.Doctype', 'XHTML 1.0 Transitional');

			// 플래시 삽입 허용
			$config->set('HTML.FlashAllowFullScreen', true);
			$config->set('HTML.SafeEmbed', true);
			$config->set('HTML.SafeIframe', true);
			$config->set('HTML.SafeObject', true);
			$config->set('Output.FlashCompat', true);

			// 최근 많이 사용하는 iframe 동영상 삽입 허용
			$config->set('URI.SafeIframeRegexp', '#^(?:https?:)?//(?:'.implode('|', array(
				'www\\.youtube(?:-nocookie)?\\.com/',
				'maps\\.google\\.com/',
				'player\\.vimeo\\.com/video/',
				'www\\.microsoft\\.com/showcase/video\\.aspx',
				'(?:serviceapi\\.nmv|player\\.music)\\.naver\\.com/',
				'(?:api\\.v|flvs|tvpot|videofarm)\\.daum\\.net/',
				'v\\.nate\\.com/',
				'play\\.mgoon\\.com/',
				'channel\\.pandora\\.tv/',
				'www\\.tagstory\\.com/',
				'play\\.pullbbang\\.com/',
				'tv\\.seoul\\.go\\.kr/',
				'ucc\\.tlatlago\\.com/',
				'vodmall\\.imbc\\.com/',
				'www\\.musicshake\\.com/',
				'www\\.afreeca\\.com/player/Player\\.swf',
				'static\\.plaync\\.co\\.kr/',
				'video\\.interest\\.me/',
				'player\\.mnet\\.com/',
				'sbsplayer\\.sbs\\.co\\.kr/',
				'img\\.lifestyler\\.co\\.kr/',
				'c\\.brightcove\\.com/',
				'www\\.slideshare\\.net/',
			)).')#');

			// 설정을 저장하고 필터링 라이브러리 초기화
			$purifier = new HTMLPurifier($config);

			// HTML 필터링 실행
			$return_str = $purifier->purify($obj[$string]);
		}

		return $return_str;
    }
####################################페이징나누기(통합형)#################################
	function paging($page, $totalpage, $qs="", $paging=10) {
		//이미지 경로
		$img_path = "/image/";
		//페이지 네비게이션에 보여질 페이지 개수
		if (!$paging) $paging = 10;
		//시작 페이지 번호 설정
		if ($page % $paging == 0) {
			$startpage = $page - ($paging - 1);
		} else {
			$startpage = intval($page / $paging) * $paging + 1;
		}

		// 이전 페이지 설정
		$prevpage = $startpage - 1;
		// 다음 페이지 설정
		$nextpage = $startpage + $paging;

		//마지막 페이징 번호 설정
		if ($totalpage / $paging > 1) {
			$laststartpage = (intval($totalpage / $paging) * $paging ) + 1;
		} else {
			$laststartpage = 1;
		}
		$rt = "";

		//첫 페이지로 돌아가기 버튼
		if ($page > $paging) {
			if ($qs) {
				$rt = "<a href='".$_SERVER["PHP_SELF"]."?page=1&amp;".$qs."' class='gp_arrow'>";
			} else {
				$rt = "<a href='".$_SERVER["PHP_SELF"]."?page=1' class='gp_arrow'>";
			}
			$rt .= "<img src='/images/common/btn_prev2.gif' alt='처음페이지로' /></a>";
		} else {
			$rt .= "<a class='gp_arrow'><img src='/images/common/btn_prev2.gif' alt='처음페이지로' /></a>";
		}

		// 이전 페이지로 돌아가기 버튼
		if ($totalpage > $paging && $page > $paging) {
			if ($qs) {
				$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=".$prevpage."&amp;".$qs."' class='gp_arrow'>";
			} else {
				$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=".$prevpage."' class='gp_arrow'>";
			}
			$rt .= "<img src='/images/common/btn_prev.gif' alt='' /></a>";
		} else {
			$rt .= "<a class='gp_arrow'><img src='/images/common/btn_prev.gif' alt='' /></a>";
		}

		if ($totalpage <= 1) {
			$rt .= "<span class='now_page'>1</span>";
		} else {

			// 페이지 링크 번호 나열
			for ($i = $startpage; $i <= ($startpage + ($paging - 1)); $i++) {
				if ($page != $i) {
					if ($qs) {
						$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=".$i."&amp;".$qs."'>".$i."</a>";
					} else {
						$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=".$i."'>".$i."</a>";
					}
				} else {
					$rt .= "<span class='now_page'>".$i."</span>";
				}

				if ($i >= $totalpage) {
					break;
				}
			}
		}

		// 다음 페이지로 넘어가기 버튼
		if ($startpage + $paging - 1 < $totalpage) {
			if ($qs) {
				$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=".$nextpage."&amp;".$qs."' class='gp_arrow last'>";
			} else {
				$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=".$nextpage."' class='gp_arrow last'>";
			}
			$rt .= "<img src='/images/common/btn_next.gif' alt='' /></a>";
		} else {
			$rt .= "<a class='gp_arrow'><img src='/images/common/btn_next.gif' alt='' /></a>";
		}

		// 마지막 페이지로 이동 버튼
		if ($page < intval($laststartpage)) {
			if ($qs) {
				$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=".$totalpage."&amp;".$qs."' class='gp_arrow last'>";
			} else {
				$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=".$totalpage."' class='gp_arrow last'>";
			}
			$rt .= "<img src='/images/common/btn_next2.gif' alt='마지막페이지로' /></a>";
		} else {
			$rt .= "<a class='gp_arrow last'><img src='/images/common/btn_next2.gif' alt='마지막페이지로' /></a>";
		}
		return $rt;
	}

	function paging_front($page, $totalpage, $qs="", $paging=10) {
		//이미지 경로
		$img_path = "/image/";
		//페이지 네비게이션에 보여질 페이지 개수
		if (!$paging) $paging = 10;
		//시작 페이지 번호 설정
		if ($page % $paging == 0) {
			$startpage = $page - ($paging - 1);
		} else {
			$startpage = intval($page / $paging) * $paging + 1;
		}

		$rt = "";

		$prevpage = $startpage - 1;			// 이전 페이지 설정
		$nextpage = $startpage + $paging;	// 다음 페이지 설정

		//마지막 페이징 번호 설정
		if ($totalpage / $paging > 1) {
			$laststartpage = (intval($totalpage / $paging) * $paging ) + 1;
		} else {
			$laststartpage = 1;
		}

		//첫 페이지로 돌아가기 버튼
		if ($page > $paging) {
			if ($qs) {
				$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=1&amp;".$qs."' class='pager_btn first'>";
			} else {
				$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=1' class='pager_btn first'>";
			}
			$rt .= "처음</a>";
		} else {
			$rt .= "<a class='pager_btn first'>처음</a>";
		}

		// 이전 페이지로 돌아가기 버튼
		if ($totalpage > $paging && $page > $paging) {
			if ($qs) {
				$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=".$prevpage."&amp;".$qs."' class='pager_btn prev'>";
			} else {
				$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=".$prevpage."' class='pager_btn prev'>";
			}
			$rt .= "이전</a>";
		} else {
			$rt .= "<a class='pager_btn prev'>이전</a>";
		}

		if ($totalpage <= 1) {
			$rt .= "<span class='current_page'>1</span>";
		} else {

			// 페이지 링크 번호 나열
			for ($i = $startpage; $i <= ($startpage + ($paging - 1)); $i++) {
				if ($page != $i) {
					if ($qs) {
						$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=".$i."&amp;".$qs."'>".$i."</a>";
					} else {
						$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=".$i."'>".$i."</a>";
					}
				} else {
					$rt .= "<span class='current_page'>".$i."</span>";
				}

				if ($i >= $totalpage) {
					break;
				}
			}
		}

		// 다음 페이지로 넘어가기 버튼
		if ($startpage + $paging - 1 < $totalpage) {
			if ($qs) {
				$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=".$nextpage."&amp;".$qs."' class='pager_btn next'>";
			} else {
				$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=".$nextpage."' class='pager_btn next'>";
			}
			$rt .= "다음</a>";
		} else {
			$rt .= "<a class='pager_btn next'>다음</a>";
		}

		// 마지막 페이지로 이동 버튼
		if ($page < intval($laststartpage)) {
			if ($qs) {
				$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=".$totalpage."&amp;".$qs."' class='pager_btn last'>";
			} else {
				$rt .= "<a href='".$_SERVER["PHP_SELF"]."?page=".$totalpage."' class='pager_btn last'>";
			}
			$rt .= "마지막</a>";
		} else {
			$rt .= "<a class='pager_btn last'>마지막</a>";
		}
		return $rt;
	}

##########################################내용을 태그없이 그대로#########################
	function cont($content) {
		$content = str_replace("<", "&lt;", $content);
		$content = str_replace(">", "&gt;", $content);
		$content = str_replace("\n", "<br />", $content);
		return $content;
	}
###########################################제목의 길이제한###############################
	function tit($str, $size) {
		if (!$size or (strlen($str) <= $size)){
            return $str;
        } else {
            for ($i = 0; $i < $size; $i++) {
                if((Ord($str[$i]) <= 127) && (Ord($str[$i]) >= 0)){$result .=$str[$i];}
                else if((Ord($str[$i]) <= 223) && (Ord($str[$i]) >= 194)){$result .=$str[$i].$str[$i+1];$i+1;}
                else if((Ord($str[$i]) <= 239) && (Ord($str[$i]) >= 224)){$result .=$str[$i].$str[$i+1].$str[$i+2];$i+2;}
                else if((Ord($str[$i]) <= 244) && (Ord($str[$i]) >= 240)){$result .=$str[$i].$str[$i+1].$str[$i+2].$str[$i+3];$i+3;}
            }
            return $result."...";
        }
	}

    function iif($condition, $val1, $val2) {
        if ($condition) {
            $iif = $val1;
        } else {
            $iif = $val2;
        }
        return $iif;
    }

#########################################섬네일 이미지#######################################
	function thumnail($file, $save_filename, $save_path, $max_width, $max_height) {
		$img_info = getImageSize($file);
		if ($img_info[2] == 1) {
			$src_img = ImageCreateFromGif($file);
		} else if ($img_info[2] == 2) {
			$src_img = ImageCreateFromJPEG($file);
		} else if ($img_info[2] == 3) {
			$src_img = ImageCreateFromPNG($file);
		} else {
			return 0;
		}
		$dst_width = $img_info[0];
		$dst_height = $img_info[1];

		while ($dst_width > $max_width || $dst_height > $max_height) {
			if ($dst_width > $max_width) {
				$temp = $dst_width;
				$dst_width = $max_width;
				$dst_height = ceil(($max_width / $temp) * $dst_height);
			}

			if ($dst_height > $max_height) {
				$temp = $dst_height;
				$dst_height = $max_height;
				$dst_width = ceil(($max_height / $temp) * $dst_width);
			}
		}

		if($dst_width < $max_width) $srcx = ceil(($max_width - $dst_width)/2); else $srcx = 0;
		if($dst_height < $max_height) $srcy = ceil(($max_height - $dst_height)/2); else $srcy = 0;

		if ($img_info[2] == 1) {
			$dst_img = imagecreate($max_width, $max_height);
		} else {
			$dst_img = imagecreatetruecolor($max_width, $max_height);
		}

		$bgc = ImageColorAllocate($dst_img, 255, 255, 255);
		ImageFilledRectangle($dst_img, 0, 0, $max_width, $max_height, $bgc);
		ImageCopyResampled($dst_img, $src_img, $srcx, $srcy, 0, 0, $dst_width, $dst_height, ImageSX($src_img),ImageSY($src_img));

		if ($img_info[2] == 1) {
			ImageInterlace($dst_img);
			ImageGif($dst_img, $save_path."/".$save_filename);
		} else if ($img_info[2] == 2) {
			ImageInterlace($dst_img);
			ImageJPEG($dst_img, $save_path."/".$save_filename,100);
		} else if ($img_info[2] == 3) {
			ImagePNG($dst_img, $save_path."/".$save_filename);
		}
		ImageDestroy($dst_img);
		ImageDestroy($src_img);
	}

	//fileExt("파일이름") : 파일의 확장자를 구한다
	function fileExt($filename) {
		$extArray = explode(".", $filename);
		return $extArray[count($extArray)-1];
	}

	//fileBody("파일이름") : 확장자를 제외한 파일의 이름을 구한다.
	function fileBody($filename) {
		$extArray = explode(".", $filename);
		$fileBody = "";
		for ($i = 0; $i < count($extArray) - 1; $i++) {
			$fileBody .= "." . $extArray[$i];
		}
		return substr($fileBody, 1);
	}

	function fileUpload($uploaddir, $filename, $rename, $headname, $force=false) {
		if (!is_dir($_SERVER['DOCUMENT_ROOT'].$uploaddir)) {
			umask(0);
			echo $uploaddir;
			mkdir($uploaddir,0755); //디렉토리생성
		}
		$nofileext = "PHP,PHP3,PHP4,HTML,HTM,INC,DAT,INI,JS,CGI,PHTM,PHTM,SQL,PL";

		$upfile = $_FILES[$filename]["name"];
		ECHO "<BR/>22 : $upfile";
		if (!$upfile) return "";

		//$fileBody = $this->fileBody($upfile);
		//$fileExt = $this->fileExt($upfile);
		$fileBody = mod::fileBody($upfile);
		$fileExt = mod::fileExt($upfile);

		if (strpos($nofileext, strtoupper($fileExt)) > -1) return "";

		if ($rename != "") $fileBody = $rename;
		if ($headname != "") $fileBody = $headname . "_" . $fileBody;

		$upfile = $fileBody . "." . $fileExt;
		$uploadfile =  $uploaddir."/".$upfile;

		if ( $force == false ) {
			if(file_exists($uploadfile)) {
				$fileBody .= "_" . date("YmdHis");
				$upfile = $fileBody . "." . $fileExt;
				$uploadfile =  $uploaddir."/".$upfile;
			}
		}
		move_uploaded_file($_FILES[$filename]["tmp_name"], $_SERVER['DOCUMENT_ROOT'].$uploadfile);
		return $upfile;
	}

// 파일을 업로드 함
function upload_file($srcfile, $destfile, $dir)
{
    if ($destfile == "") return false;
    // 업로드 한후 , 퍼미션을 변경함
	echo "<br>srcfile :  $srcfile";
	echo "<br>destfile : "." $dir".'/'."$destfile";
    @move_uploaded_file($srcfile, $dir.'/'.$destfile);
    @chmod($dir.'/'.$destfile, '0644');
    return true;
}


function img_upload($srcfile, $filename, $dir)
{
    if($filename == '')
        return '';
    $size = @getimagesize($srcfile);
    if($size[2] < 1 || $size[2] > 3)
        return '';

    if(!is_dir($dir)) {
        @mkdir($dir, '0755');
        @chmod($dir, '0755');
    }

    $pattern = "/[#\&\+\-%@=\/\\:;,'\"\^`~\|\!\?\*\$#<>\(\)\[\]\{\}]/";

    $filename = preg_replace("/\s+/", "", $filename);
    $filename = preg_replace( $pattern, "", $filename);

    $filename = preg_replace_callback(
                          "/[가-힣]+/",
                          create_function('$matches', 'return base64_encode($matches[0]);'),
                          $filename);

    $filename = preg_replace( $pattern, "", $filename);
    $prepend = '';

    // 동일한 이름의 파일이 있으면 파일명 변경
    if(is_file($dir.'/'.$filename)) {
        for($i=0; $i<20; $i++) {
            $prepend = str_replace('.', '_', microtime(true)).'_';

            if(is_file($dir.'/'.$prepend.$filename)) {
                usleep(mt_rand(100, 10000));
                continue;
            } else {
                break;
            }
        }
    }

    $filename = $prepend.$filename;

    $this->upload_file($srcfile, $filename, $dir);

    $file = str_replace($dir, '', $dir.'/'.$filename);

    return $file;
}

// 파일명에서 특수문자 제거
function get_safe_filename($name)
{
    $pattern = '/["\'<>=#&!%\\\\(\)\*\+\?]/';
    $name = preg_replace($pattern, '', $name);

    return $name;
}






	//임시비밀번호생성
	function generateRandomPassword($length=8, $strength=0) {
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}

		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}

	function cut_str2($msg,$cut_size) {
		if ($cut_size<=0) return $msg;
		$COUNT = 0;

		for ($i = 0; $i < strlen($msg); $i++) {
			if (ord($msg[$i]) > 127) {
				$COUNT = $COUNT + 2;
				if ($COUNT <= $cut_size) {
					$MSG .= $msg[$i].$msg[++$i];
				}
			} else {
				$COUNT++;
				if ($COUNT <= $cut_size) {
					$MSG .= $msg[$i];
				}
			}
		}
		return $MSG;
	}


	function select($dbh, $query, $bindParam) {
		$stmt = $dbh->prepare($query);
		if (!empty($bindParam)) {
			// 배열 원소 각각의 레퍼런스를 원소로 하는 배열 구성
            for($i = 0; $i < sizeof($bindParam); $i++) {
                foreach ($bindParam[$i] as $key => $val) {
                    if (is_int($val)) { $param = PDO::PARAM_INT; }
                    else if (is_bool($val)) { $param = PDO::PARAM_BOOL; }
                    else if (is_null($val)) { $param = PDO::PARAM_NULL; }
                    else if (is_string($val)) { $param = PDO::PARAM_STR; }
                    else { $param = FALSE;}
                    $stmt->bindValue($key, $val, $param);
                }
            }
		}

        $stmt->execute();
		return $stmt;
	}

	function sql_debug($sql_string, array $params = null) {
		if (!empty($params)) {
			$indexed = $params == array_values($params);
			$indexed = is_array($params[0]) ? 3 : $indexed;

			foreach($params as $k=>$v) {
				if (is_object($v)) {
					if ($v instanceof \DateTime) $v = $v->format('Y-m-d H:i:s');
					else continue;
				} elseif (is_string($v)) {
					$v="'$v'";
				} elseif ($v === null) {
					$v='NULL';
				} elseif (is_array($v) && $indexed!=3) {
					$v = implode(',', $v);
				}

				if (is_array($v)) {
					foreach($v as $kk=>$vv) {
						if ($kk[0] != ':') $kk = ':'.$kk;
						$sql_string = str_replace($kk,$vv,$sql_string);
					}
				} else if ($indexed) {
					$sql_string = preg_replace('/\?/', $v, $sql_string, 1);
				} else {
					if ($k[0] != ':') $k = ':'.$k;
					$sql_string = str_replace($k,$v,$sql_string);
				}
			}
		}

		if ("112.220.102.26" == $_SERVER[ 'REMOTE_ADDR'] || "1.221.13.67" == $_SERVER[ 'REMOTE_ADDR'] ) {
			echo $sql_string."<br/>";
		}
	}

    function byteConvert($bytes) {
		if ($bytes==0 || $bytes==""){
			return "";
		}
        $imarr = array('B', 'Kb', 'MB', 'GB', 'TB', 'PB');
        $e = floor(log($bytes) / log(1024));
        return sprintf('%.2f '.$imarr[$e], ($bytes/pow(1024, floor($e))));
    }

#########################################################################################
	function javalo($msg,$lo) {
		echo("<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\n");
		echo "<script type='text/javascript'>\n";
		echo "alert('".$msg."');\n";
		echo "parent.document.location.replace('".$lo."');\n";
		echo "</script>\n";
        exit;
	}

	function javaloc($msg,$lo) {
		//echo("<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\n");
		echo "<script type='text/javascript'>\n";
		echo "alert('".$msg."');\n";
		echo "parent.document.location.replace('".$lo."');\n";
		echo "</script>\n";
        exit;
	}

	function locate($lo){
        echo("<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\n");
		echo "<script type='text/javascript'>\n";
		echo "document.location.replace('".$lo."');\n";
		echo "</script>\n";
        exit;
	}

    function javaCloselo($msg,$lo) {
		echo("<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\n");
		echo "<script type='text/javascript'>\n";
		echo "alert('".$msg."');\n";
		echo "opener.location.replace('".$lo."');\n";
        echo "window.close();\n";
		echo "</script>\n";
        exit;
	}

    function javaCloseReload($msg) {
		echo("<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\n");
		echo "<script type='text/javascript'>\n";
		echo "alert('".$msg."');\n";
		echo "opener.location.reload();\n";
        echo "window.close();\n";
		echo "</script>\n";
        exit;
	}

    function javaAlerFunction($msg,$strFunction) {
		echo("<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\n");
		echo "<script type='text/javascript'>\n";
		echo "alert('".$msg."');\n";
		echo "eval('".$strFunction."');\n";
		echo "</script>\n";
        exit;
	}


	function br2nl($string) {
		return preg_replace('/\<br(\s*)?\/?\/>/i', Chr(13), $string);
	}

}
?>