<?php
include_once $_SERVER['DOCUMENT_ROOT']."/common/include/commonHeader.php";

$filename = $mod->trans(trim($_REQUEST["file"]));
$var_Num = $mod->trans(trim($_REQUEST["num"]));

try {

	if ($var_Num != "") {
		$var_SQL = "UPDATE TB_BOARD_ALL_FILE SET ";
		$var_SQL .= " DOWN_COUNT=DOWN_COUNT + 1";
		$var_SQL .= " WHERE FILE_SEQ=?";
		$stmt = $pdo->prepare($var_SQL);
		$stmt->bindParam(1, $var_Num);
		$stmt->execute();

		$query = "SELECT";
		$query .= " FILE_SEQ, FILE_PATH, FILE_NAME, FILE_SAVE";
		$query .= " FROM TB_BOARD_ALL_FILE";
		$query .= " WHERE FILE_SEQ=?";
		$stmt = $pdo->prepare($query);
		$stmt->bindParam(1, $var_Num);
		$stmt->execute();
		$stmt->bindColumn(1, $col_file_seq);
		$stmt->bindColumn(2, $col_file_path);
		$stmt->bindColumn(3, $col_file_name);
		$stmt->bindColumn(4, $col_file_save);
		$stmt->fetch(PDO::FETCH_ASSOC);
		$stmt->closeCursor();

		$data = $_SERVER['DOCUMENT_ROOT'].$UPLOAD_PATH.$filename;
		
		$col_file_name = iconv('utf-8','euc-kr',$col_file_name);

		if (file_exists($data)) {
			if( strstr($HTTP_USER_AGENT,"MSIE 5.5")){
			   Header("Content-Type: doesn/matter");
			   Header("content-length: ". filesize("$data"));
			   Header("Content-Disposition: attachment; filename=$col_file_name");
			   Header("Content-Transfer-Encoding: binary");
			   Header("Cache-Control: cache,must-revalidate");
			   Header("Pragma: cache");
			   Header("Expires: 0");
		   }else{
			   Header("Content-type: file/unknown");
			   Header("content-length: ". filesize("$data"));
			   Header("Content-Disposition: attachment; filename=$col_file_name");
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
		} else {
			echo "파일이 없습니다.";
			echo "<br/>$data";
		}
	}
} catch(Exception $e) {
	echo $e->getMessage();
	exit;
}
?>