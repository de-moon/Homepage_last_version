<?php
include_once $_SERVER['DOCUMENT_ROOT']."/common/include/db.php";
include_once $_SERVER['DOCUMENT_ROOT']."/common/include/function.php";

$mod = new mod();

$filename = $mod->trans(trim($_REQUEST["file"]));

$data = $_SERVER['DOCUMENT_ROOT'].$filename;

if (file_exists($data)) {
	Header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	Header("Pragma: public");
	Header("Expires: 0");
	Header("Content-type: application/octet-stream");
	Header("content-length: ". filesize($data));
	Header("Content-Disposition: attachment; filename=".iconv('utf-8','euc-kr',$filename));
	Header("Content-Transfer-Encoding: binary");
	ob_clean();
	flush();
	if(is_file($data)){
		$fp = fopen($data,"r");
		if(!fpassthru($fp)) {
			fclose($fp);
		}
	}
}
?>