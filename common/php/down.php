<?php
include_once $_SERVER['DOCUMENT_ROOT']."/common/include/db.php";
include_once $_SERVER['DOCUMENT_ROOT']."/common/include/function.php";
$mod = new mod();

try {
    if (empty($_GET['num'])) {
		$mod->java("잘못된 접근입니다.");
	} else {
		$num = $mod->trans(trim($_GET['num']));
	}

    if (empty($_GET['gn'])) {
		$mod->java("잘못된 접근입니다.");
	} else {
		$gn = $mod->trans(trim($_GET['gn']));
	}
	
	if (empty($_GET['type'])) {
		$mod->java("잘못된 접근입니다.");
	} else {
		$type = $mod->trans(trim($_GET['type']));
	}

    if ($gn == 1) {
        $stmt = $pdo->prepare("SELECT DELEGATE_IMG_FILE, DELEGATE_IMG_ORG FROM TB_BOARD_".$type." WHERE BOARD_SEQ=:no");
        $stmt->bindParam(":no", $num);
        $stmt->execute();
        $stmt->bindColumn(1, $file_name);
        $stmt->bindColumn(2, $file_orgname);
        $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    } else {
        $stmt = $pdo->prepare("UPDATE TB_BOARD_".$type."_FILE SET DOWN_COUNT=DOWN_COUNT+1 WHERE FILE_SEQ=:no");
        $stmt->bindParam(":no", $num);
        $stmt->execute();

        $stmt = $pdo->prepare("SELECT FILE_NAME, FILE_ORGNAME FROM TB_BOARD_".$type."_FILE WHERE FILE_SEQ=:no");
        $stmt->bindParam(":no", $num);
        $stmt->execute();
        $stmt->bindColumn(1, $file_name);
        $stmt->bindColumn(2, $file_orgname);
        $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    }

    $data = $_SERVER['DOCUMENT_ROOT'].$file_name;
    
    if(file_exists($data)) {
        if( strstr($HTTP_USER_AGENT,"MSIE 5.5")){
           Header("Content-Type: doesn/matter");
           Header("content-length: ". filesize("$data"));
           Header("Content-Disposition: attachment; filename=$file_name");
           Header("Content-Transfer-Encoding: binary");
           Header("Cache-Control: cache,must-revalidate");
           Header("Pragma: cache");
           Header("Expires: 0");
       }else{
           Header("Content-type: file/unknown");
           Header("content-length: ". filesize("$data"));
           Header("Content-Disposition: attachment; filename=$file_name");
           Header("Content-Description: PHP3 Generated Data");
           Header("Cache-Control: cache,must-revalidate");
           Header("Pragma: cache");
           Header("Expires: 0");
        }

        if(is_file("$data")){
            $fp = fopen("$data","r");
            if(!fpassthru($fp)) {
                fclose($fp);
            }
        }
    }
} catch(Exception $e) {
    echo $e->getMessage();
	exit;
}
?>