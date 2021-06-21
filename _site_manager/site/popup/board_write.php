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

$var_Page						= $mod->trans3($_REQUEST, "page", "");
$var_Mode						= $mod->trans3($_REQUEST, "mode", "NEW");
$var_Num						= $mod->trans3($_REQUEST, "num", "");
$search_division				= $BOARD_DIVISION;
$search_field					= $mod->trans3($_REQUEST, "search_field", "subject");
$search_keyword			= $mod->trans3($_REQUEST, "search_keyword", "");
$search_category			= $mod->trans3($_REQUEST, "search_category", "");
$search_view_yn			= $mod->trans3($_REQUEST, "search_view_yn", "");
$search_language_type	= $mod->trans3($_REQUEST, "search_language_type", "KOR");
$search_pagesize			= $mod->trans3($_REQUEST, "search_pagesize", $BOARD_PAGESIZE);
$search_order_target		= $mod->trans3($_REQUEST, "search_order_target", "POPUP_SEQ");
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
if ($search_order_target != "POPUP_SEQ") $setParams[] = "search_order_target=".$search_order_target;
if ($search_order_action != "") $setParams[] = "search_order_action=".$search_order_action;

$setParams = implode("&amp;",$setParams);



// ####################################################################################################
// ## 게시판 정보
// ####################################################################################################

if ($var_Mode == "EDT") {
	$var_SQL = "SELECT  ";
	$var_SQL .= "   A.POPUP_SEQ, A.DIVISION, A.ORDER_NUM, A.SUBJECT, A.CONTENT ";
	$var_SQL .= " , A.INPUT_TYPE, A.LINK_URL, A.LINK_URL_MOBILE, A.LINK_TARGET ";
	$var_SQL .= " , A.START_DATE, A.END_DATE, A.VIEW_YN, A.REGISTER_IP ";
	$var_SQL .= " , A.DEL_YN, A.LANGUAGE_TYPE, A.MOD_DATE, A.REG_DATE ";
	$var_SQL .= " FROM ".$BOARD_TABLENAME." A";
	$var_SQL .= " WHERE A.DEL_YN = 'N' AND A.POPUP_SEQ = :no ";

	$stmt = $pdo->prepare($var_SQL);
	$stmt->bindParam(":no", $var_Num);
	$stmt->execute();
	$stmt->bindColumn(1, $col_popup_seq);
	$stmt->bindColumn(2, $col_division);
	$stmt->bindColumn(3, $col_order_num);
	$stmt->bindColumn(4, $col_subject);
	$stmt->bindColumn(5, $col_content);
	$stmt->bindColumn(6, $col_input_type);
	$stmt->bindColumn(7, $col_link_url);
	$stmt->bindColumn(8, $col_link_url_mobile);
	$stmt->bindColumn(9, $col_link_target);
	$stmt->bindColumn(10, $col_start_date);
	$stmt->bindColumn(11, $col_end_date);
	$stmt->bindColumn(12, $col_view_yn);
	$stmt->bindColumn(13, $col_register_ip);
	$stmt->bindColumn(14, $col_del_yn);
	$stmt->bindColumn(15, $col_language_type);
	$stmt->bindColumn(16, $col_mod_date);
	$stmt->bindColumn(17, $col_reg_date);
	$stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
} else {
	$col_popup_seq			= "";
	$col_division				= "";
	$col_order_num			= "";
	$col_subject				= "";
	$col_content				= "";
	$col_input_type			= ($BOARD_INPUT_TYPE) ? "E" : "I";
	$col_link_url				= "http://";
	$col_link_url_mobile	= "http://";
	$col_link_target			= "_self";
	$col_start_date			= "";
	$col_end_date			= "";
	$col_view_yn				= "Y";
	$col_register_ip			= "";
	$col_del_yn				= "";
	$col_language_type		= $search_language_type;
	$col_mod_date			= "";
	$col_reg_date				= "";
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
	$('#start_date').datetimepicker({
		lang:'ko',
		timepicker:false,
		format:'Y-m-d'
	});
	$('#end_date').datetimepicker({
		lang:'ko',
		timepicker:false,
		format:'Y-m-d'
	});
	$('#reg_date').datetimepicker({
		lang:'ko',
		timepicker:false,
		format:'Y-m-d'
	});
});

function check_register() {
	var f = document.frm_ins;

	<?php if ($BOARD_INPUT_TYPE) { ?>
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

function setDate(m, t)
{
	var d1 = new Date(); // 기간별 끝날짜(현재날짜)

	if (t=='y') {
		var d2 = new Date(d1.getFullYear()+m, d1.getMonth(), d1.getDate()); // 기간별(년) 시작날짜
	} else if (t=='m') {
		var d2 = new Date(d1.getFullYear(), d1.getMonth()+m, d1.getDate()); // 기간별(월) 시작날짜
	} else {
		var d2 = new Date(d1.getFullYear(), d1.getMonth(), d1.getDate()+m); // 기간별(일) 시작날짜
	}

	var s1 = d1.getFullYear();
	var s2 = d1.getMonth()+1;
	var s3 = d1.getDate();

	var e1 = d2.getFullYear();
	var e2 = d2.getMonth()+1;
	var e3 = d2.getDate();

	var start_date = document.getElementById("start_date");
	var end_date = document.getElementById("end_date");

	s2 = (s2 < 10) ? "0"+s2 : s2
	s3 = (s3 < 10) ? "0"+s3 : s3
	e2 = (e2 < 10) ? "0"+e2 : e2
	e3 = (e3 < 10) ? "0"+e3 : e3

	start_date.value = s1+"-"+s2+"-"+s3
	end_date.value = e1+"-"+e2+"-"+e3
}

function fnInputType(sValue) {
	if ( sValue == "E" ) {
		$("#input_type_img").hide();
		$("#input_type_edit").show();
	} else {
		$("#input_type_img").show();
		$("#input_type_edit").hide();
	}
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
				<tr <?php if (!$BOARD_VIEW) { ?>style="display:none;"<?php } ?>>
					<th>노출 여부</th>
					<td class="tal">
						<label><input type="radio" name="view_yn" value="Y" <?php If ($col_view_yn == "Y") { ?>checked<?php } ?> />노출 됨</label>&nbsp;
						<label><input type="radio" name="view_yn" value="N" <?php If ($col_view_yn == "N") { ?>checked<?php } ?> />노출 안됨</label>
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
					<th>노출 순서</th>
					<td class="tal">
						<select title="순서" name="order_num">
							<option value="1" <?php if ( $col_order_num == 1 ) echo "selected"; ?>>1</option>
							<option value="2" <?php if ( $col_order_num == 2 ) echo "selected"; ?>>2</option>
							<option value="3" <?php if ( $col_order_num == 3 ) echo "selected"; ?>>3</option>
							<option value="4" <?php if ( $col_order_num == 4 ) echo "selected"; ?>>4</option>
							<option value="5" <?php if ( $col_order_num == 5 ) echo "selected"; ?>>5</option>
							<option value="6" <?php if ( $col_order_num == 6 ) echo "selected"; ?>>6</option>
							<option value="7" <?php if ( $col_order_num == 7 ) echo "selected"; ?>>7</option>
							<option value="8" <?php if ( $col_order_num == 8 ) echo "selected"; ?>>8</option>
							<option value="9" <?php if ( $col_order_num == 9 ) echo "selected"; ?>>9</option>
							<option value="10" <?php if ( $col_order_num == 10 ) echo "selected"; ?>>10</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>노출 기간</th>
					<td class="tal">
						<input type="text" title="시작일" readonly="readonly" id="start_date" name="start_date" value="<?=$col_start_date ?>" style="width:63px" /> ~ 
						<input type="text" title="종료일" readonly="readonly" id="end_date" name="end_date" value="<?=$col_end_date ?>" style="width:63px" />

						<input type="button" value="당일" class="button white" onclick="setDate(0,'d')" />
						<input type="button" value="7일" class="button white" onclick="setDate(7,'d')" />
						<input type="button" value="1개월" class="button white" onclick="setDate(1,'m')" />
						<input type="button" value="3개월" class="button white" onclick="setDate(3,'m')" />
						<input type="button" value="6개월" class="button white" onclick="setDate(6,'m')" />
						<input type="button" value="1년" class="button white" onclick="setDate(1,'y')" />
					</td>
				</tr>
				<tr>
					<th>제목</th>
					<td class="tal"><input type="text" id="" name="subject" value="<?=$col_subject ?>" maxlength="100" style="width:50%" placeholder="제목을 입력하세요." required /></td>
				</tr>
				<tr <?php if (!$BOARD_INPUT_TYPE || $var_Mode == "EDT" ) { ?>style="display:none;"<?php } ?>>
					<th>팝업내용 유형</th>
					<td class="tal">
						<label><input type="radio" name="input_type" value="E" onclick="fnInputType(this.value);" <?php if ( $col_input_type == "E" ) { ?>checked<?php } ?>>에디터</label>
						<label><input type="radio" name="input_type" value="I" onclick="fnInputType(this.value);" <?php if ( $col_input_type == "I" ) { ?>checked<?php } ?>>이미지</label>&nbsp;
					</td>
				</tr>
				<tr id="input_type_edit" <?php if ( $col_input_type == "I" ) { ?>style="display:none;"<?php } ?>>
					<th>내용</th>
					<td class="tal">
						<textarea name="content" id="content_" style="width:100%; height:450px;"><?=$col_content ?></textarea>
						<script>
							nhn.husky.EZCreator.createInIFrame({
							oAppRef: oEditors,
							elPlaceHolder: "content_",
							sSkinURI: "<?=$COMMON_PATH?>/js/se2/SmartEditor2Skin.html",
							htParams : {bUseToolbar : true, fOnBeforeUnload : function(){} }, fOnAppLoad : function(){}, fCreator: "createSEditor2"
							});
						</script>
					</td>
				</tr>
				<tr id="input_type_img" <?php if ( $col_input_type == "E" ) { ?>style="display:none;"<?php } ?>>
					<th>
						<?php
							// 파일 구분
							$file_type = 'attach_one';
						?>
						이미지
						<a href="javascript:setOpenPopup('<?=$COMMON_PATH?>/js/uploader/jquery_ui_widget.php?P=<?=$UPLOAD_PATH?>&B=<?=$BOARD_FILE_PATH?>&D=<?=$search_division?>&T=IMG&callback=<?=$file_type ?>', 'uploader', 1000, 360 );">
							<img src="<?=$IMAGES_PATH?>/common/btn_add.png" style="margin-left:5px;width:20px;height:20px;" align="absmiddle"></a>
					</th>
					<td class="tal">
						<?php
							$var_SQL = " SELECT ";
							$var_SQL .= " FILE_SEQ, FILE_PATH, FILE_NAME, FILE_SAVE, FILE_SIZE, FILE_TYPE, DOWN_COUNT, REG_DATE ";
							$var_SQL .= " FROM ". $BOARD_TABLENAME ."_FILE ";
							$var_SQL .= " WHERE FILE_TYPE='". $file_type ."' AND POPUP_SEQ = :no ";
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
				<tr>
					<th>링크</th>
					<td class="tal"><input type="text" id="" name="link_url" value="<?=$col_link_url ?>" maxlength="100" style="width:50%" placeholder="링크를 입력하세요." required /></td>
				</tr>
				<tr <?php if (!$BOARD_MOBILE_LINK) { ?>style="display:none;"<?php } ?>>
					<th>모바일 링크</th>
					<td class="tal"><input type="text" id="" name="link_url_mobile" value="<?=$col_link_url_mobile ?>" maxlength="100" style="width:50%" placeholder="링크를 입력하세요." required /></td>
				</tr>
				<tr>
					<th>링크 타겟</th>
					<td class="tal">
						<select name="link_target" >
							<option value="">선택</option>
							<option value="_blank"		<?php if ( $col_link_target == "_blank" ) { ?> selected<?php } ?>>새창</option>
							<!-- <option value="_parent"	<?php if ( $col_link_target == "_parent" ) { ?> selected<?php } ?>>부모창</option> -->
							<option value="_self"		<?php if ( $col_link_target == "_self" ) { ?> selected<?php } ?>>현재창</option>
							<!-- <option value="_top"		<?php if ( $col_link_target == "_top" ) { ?> selected<?php } ?>>_top</option> -->
							<!-- <option value="opener"	<?php if ( $col_link_target == "opener" ) { ?> selected<?php } ?>>opener</option> -->
						</select>
					</td>
				</tr>
				<tr <?php if (!$BOARD_REG_DATE) { ?>style="display:none;"<?php } ?>>
					<th>등록일</th>
					<td class="tal">
						<input type="text" title="등록일" readonly="readonly" id="reg_date" name="reg_date" value="<?=$col_reg_date ?>" style="width:63px">
					</td>
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