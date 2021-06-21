<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<title>Plupload - Form dump</title>
</head>
<script>
	var recieve						= <?=json_encode($_POST)?>;		//배열로 넘어온 변수
	var recieve_count			= recieve["uploader_count"];		//배열 엘리먼트에서 업로드 파일 갯수 추출
	var upload_type				= recieve["type"];
	var target_element_id		= recieve["callback"];
	var upload_path				= recieve["upload_path"];
	var inner_text					= "";

	inner_text = inner_text+"<div>";
	inner_text = inner_text+"<input type='hidden' id='"+target_element_id+"_count' name='"+target_element_id+"_count' value='"+recieve_count+"' readonly>";

	for(i=0; i<recieve_count; i++){
		inner_text = inner_text+"<div>";

		if(upload_type == "IMG") {
			inner_text = inner_text+"<img src='"+upload_path+recieve["uploader_"+i+"_tmpname"]+"' style='max-width:200px;max-height:200px;'><br>";
		}

		inner_text = inner_text+recieve["uploader_"+i+"_name"]+"("+byteConvertor(recieve["uploader_"+i+"_size"])+")&nbsp;";
		inner_text = inner_text+"<a href='#' class='button rosy' onclick='deleteFile(\""+target_element_id+"_count\", this); return false;'>삭제</a>";
		inner_text = inner_text+"<input type='hidden' id='"+target_element_id+"_orgname_"+i+"' name='"+target_element_id+"_orgname_"+i+"' value='"+recieve["uploader_"+i+"_name"]+"' readonly>";
		inner_text = inner_text+"<input type='hidden' id='"+target_element_id+"_tmpname_"+i+"' name='"+target_element_id+"_tmpname_"+i+"' value='"+recieve["uploader_"+i+"_tmpname"]+"' readonly>";
		inner_text = inner_text+"<input type='hidden' id='"+target_element_id+"_status_"+i+"' name='"+target_element_id+"_status_"+i+"' value='"+recieve["uploader_"+i+"_status"]+"' readonly>";
		inner_text = inner_text+"<input type='hidden' id='"+target_element_id+"_size_"+i+"' name='"+target_element_id+"_size_"+i+"' value='"+recieve["uploader_"+i+"_size"]+"' readonly>";
		inner_text = inner_text+"</div>";
		inner_text = inner_text+"<br/>";
	}

	inner_text = inner_text+"</div>";

	opener.document.getElementById(target_element_id).innerHTML = inner_text;
	self.close();

	function byteConvertor(bytes) {
		bytes = parseInt(bytes);
		var s = ['bytes', 'Kb', 'MB', 'GB', 'TB', 'PB'];
		var e = Math.floor(Math.log(bytes)/Math.log(1024));
		if(e == "-Infinity") return "0 "+s[0]; 
		else return (bytes/Math.pow(1024, Math.floor(e))).toFixed(2)+" "+s[e];
	}
</script>
<body>

</body>
</html>