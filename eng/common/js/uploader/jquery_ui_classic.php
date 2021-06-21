<script type="text/javascript" src="/common/uploader/js/plupload.full.min.js"></script>
<input type="text" class="inp01 disable" id="original_file" placeholder="첨부파일" readonly="readonly" />
<input type="hidden" name="attach_one_count" id="attach_one_count">
<input type="hidden" name="attach_one_orgname_0" id="attach_one_orgname_0">
<input type="hidden" name="attach_one_tmpname_0" id="attach_one_tmpname_0">
<input type="hidden" name="attach_result" id="attach_result">
<div  class="file_inp" id="file_box">
	<a id="pickfiles" class="btn02 black" href="javascript:;"><span>찾아보기</span></a>
</div>
 
<script type="text/javascript">
	var	max_count		=	1;
	print_mime_type		=	{title : "files", extensions : "jpg,gif,png,jpeg"};	//허용 확장자
	max_count			=	1;
	var check_flag		=	"";

	var uploader_images = new plupload.Uploader({
		runtimes : 'silverlight,html4',
		browse_button : 'pickfiles',
		url : '/common/uploader/upload_classic.php',	//업로드 실행 파일
		max_file_count: max_count,
		chunk_size : '10mb',
		unique_names : true,

		resize : { width : 500, height : 500, quality : 90 },	//이미지 리사이즈 옵션

		filters : {
					max_file_size : '10mb',
					mime_types: [
						print_mime_type
					]
		},
		flash_swf_url : '/common/uploader/js/Moxie.swf',
		silverlight_xap_url : '/common/uploader/js/Moxie.xap',

		preinit : {
					Init: function(up, info) {
					check_flag	=	"READY";
					log('업로드 준비가 완료 되었습니다.');
					},
					UploadFile: function(up, file) {
					}
		},

		init : {
					PostInit: function() {
						//게시판 등록/수정 버튼 클릭시 실행
						document.getElementById("Register_Check").onclick = function() {
							uploader_images.start();
							return false;
						};
					},

					FilesAdded: function(up, files) {
						check_flag	=	"ADD";

						plupload.each(files, function(file) {
							log('첨부파일명:', file.name);
							wr_file(file.name);
						});
					},

					FileUploaded: function(up, file, info) {
						check_flag	=	"OK";
						wr_file(file.id);
					},

					UploadComplete: function(up, files) {
						check_flag	=	"COMPLETE";
						log('[UploadComplete]');
						check_register();	//업로드 완료 후 해당 폼의 action 실행 혹은 다른 업로드 진행시 객체 실행 추가
					},

					Destroy: function(up) {
						check_flag	=	"DESTROY";
						log('[Destroy] ');
					},

					Error: function(up, args) {
						log('[Error] ', args);
					}
				}
		});

	function log() {
		var str = "";

		plupload.each(arguments, function(arg) {
		var row = "";
		
		if (typeof(arg) != "string") {
			plupload.each(arg, function(value, key) {

				if (arg instanceof plupload.File) {

					switch (value) {
						case plupload.QUEUED:
							value = 'QUEUED';
						break;

						case plupload.UPLOADING:
							value = 'UPLOADING';
						break;

						case plupload.FAILED:
							value = 'FAILED';
						break;

						case plupload.DONE:
							value = 'DONE';
						break;
					}
				}

				if (typeof(value) != "function") {
					row += (row ? ', ' : '') + key + '=' + value;
				}
			});

			str += row + " ";
		} else {
			str += arg + " ";
		}
		});
		//alert(row);
	}
	
	function wr_file(str) {
		//해당 폼의 이름 및 버튼 실행시 진행 내용
		var f = document.frm_ins;

		if(check_flag == "ADD") {
			f.attach_one_orgname_0.value = str;
			f.original_file.value = str;
		}
		else if(check_flag == "OK") {
			if(str != undefined || str != "") {
				f.attach_one_count.value = 1;
			} else{
				f.attach_one_count.value = 0;
			}
			f.attach_one_tmpname_0.value = str;
			f.attach_result.value = "DONE";
		}
		else if(check_flag == "COMPLETE") {
			f.attach_result.value = "DONE";
		}
		else {
			f.attach_one_orgname_0.value = "";
			f.attach_one_tmpname_0.value = "";
		}
	}
	uploader_images.init();	//업로더 초기화	//함수 이름을 변경하여 여러개 가능
</script>