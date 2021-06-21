<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/commonHeader.php";
include_once "./board_info.php";


// ----------------------------------------------------------------------------------------------------
// ## 공통변수 및 사용자정의변수 정의
// ----------------------------------------------------------------------------------------------------

$setParams		= array();


// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------

$var_Page						= $mod->trans3($_REQUEST, "page", "1");
$var_Mode						= $mod->trans3($_REQUEST, "mode", "NEW");
$var_Num						= $mod->trans3($_REQUEST, "num", "");
$search_division				= $BOARD_DIVISION;
$search_field					= $mod->trans3($_REQUEST, "search_field", "subject");
$search_keyword			= $mod->trans3($_REQUEST, "search_keyword", "");
$search_category			= $mod->trans3($_REQUEST, "search_category", "");
$search_view_yn			= $mod->trans3($_REQUEST, "search_view_yn", "");
$search_language_type	= $mod->trans3($_REQUEST, "search_language_type", "KOR");
$search_pagesize			= $mod->trans3($_REQUEST, "search_pagesize", $BOARD_PAGESIZE);
$search_order_target		= $mod->trans3($_REQUEST, "search_order_target", "BOARD_SEQ");
$search_order_action		= $mod->trans3($_REQUEST, "search_order_action", "");


// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------

if ($var_Mode == "EDT") {
	if ($var_Num == "") $mod->java("{$PARAMETER_002}");
}


// ----------------------------------------------------------------------------------------------------
// ## 페이지 이동 파라미터
// ----------------------------------------------------------------------------------------------------

$setParams[] = "page=".$var_Page;
if ($search_field != "subject") $setParams[] = "search_field=".$search_field;
if ($search_keyword != "") $setParams[] = "search_keyword=".$search_keyword;
if ($search_category != "") $setParams[] = "search_category=".$search_category;
if ($search_view_yn != "") $setParams[] = "search_view_yn=".$search_view_yn;
if ($search_language_type != "KOR") $setParams[] = "search_language_type=".$search_language_type;
if ($search_pagesize != $BOARD_PAGESIZE) $setParams[] = "search_pagesize=".$search_pagesize;
if ($search_order_target != "BOARD_SEQ") $setParams[] = "search_order_target=".$search_order_target;
if ($search_order_action != "") $setParams[] = "search_order_action=".$search_order_action;

$setParams = implode("&amp;",$setParams);



// ####################################################################################################
// ## 게시판 정보
// ####################################################################################################

if ($var_Mode == "EDT") {
	$var_SQL = "SELECT  ";
	$var_SQL .= "   A.BOARD_SEQ, A.DIVISION, A.CATEGORY, A.SUBJECT, A.CONTENT ";
	$var_SQL .= " , A.HIT, A.NOTICE_YN, A.VIEW_YN, A.USER_NAME, A.PASSWORD ";
	$var_SQL .= " , A.REGISTER_IP, A.DEL_YN, A.LANGUAGE_TYPE, A.REG_DATE ";
	$var_SQL .= " , A.ETC_1, A.ETC_2, A.ETC_3, A.ETC_4, A.ETC_5 ";
	$var_SQL .= " , A.ETC_6, A.ETC_7, A.ETC_8, A.ETC_9, A.ETC_10 ";
	$var_SQL .= " FROM ".$BOARD_TABLENAME." A";
	$var_SQL .= " WHERE A.DEL_YN = 'N' AND A.BOARD_SEQ = :no ";

	$stmt = $pdo->prepare($var_SQL);
	$stmt->bindParam(":no", $var_Num);
	$stmt->execute();
	$stmt->bindColumn(1, $col_board_seq);
	$stmt->bindColumn(2, $col_division);
	$stmt->bindColumn(3, $col_category);
	$stmt->bindColumn(4, $col_subject);
	$stmt->bindColumn(5, $col_content);
	$stmt->bindColumn(6, $col_hit);
	$stmt->bindColumn(7, $col_notice_yn);
	$stmt->bindColumn(8, $col_view_yn);
	$stmt->bindColumn(9, $col_user_name);
	$stmt->bindColumn(10, $col_password);
	$stmt->bindColumn(11, $col_register_ip);
	$stmt->bindColumn(12, $col_del_yn);
	$stmt->bindColumn(13, $col_language_type);
	$stmt->bindColumn(14, $col_reg_date);
	$stmt->bindColumn(15, $col_etc_1);
	$stmt->bindColumn(16, $col_etc_2);
	$stmt->bindColumn(17, $col_etc_3);
	$stmt->bindColumn(18, $col_etc_4);
	$stmt->bindColumn(19, $col_etc_5);
	$stmt->bindColumn(20, $col_etc_6);
	$stmt->bindColumn(21, $col_etc_7);
	$stmt->bindColumn(22, $col_etc_8);
	$stmt->bindColumn(23, $col_etc_9);
	$stmt->bindColumn(24, $col_etc_10);
	$stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
} else {
	$col_board_seq				= "";
	$col_division					= "";
	$col_category					= "";
	$col_subject					= "";
	$col_content					= "";
	$col_hit							= "";
	$col_notice_yn				= "N";
	$col_view_yn					= "Y";
	$col_user_name				= "";
	$col_password				= "";
	$col_register_ip				= "";
	$col_del_yn					= "";
	$col_language_type			= $search_language_type;
	$col_reg_date					= "";
	$col_etc_1						= "";
	$col_etc_2						= "";
	$col_etc_3						= "";
	$col_etc_4						= "";
	$col_etc_5						= "";
	$col_etc_6						= "";
	$col_etc_7						= "";
	$col_etc_8						= "";
	$col_etc_9						= "";
	$col_etc_10					= "";
}


include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/header.php";
?>

<link rel="stylesheet" type="text/css" href="<?=$COMMON_PATH ?>/js/datetimepicker/jquery.datetimepicker.css"/>
<script src="<?=$COMMON_PATH ?>/js/datetimepicker/jquery.datetimepicker.js"charset="utf-8"></script>
<script type="text/javascript" src="<?=$COMMON_PATH ?>/js/se2/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript">
//<![CDATA[
var oEditors = [];

$(document).ready(function() {
	$('#reg_date').datetimepicker({
		lang:'ko',
		timepicker:false,
		format:'Y-m-d'
	});
});

function check_register() {
	var f = document.frm_ins;

	<?php if ($BOARD_EDITOR) { ?>
	oEditors.getById["content_"].exec("UPDATE_CONTENTS_FIELD", []);
	<?php } ?>

//	if( !getSelected_Value( f.category ) ) { alert("분류를 선택해 주세요."); return false; }
	if( !IsCheck(f.subject, "제목을 입력해주세요.") ) return false;
//	if( !IsCheck(f.content, "내용을 입력해주세요.") ) return false;

	f.check_delete_file.value = getChecked_Value( f.file_seq_delete );

	$("#button_submit").attr('value', '<?=($var_Mode == "NEW") ? "등록" : "수정" ?>중..'); 
	$("#button_submit").attr('type', 'button'); 

	f.action ="board_proc.php";
	f.target="frm_hiddenFrame";

	return true;
}

function button_recovery() {
	$("#button_submit").attr('value', '<?=($var_Mode == "NEW") ? "등록" : "수정" ?>'); 
	$("#button_submit").attr('type', 'submit'); 
	$("#button_submit").attr('class', 'button rosy'); 
}

function deleteFile(id, obj) {
	var count = $("#"+id).val();
	var file_div = $(obj);

	$("#"+id).val(count-1);
	file_div.parent().remove();
}

function check_file_delete(nNum) {
	if(!confirm("정말 삭제 하시겠습니까?")) return;
	$("#file_delete_"+nNum).prop("checked",true);
	$("#file_text_delete_"+nNum).hide();
	alert("삭제되었습니다. (수정 클릭시 최종 적용됩니다.)");
}

//]]>
</script>
</head>
<body>

<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/top.php";

include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/left.php";
?>

<div id="wrap">
	<div id="content">

		<h3><div><?=$MENU_BOARD?></div></h3>

		<div class="table_view_type01">

			<form name="frm_search" id="frm_search" method="get">
			<input type="hidden" name="page"							value="<?=$var_Page ?>">
			<input type="hidden" name="search_field"					value="<?=$search_field ?>">
			<input type="hidden" name="search_keyword"			value="<?=$search_keyword ?>">
			<input type="hidden" name="search_category"			value="<?=$search_category ?>">
			<input type="hidden" name="search_view_yn"			value="<?=$search_view_yn ?>">
			<input type="hidden" name="search_language_type"	value="<?=$search_language_type ?>">
			<input type="hidden" name="search_order_target"		value="<?=$search_order_target?>">
			<input type="hidden" name="search_order_action"		value="<?=$search_order_action?>">
			<input type="hidden" name="num"								value="<?=$var_Num ?>" />
			</form>

			<form name="frm_ins" method="post" enctype="multipart/form-data" action="board_proc.php" target="frm_hiddenFrame" onsubmit="return check_register();">
			<input type="hidden" name="mode"							value="<?=$var_Mode ?>" />
			<input type="hidden" name="page"							value="<?=$var_Page ?>">
			<input type="hidden" name="search_field"					value="<?=$search_field ?>">
			<input type="hidden" name="search_keyword"			value="<?=$search_keyword ?>">
			<input type="hidden" name="search_category"			value="<?=$search_category ?>">
			<input type="hidden" name="search_view_yn"			value="<?=$search_view_yn ?>">
			<input type="hidden" name="search_language_type"	value="<?=$search_language_type ?>">
			<input type="hidden" name="search_order_target"		value="<?=$search_order_target?>">
			<input type="hidden" name="search_order_action"		value="<?=$search_order_action?>">
			<input type="hidden" name="num"								value="<?=$var_Num ?>" />
			<input type="hidden" name="check_delete_file"			value="" />

			<table>
				<colgroup>
					<col width="120px" />
					<col width="*" />
				</colgroup>
				
				<tr <?php if (!$BOARD_VIEW) { ?>style="display:none;"<?php } ?>>
					<th>노출 여부</th>
					<td class="tal">
						<label><input type="radio" name="view_yn" value="Y" <?php If ($col_view_yn == "Y") { ?>checked<?php } ?> />노출 됨</label>&nbsp;
						<label><input type="radio" name="view_yn" value="N" <?php If ($col_view_yn == "N") { ?>checked<?php } ?> />노출 안됨</label>
					</td>
				</tr>
				
				<tr <?php if ( sizeof($BOARD_LANGUAGE) == 1 ) echo "style='display:none;'"; ?>>
					<th class="tl_round">언어</th>
					<td class="tr_round tal">
						<select title="언어" name="language_type" >
						<?php foreach($BOARD_LANGUAGE as $key => $value): ?>
						<option value="<?=$key ?>" <?php if($col_language_type==$key) echo "selected";?>><?=$value ?></option>
						<?php endforeach ?>
						</select>
					</td>
				</tr>
				<tr <?php if (!$BOARD_NOTICE) { ?>style="display:none;"<?php } ?>>
					<th class="">공지 여부</th>
					<td class=" tal">
						<label><input type="radio" name="notice_yn" value="Y" <?php If ($col_notice_yn == "Y") { ?>checked<?php } ?>>공지</label>&nbsp;
						<label><input type="radio" name="notice_yn" value="N" <?php If ($col_notice_yn == "N") { ?>checked<?php } ?>>일반</label>
					</td>
				</tr>
				
				<tr <?php if ( sizeof($BOARD_CATEGORY) < 1 ) echo "style='display:none;'"; ?>>
					<th>분류</th>
					<td class="tal">
						<select title="분류" name="category">
							<option value="">선택</option>
							<?php foreach($BOARD_CATEGORY as $key => $value): ?>
							<option value="<?=$key ?>" <?php if($col_category==$key) echo "selected";?>><?=$value ?></option>
							<?php endforeach ?>
						</select>
					</td>
				</tr>
				<tr>
					<th>제목</th>
					<td class="tal"><input type="text" id="" name="subject" value="<?=$col_subject ?>" maxlength="100" style="width:50%" placeholder="제목을 입력하세요." required /></td>
				</tr>
				<tr <?php if (!$BOARD_CONTENT) { ?>style="display:none;"<?php } ?>>
					<th>내용</th>
					<td class="tal">
						<textarea name="content" id="content_" style="width:<?php if ($BOARD_EDITOR) { ?>100<?php } else { ?>50<?php } ?>%; height:450px;"><?=$col_content ?></textarea>
						<?php if ($BOARD_EDITOR) { ?>
						<script>
							nhn.husky.EZCreator.createInIFrame({
							oAppRef: oEditors,
							elPlaceHolder: "content_",
							sSkinURI: "<?=$COMMON_PATH?>/js/se2/SmartEditor2Skin.html",
							htParams : {bUseToolbar : true, fOnBeforeUnload : function(){} }, fOnAppLoad : function(){}, fCreator: "createSEditor2"
							});
						</script>
						<?php } ?>
					</td>
				</tr>
				<tr <?php if($BOARD_UPLOAD_ONE) {?>style="display:table-row;"<?php } else { ?>style="display:none;"<?php } ?>>
					<th>
						<?php
							// 파일 구분
							$file_type = 'attach_one';
						?>
						대표 이미지
						<a href="javascript:setOpenPopup('<?=$COMMON_PATH?>/js/uploader/jquery_ui_widget.php?P=<?=$UPLOAD_PATH?>&B=<?=$BOARD_FILE_PATH?>&D=<?=$search_division?>&T=IMG&callback=<?=$file_type ?>', 'uploader', 1000, 360 );">
							<img src="<?=$IMAGES_PATH?>/common/btn_add.png" style="margin-left:5px;width:20px;height:20px;" align="absmiddle"></a>
					</th>
					<td class="tal">
						<?php
							$var_SQL = " SELECT ";
							$var_SQL .= " FILE_SEQ, FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, DOWN_COUNT, REG_DATE ";
							$var_SQL .= " FROM ". $BOARD_TABLENAME ."_FILE ";
							$var_SQL .= " WHERE FILE_TYPE='". $file_type ."' AND BOARD_SEQ = :no ";
							$var_SQL .= " ORDER BY FILE_SEQ ";
							$var_SQL .= " LIMIT 1 ";

							$stmt = $pdo->prepare($var_SQL);
							$stmt->bindParam(":no", $var_Num);
							$stmt->execute();
							$total_count = $stmt->rowCount();

							if ($total_count > 0) {
								for ($i = 0; $i < $total_count; $i++) {
									$row							= $stmt->fetch(PDO::FETCH_OBJ);
									$col_file_seq				= trim($row->FILE_SEQ);
									$col_file_path				= trim($row->FILE_PATH);
									$col_file_name			= trim($row->FILE_NAME);
									$col_file_save				= trim($row->FILE_SAVE);
									$col_file_size				= trim($row->FILE_SIZE);
									$col_file_type				= trim($row->FILE_TYPE);
									$col_file_down_count	= trim($row->DOWN_COUNT);
									$col_file_reg_date		= trim($row->REG_DATE);
						?>
						<div id="file_text_delete_<?=$col_file_seq ?>">
							<div style='margin-bottom:10px;'>
								<img src='<?=$UPLOAD_PATH . $col_file_path . "/" . $col_file_save ?>' border='0' style='max-width:150px;'><br>
								<?=$col_file_name ?>&nbsp;(<?=$mod->byteConvert($col_file_size) ?>)
								<span style="display:none;"><label><input type='checkbox' name='file_seq_delete' id='file_delete_<?=$col_file_seq ?>' value='<?=$col_file_seq ?>' /> 삭제</label></span>
								<input type="button" value="삭제" class="button rosy" onclick="check_file_delete(<?=$col_file_seq ?>);" />
							</div>
						</div>
						<?php
								}
							} 
						?>
						<div id="<?=$file_type ?>" style="margin-top:8px;"></div>
					</td>
				</tr>
				<tr <?php if($BOARD_UPLOAD_IMAGES) {?>style="display:table-row;"<?php } else { ?>style="display:none;"<?php } ?>>
					<th>
						<?php
							// 파일 구분
							$file_type = 'attach_images';
						?>
						첨부 이미지
						<a href="javascript:setOpenPopup('<?=$COMMON_PATH?>/js/uploader/jquery_ui_widget.php?P=<?=$UPLOAD_PATH?>&B=<?=$BOARD_FILE_PATH?>&D=<?=$search_division?>&T=IMG&callback=<?=$file_type ?>', 'uploader', 1000, 360 );">
							<img src="<?=$IMAGES_PATH?>/common/btn_add.png" style="margin-left:5px;width:20px;height:20px;" align="absmiddle"></a>
					</th>
					<td class="tal">
						<?php
							$var_SQL = " SELECT ";
							$var_SQL .= " FILE_SEQ, FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, DOWN_COUNT, REG_DATE ";
							$var_SQL .= " FROM ". $BOARD_TABLENAME ."_FILE ";
							$var_SQL .= " WHERE FILE_TYPE='". $file_type ."' AND BOARD_SEQ = :no ";
							$var_SQL .= " ORDER BY FILE_SEQ ";

							$stmt = $pdo->prepare($var_SQL);
							$stmt->bindParam(":no", $var_Num);
							$stmt->execute();
							$total_count = $stmt->rowCount();

							if ($total_count > 0) {
								for ($i = 0; $i < $total_count; $i++) {
									$row							= $stmt->fetch(PDO::FETCH_OBJ);
									$col_file_seq				= trim($row->FILE_SEQ);
									$col_file_path				= trim($row->FILE_PATH);
									$col_file_name			= trim($row->FILE_NAME);
									$col_file_save				= trim($row->FILE_SAVE);
									$col_file_size				= trim($row->FILE_SIZE);
									$col_file_type				= trim($row->FILE_TYPE);
									$col_file_down_count	= trim($row->DOWN_COUNT);
									$col_file_reg_date		= trim($row->REG_DATE);
						?>
						<div id="file_text_delete_<?=$col_file_seq ?>">
							<div style='margin-bottom:10px;'>
								<img src='<?=$UPLOAD_PATH . $col_file_path . "/" . $col_file_save ?>' border='0' style='max-width:150px;'><br>
								<?=$col_file_name ?>&nbsp;(<?=$mod->byteConvert($col_file_size) ?>)
								<span style="display:none;"><label><input type='checkbox' name='file_seq_delete' id='file_delete_<?=$col_file_seq ?>' value='<?=$col_file_seq ?>' /> 삭제</label></span>
								<input type="button" value="삭제" class="button rosy" onclick="check_file_delete(<?=$col_file_seq ?>);" />
							</div>
						</div>
						<?php
								}
							} 
						?>
						<div id="<?=$file_type ?>" style="margin-top:8px;"></div>
					</td>
				</tr>
				<tr <?php if($BOARD_UPLOAD_ALL) {?>style="display:table-row;"<?php } else { ?>style="display:none;"<?php } ?>>
					<th>
						<?php
							// 파일 구분
							$file_type = 'attach_all';
						?>
						첨부 파일
						<a href="javascript:setOpenPopup('<?=$COMMON_PATH?>/js/uploader/jquery_ui_widget.php?P=<?=$UPLOAD_PATH?>&B=<?=$BOARD_FILE_PATH?>&D=<?=$search_division?>&T=ETC&callback=<?=$file_type ?>', 'uploader', 1000, 360 );">
							<img src="<?=$IMAGES_PATH?>/common/btn_add.png" style="margin-left:5px;width:20px;height:20px;" align="absmiddle"></a>
					</th>
					<td class="tal">
						<?php
							$var_SQL = " SELECT ";
							$var_SQL .= " FILE_SEQ, FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, DOWN_COUNT, REG_DATE ";
							$var_SQL .= " FROM ". $BOARD_TABLENAME ."_FILE ";
							$var_SQL .= " WHERE FILE_TYPE='". $file_type ."' AND BOARD_SEQ = :no ";
							$var_SQL .= " ORDER BY FILE_SEQ ";

							$stmt = $pdo->prepare($var_SQL);
							$stmt->bindParam(":no", $var_Num);
							$stmt->execute();
							$total_count = $stmt->rowCount();

							if ($total_count > 0) {
								for ($i = 0; $i < $total_count; $i++) {
									$row							= $stmt->fetch(PDO::FETCH_OBJ);
									$col_file_seq				= trim($row->FILE_SEQ);
									$col_file_path				= trim($row->FILE_PATH);
									$col_file_name			= trim($row->FILE_NAME);
									$col_file_save				= trim($row->FILE_SAVE);
									$col_file_size				= trim($row->FILE_SIZE);
									$col_file_type				= trim($row->FILE_TYPE);
									$col_file_down_count	= trim($row->DOWN_COUNT);
									$col_file_reg_date		= trim($row->REG_DATE);
						?>
						<div id="file_text_delete_<?=$col_file_seq ?>">
							<div style='margin-bottom:10px;'>
								<?=$col_file_name ?>&nbsp;(<?=$mod->byteConvert($col_file_size) ?>)
								<span style="display:none;"><label><input type='checkbox' name='file_seq_delete' id='file_delete_<?=$col_file_seq ?>' value='<?=$col_file_seq ?>' /> 삭제</label></span>
								<input type="button" value="삭제" class="button rosy" onclick="check_file_delete(<?=$col_file_seq ?>);" />
							</div>
						</div>
						<?php
								}
							} 
						?>
						<div id="<?=$file_type ?>" style="margin-top:8px;"></div>
					</td>
				</tr>
				<tr <?php if (!$BOARD_ETC_1) { ?>style="display:none;"<?php } ?>>
					<th>기사 URL</th>
					<td class="tal"><input type="text" id="" name="etc_1" value="<?=$col_etc_1 ?>" maxlength="2000" style="width:50%" placeholder="http://" /></td>
				</tr>
				
				<tr <?php if (!$BOARD_REG_DATE) { ?>style="display:none;"<?php } ?>>
					<th>기사 등록일</th>
					<td class="tal">
						<input type="text" title="등록일" readonly="readonly" id="reg_date" name="reg_date" value="<?=$col_reg_date ?>" style="width:63px">
					</td>
				</tr>
				<tr style="display:none;">
					<th>이름</th>
					<td class="tal"><input type="text" id="" name="user_name" value="<?=$col_user_name ?>" maxlength="30" style="width:50%" /></td>
				</tr>
				<tr style="display:none;">
					<th>비밀번호</th>
					<td class="tal"><input type="text" id="" name="password" value="<?=$col_password ?>" maxlength="255" style="width:50%" /></td>
				</tr>
				
				<tr <?php if (!$BOARD_ETC_2) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><input type="text" id="" name="etc_2" value="<?=$col_etc_2 ?>" maxlength="2000" style="width:50%" /></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_3) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><input type="text" id="" name="etc_3" value="<?=$col_etc_3 ?>" maxlength="2000" style="width:50%" /></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_4) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><input type="text" id="" name="etc_4" value="<?=$col_etc_4 ?>" maxlength="2000" style="width:50%" /></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_5) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><input type="text" id="" name="etc_5" value="<?=$col_etc_5 ?>" maxlength="2000" style="width:50%" /></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_6) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><input type="text" id="" name="etc_6" value="<?=$col_etc_6 ?>" maxlength="2000" style="width:50%" /></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_7) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><input type="text" id="" name="etc_7" value="<?=$col_etc_7 ?>" maxlength="2000" style="width:50%" /></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_8) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><input type="text" id="" name="etc_8" value="<?=$col_etc_8 ?>" maxlength="2000" style="width:50%" /></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_9) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><input type="text" id="" name="etc_9" value="<?=$col_etc_9 ?>" maxlength="2000" style="width:50%" /></td>
				</tr>
				<tr <?php if (!$BOARD_ETC_10) { ?>style="display:none;"<?php } ?>>
					<th>기타</th>
					<td class="tal"><input type="text" id="" name="etc_10" value="<?=$col_etc_10 ?>" maxlength="2000" style="width:50%" /></td>
				</tr>
			</table>

			<div class="table_bottom">
				<div class="left">
					<a href="board_list.php?<?=$setParams ?>" class="button white">목록</a>
				</div>
				<div class="right">
					<?php if($var_Mode == "NEW"){?>
					<input type="submit" id="button_submit" value="등록" class="button rosy" />
					<a href="board_list.php?<?=$setParams ?>" class="button white">취소</a>
					<?php }else{?>
					<input type="submit" id="button_submit" value="수정" class="button rosy" />
					<a href="board_view.php?<?=$setParams ?>&num=<?=$var_Num ?>" class="button white">취소</a>
					<?php }?>
				</div>
			</div>
			</form>
		</div>

	</div>
	<!-- //content -->
</div>
<!-- //wrap -->

<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/footer.php";
?>

</body>
</html>