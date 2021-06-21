<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/commonHeader.php";
include_once "./board_info.php";


// ----------------------------------------------------------------------------------------------------
// ## 공통변수 및 사용자정의변수 정의
// ----------------------------------------------------------------------------------------------------

$setParams		= array();
$param				= array();


// ----------------------------------------------------------------------------------------------------
// ## Receive Parameters
// ----------------------------------------------------------------------------------------------------

$search_division						= $BOARD_DIVISION;
$search_language_type			= $mod->trans3($_REQUEST, "search_language_type", "KOR");
$var_category_level					= $mod->trans3($_REQUEST, "category_level", "1");
$var_category_num					= $mod->trans3($_REQUEST, "category_num", "0");



// ----------------------------------------------------------------------------------------------------
// ## 필수 입력 항목 체크
// ----------------------------------------------------------------------------------------------------



// ----------------------------------------------------------------------------------------------------
// ## 페이지 이동 파라미터
// ----------------------------------------------------------------------------------------------------

if ($search_language_type != "") $setParams[] = "search_language_type=".$search_language_type;

$setParams = implode("&amp;",$setParams);


// ####################################################################################################
// ## 
// ####################################################################################################



include_once $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/header.php";
?>
<script type="text/javascript" src="<?=$COMMON_PATH?>/js/tree/dtree.js"></script>
<script type="text/javascript" src="<?=$COMMON_PATH?>/js/jquery.tablednd.js"></script>
<style type="text/css">
.dragRow {
	background-color: #eee;
}

td.showDragHandle {
	background-image: url("<?=$ADMINROOT?>/images/common/updown2.gif");
	background-repeat: no-repeat;
	background-position: center left;
	cursor: move;
}
</style>
<script type="text/javascript">
<!--
	$(function(){
		$('#category_table').tableDnD({
			onDragClass: "dragRow",
			dragHandle: ".dragHandle"
		});

		$("#category_table tr").not(".nodrag").hover(function() {
			  $(this.cells[0]).addClass('showDragHandle');
		}, function() {
			  $(this.cells[0]).removeClass('showDragHandle');
		});
	})
//-->
</script>
<script type="text/javascript">
//<![CDATA[

function fnCategoryGo(category_num, category_level) {
	var f = document.frm_search;
	f.category_num.value = category_num;
	f.category_level.value = category_level;
	f.action = "board_category_list.php";
	f.submit();
}

function fnLevelOpenTo(category_num) {
	d.openTo(category_num, true);
}

function check_register() {
	var f = document.frm_ins;
	if( IsCheck(f.subject, "카테고리명을 입력해주세요.") == false ) return;
	f.mode.value = "NEW"
	//f.action ="board_category_proc.php";
	f.action ="board_category_proc.php";
	f.target="frm_hiddenFrame";
	f.submit();
}

function check_delete(nNum) {
	if(!confirm("정말 삭제 하시겠습니까?")) return;

	var f = document.frm_ins;
	f.mode.value = "DEL"
	f.num.value = nNum
	//f.action = "board_category_proc.php";
	f.action = "board_category_proc.php";
	f.target="frm_hiddenFrame";
	f.submit();
}

function check_modify(nNum) {
	var f = document.frm_ins;
	if( IsCheck(eval("f.subject_"+nNum), "카테고리명을 입력해주세요.") == false ) return;
	f.mode.value = "EDT";
	f.num.value = nNum
	f.subject.value = eval("f.subject_"+nNum+".value")
	//f.action ="board_category_proc.php";
	f.action ="board_category_proc.php";
	f.target="frm_hiddenFrame";
	f.submit();
}

function check_order() {
	var f = document.frm_ins;
	if(!confirm("카테고리 순서를 변경 하시겠습니까?")) return;
	f.mode.value = "ODR";
	//f.action ="board_category_proc.php";
	f.action ="board_category_proc.php";
	f.target="frm_hiddenFrame";
	f.submit();
}

function page_reflash() {
	var f = document.frm_search;
	f.action = "board_category_list.php";
	f.submit();
}

function fnStop(){
	alert("더 이상 등록할 수 없습니다.");
}

window.onload = function() {
	fnLevelOpenTo(<?=$var_category_num?>);
}

//]]>
</script>
</head>
<body>

<?php
include $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/top.php";
include $_SERVER['DOCUMENT_ROOT']."/_site_manager/common/include/left.php";
?>

<div id="wrap">
	<div id="content">

		<h3><div><?=$MENU_BOARD ?> 카테고리 관리</div></h3>

		<form name="frm_search" id="frm_search" method="get">
		<input type="hidden" name="mode"								value="" />
		<input type="hidden" name="search_division"					value="<?=$search_division?>" />
		<input type="hidden" name="search_language_type"		value="<?=$search_language_type?>" />
		<input type="hidden" name="category_level"					value="<?=$var_category_level?>" />
		<input type="hidden" name="category_num"					value="<?=$var_category_num?>" />
		</form>

		<!-- 리스트 테이블 타입01 -->
		<div class="table_list_type01 table_category">

			<table>
				<colgroup>
					<col width="" />
					<col width="" />
				</colgroup>
				<tbody>
					<tr>
						<td class="tl_round">
							<div class="dtree">
								<p><a href="javascript: d.openAll();">모두 펼치기</a> | <a href="javascript: d.closeAll();">모두 접기</a></p>
								<script type="text/javascript">
									<!--
									d = new dTree('d');
									d.config.folderLinks			= true;
									d.config.closeSameLevel	= true;
									d.config.useCookies		= false;
									d.config.useIcons			= true;
									d.config.useLines			= true;
									d.config.useSelection		= true;
									d.config.inOrder				= false;
									<?php
									$cRootSubject = $mod->iif($var_category_num == 0, "<b>카테고리</b>", "카테고리");
									?>
									d.add(0, -1, "<?=$cRootSubject?>", "javascript:fnCategoryGo('','1')");
									<?php
										$var_SQL = " SELECT ";
										$var_SQL .= " CATEGORY_SEQ, LEVEL, SUBJECT, REG_DATE, PARENT_CATEGORY_SEQ ";
										$var_SQL .= " FROM ".$BOARD_TABLENAME."_CATEGORY A ";
										$var_SQL .= " WHERE DEL_YN = 'N' AND DIVISION = ? AND LANGUAGE_TYPE = ? ";
										$var_SQL .= " ORDER BY ORDER_NUM, CATEGORY_SEQ ";
										$stmt = $pdo->prepare($var_SQL);
										$stmt->bindParam(1, $search_division);
										$stmt->bindParam(2, $search_language_type);
										$stmt->execute();
										$totalp = $stmt->rowCount();
										
										If ($totalp > 0) {
											for ($i = 0; $i < $totalp; $i++) {
												$row = $stmt->fetch(PDO::FETCH_ASSOC);
												$col_category_seq					= Trim($row["CATEGORY_SEQ"]);
												$col_category_level					= Trim($row["LEVEL"]);
												$col_category_subject				= Trim($row["SUBJECT"]);
												$col_category_reg_date			= Trim($row["REG_DATE"]);
												$col_parent_category_seq		= Trim($row["PARENT_CATEGORY_SEQ"]);

												if ($col_category_seq == "") $col_category_seq = 0;
												if ($col_parent_category_seq == "") $col_parent_category_seq = 0;
												
												$col_category_subject				= $mod->iif($col_category_seq == $var_category_num, "<b>".$col_category_subject."(".$col_category_seq.")</b>", $col_category_subject."(".$col_category_seq.")");


												If ($BOARD_CATEGORY_DEPTH >= $col_category_level+1){
									?>
									d.add(<?=$col_category_seq?>, <?=$col_parent_category_seq?>, "<?=$col_category_subject?>", "javascript:fnCategoryGo('<?=$col_category_seq?>','<?=$col_category_level+1?>')"); 
									<?php
												}else{
									?>
									d.add(<?=$col_category_seq?>, <?=$col_parent_category_seq?>, "<?=$col_category_subject?>", "javascript:fnStop();"); 
									<?php
												}
											}
										}
										$stmt->closeCursor();
									?>
									document.write(d);

									//-->
								</script>

							</div>
						</td>
						<td class="tr_round">

							<form name="frm_ins" action="" method="post" >
							<input type="hidden" name="mode"							value="NEW" />
							<input type="hidden" name="search_division"				value="<?=$search_division?>" />
							<input type="hidden" name="search_language_type"	value="<?=$search_language_type?>" />
							<input type="hidden" name="category_level"				value="<?=$var_category_level?>" />
							<input type="hidden" name="category_num"				value="<?=$var_category_num?>" />
							<input type="hidden" name="num" >

							<div class="table_view_type01">

								<table id="category_table">
									<colgroup>
										<col width="50px" />
										<col width="" />
										<col width="150px" />
									</colgroup>
									<thead>
										<tr class="nodrag nodrop">
											<th class="tl_round">번호</th>
											<th>제목</th>
											<th class="tr_round">수정</th>
										</tr>
									</thead>
									<tbody>
									<?php
										$j = 0;
										
										$var_SQL = " SELECT ";
										$var_SQL .= " CATEGORY_SEQ, LEVEL, ORDER_NUM, SUBJECT, REG_DATE, PARENT_CATEGORY_SEQ ";
										$var_SQL .= " FROM ".$BOARD_TABLENAME."_CATEGORY A ";
										$var_SQL .= " WHERE DEL_YN = 'N' AND DIVISION = :division AND LANGUAGE_TYPE = :lang_type ";
										$param[] = array(":division"=>$search_division);
										$param[] = array(":lang_type"=>$search_language_type);

										If ($var_category_num != "0") {
											$var_SQL .= " AND PARENT_CATEGORY_SEQ = :PARENT_CATEGORY_SEQ ";
											$param[] = array(":PARENT_CATEGORY_SEQ"=>$var_category_num);
										} else {
											$var_SQL .= " AND PARENT_CATEGORY_SEQ IS NULL ";
										}

										$var_SQL .= " ORDER BY ORDER_NUM, CATEGORY_SEQ ";

										$stmt = $mod->select($pdo, $var_SQL, $param);
										
										$var_number = 1;
										$cnt = $stmt->rowCount();
										if ($cnt > 0) {
											for ($i = 0; $i < $cnt; $i++) {
												$row = $stmt->fetch(PDO::FETCH_ASSOC);
											
												$col_category_seq					= Trim($row["CATEGORY_SEQ"]);
												$col_category_level					= Trim($row["LEVEL"]);
												$col_category_order_num		= Trim($row["ORDER_NUM"]);
												$col_category_subject				= Trim($row["SUBJECT"]);
												$col_category_reg_date			= Trim($row["REG_DATE"]);
												$col_parent_category_seq		= Trim($row["PARENT_CATEGORY_SEQ"]);
									?>
									<tr id="category_table-row-<?=$var_number?>">
										<td class="dragHandle"><?=$var_number?></td>
										<td>
											<input type="hidden" name="category_seq[]" value="<?=$col_category_seq?>">
											<input type="text" id="subject_<?=$col_category_seq?>" name="subject_<?=$col_category_seq?>" value="<?=$col_category_subject?>" maxlength="200" style="width:70%" />
										</td>
										<td>
											<input type="button" value="삭제" class="button rosy" onclick="check_delete('<?=$col_category_seq?>');" />
											<input type="button" value="수정" class="button white" onclick="check_modify('<?=$col_category_seq?>');" />
										</td>
									</tr>
									<?php
												$var_number++;
											}
											$stmt->closeCursor();
										}else{
									?>
									<tr>
										<td colspan="3">목록이 없습니다.</td>
									</tr>
									<?php
										}
									?>
									</tbody>
								</table>

								<div class="table_bottom">
									<div class="left">
										<input type="button" value="순서 변경" class="button white" onclick="check_order();" />
									</div>
									<div class="right"></div>
								</div>
							</div>

							<div class="table_view_type01">
								<table>
									<colgroup>
										<col width="50px" />
										<col width="" />
									</colgroup>
									<tbody>
										<tr>
											<th class="tl_round">등록</th>
											<td class="tr_round tal">
												<input type="text" id="" name="subject" value="" maxlength="200" style="width:70%" />
												<input type="button" value="등록" class="button rosy" onclick="check_register(); " />
											</td>
										</tr>
									</tbody>
								</table>
							</div>

							</form>

						</td>
					</tr>
				</tbody>
			</table>

			<div class="table_bottom">
				<div class="left">
					<a href="board_list.php?<?=$setParams ?>" class="button white">게시판 목록</a>
				</div>
				<div class="right"></div>
			</div>

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