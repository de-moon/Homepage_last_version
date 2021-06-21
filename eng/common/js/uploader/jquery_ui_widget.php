<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/commonHeader.php";


$UPLOAD_PATH					= $mod->trans3($_REQUEST, "P", "");					// 업로드 경로
$UPLOAD_TABLE				= $mod->trans3($_REQUEST, "B", "");					// 게시판 구분
$UPLOAD_DIVISION				= $mod->trans3($_REQUEST, "D", "");					// 업로드 경로(추가)
$UPLOAD_TYPE					= $mod->trans3($_REQUEST, "T", "");					// 업로드 종류 구분 : ALL, IMG, DOC
$CALLBACK						= $mod->trans3($_REQUEST, "callback", "");			// 업로드 결과를 받을 엘리먼트의 ID


//실 업로드 경로 구성
if(!$UPLOAD_PATH) {
	$UPLOAD_PATH = "/upload_files";
}

if ($UPLOAD_DIVISION != "") {
	$UPLOAD_PATH = $UPLOAD_PATH.$UPLOAD_TABLE;
}

//업로드폴더 생성
if (!file_exists($_SERVER['DOCUMENT_ROOT'].$UPLOAD_PATH)) {
	@mkdir($_SERVER['DOCUMENT_ROOT'].$UPLOAD_PATH);
}


if ($UPLOAD_DIVISION != "") {
	$UPLOAD_PATH = $UPLOAD_PATH.$UPLOAD_DIVISION."/";
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

<title>Uploader</title>

<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" />
<link rel="stylesheet" href="./js/jquery.ui.plupload/css/jquery.ui.plupload.css" type="text/css" />

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

<!-- production -->
<script type="text/javascript" src="./js/plupload.full.min.js"></script>
<script type="text/javascript" src="./js/jquery.ui.plupload/jquery.ui.plupload.js"></script>
<script type="text/javascript" src="./js/i18n/ko.js"></script><!--국가별 언어 설정-->

<style type="text/css">
	.plupload_button.plupload_start {
		display:none;
	}
</style>
</head>
<body style="font: 13px Verdana; background: #eee; color: #333">

<form id="form" method="post" action="./dump.php">
	<input type="hidden" name="type"				value="<?=$UPLOAD_TYPE?>">
	<input type="hidden" name="callback"		value="<?=$CALLBACK?>">
	<input type="hidden" name="upload_path"	value="<?=$UPLOAD_PATH?>">
	<div id="uploader">
		<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
	</div>
	<br />
	<input type="submit" value="확인" style="width:100%;height:30px;" />
</form>

<script type="text/javascript">
// Initialize the widget when the DOM is ready
var	upload_path		= "<?=$UPLOAD_PATH?>";
var	upload_type		= "<?=$UPLOAD_TYPE?>";
var	upload_table		= "<?=$UPLOAD_TABLE?>";
var	callback				= "<?=$CALLBACK?>";
var	print_mime_type;
var	max_count			= 0;

if(upload_type == "IMG") {
	print_mime_type	=	{title : "mage files", extensions : "jpg,gif,png,jpeg"};
}
else if(upload_type == "DOC") {
	print_mime_type	=	{title : "DOCU files", extensions : "zip,doc,docx,hwp,xls,xlsx,ppt,pptx,txt,pdf"};
}
else {
	print_mime_type	=	{title : "files", extensions : "jpg,gif,png,jpeg,zip,doc,docx,hwp,xls,xlsx,ppt,pptx,txt,pdf"};
}

//한번에 업로드 할 수 있는 최대 갯수 지정
var check_one;
check_one = callback.indexOf("attach_one");
if(check_one == true || callback == "attach_one") {
	max_count = 1;
}
else {
	max_count = 10;
}


$(function() {
	$("#uploader").plupload({
		// General settings
		runtimes : 'html5,flash,silverlight,html4',
		url : './upload.php?P='+upload_path+'&callback='+callback,

		// User can upload no more then 20 files in one go (sets multiple_queues to false)
		max_file_count: max_count,

		//chunk_size: '1mb',
		//chunk_size: '0',

		// Resize images on clientside if we can
		resize : {
			width	: 900,
			height	: 900,
			quality : 100,
			crop: false // crop to exact dimensions
		},

		filters : {
			// Maximum file size
			max_file_size : '1000mb',
			// Specify what files to browse for
			mime_types: [
				//{title : "Image files", extensions : "jpg,gif,png,jpeg"},
				//{title : "Zip files", extensions : "zip"},
				//{title : "DOCU files", extensions : "doc,hwp,xls,xlsx,ppt,txt,pdf"}
				print_mime_type
			]
		},

		// Rename files by clicking on their titles
		rename: true,

		// Sort files
		sortable: true,

		// Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
		dragdrop: true,

		//업로드 파일명 자동 변경
		unique_names: true,

		// Views to activate
		views: {
			list: true,
			thumbs: true, // Show thumbs
			active: 'thumbs'
		},

		// Flash settings
		flash_swf_url : '../../js/Moxie.swf',

		// Silverlight settings
		silverlight_xap_url : '../../js/Moxie.xap'
	});


	// Handle the case when form was submitted before uploading has finished
	$('#form').submit(function(e) {
		// Files in queue upload them first
		if ($('#uploader').plupload('getFiles').length > 0) {

			// When all files are uploaded submit form
			$('#uploader').on('complete', function() {
				$('#form')[0].submit();
			});

			$('#uploader').plupload('start');
		} else {
			alert("You must have at least one file in the queue.");
		}
		return false; // Keep the form from submitting
	});
});
</script>
</body>
</html>
