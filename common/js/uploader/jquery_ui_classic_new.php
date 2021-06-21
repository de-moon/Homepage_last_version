<script type="text/javascript" src="/common/uploader/js/plupload.full.min.js"></script>
<div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>

<a id="pickfiles" href="javascript:;">[Select files]</a>
<a id="uploadfiles" href="javascript:;">[Upload files]</a>

<br />
<pre id="console"></pre>
 
 
<script type="text/javascript">
// Custom example logic

var	max_count			=	10;
	print_mime_type		=	{title : "files", extensions : "jpg,gif,png,jpeg"};	//허용 확장자
	max_count			=	10;
	var check_flag		=	"";
 
var uploader = new plupload.Uploader({
    runtimes : 'html5,flash,silverlight,html4',
    browse_button : 'pickfiles', // you can pass in id...
    //container: document.getElementById('container'), // ... or DOM Element itself
    url : "/common/uploader/upload_classic.php",
    resize : { width : 500, height : 500, quality : 90 },	//이미지 리사이즈 옵션
	filters : {
				max_file_size : '10mb',
				mime_types: [
					print_mime_type
				]
	},
    // Flash settings
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
 
    init: {
        PostInit: function() {
            document.getElementById('filelist').innerHTML = '';
 
            document.getElementById('uploadfiles').onclick = function() {
                uploader.start();
                return false;
            };
        },
 
        FilesAdded: function(up, files) {
            plupload.each(files, function(file) {
                document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
            });
        },
 
        UploadProgress: function(up, file) {
            document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
        },
 
        Error: function(up, err) {
            document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
        }
    }
});
 
uploader.init();
 
</script>