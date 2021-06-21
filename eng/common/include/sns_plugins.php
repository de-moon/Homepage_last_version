<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
<script type="text/javascript">
// 사용할 앱의 JavaScript 키를 설정해 주세요.
    Kakao.init('앱키');
 
    // 카카오톡 공유하기 //APP 등록 필수
    function sendKakaoTalk() {
		Kakao.Link.sendTalkLink({
			label: '공유 제목',
			image: {
				src: 'http://이미지경로',
				width: '300',
				height: '200'
			},
			webButton: {
				text: '공유제목',
				url: 'https://도메인' // 앱 설정의 웹 플랫폼에 등록한 도메인의 URL이어야 합니다.
			}
		});
    }
 
    // 카카오스토리 공유하기  //APP 등록 필수
    function shareStory() {
		Kakao.Story.share({
			url: '도메인',
			text: '공유제목'
        });
	}
 
    // send to SNS
    function toSNS(sns, strTitle, strURL, image) {
        var snsArray	=	new Array();
        var strMsg		= strTitle + " " + strURL;
		//var image			= "이미지경로";  핀터레스트 공유시에만 사용
 
		snsArray['twitter']			= "https://twitter.com/intent/tweet?text="+encodeURIComponent(strTitle)+"&url=" + encodeURIComponent(strURL);
		snsArray['facebook']		= "https://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(strURL)+"&t="+encodeURIComponent(strTitle);
		snsArray['pinterest']		= "http://www.pinterest.com/pin/create/button/?url=" + encodeURIComponent(strURL) + "&media=" + image + "&description=" + encodeURIComponent(strTitle);
		snsArray['band']			= "http://band.us/plugin/share?body=" + encodeURIComponent(strTitle) + "  " + encodeURIComponent(strURL) + "&route=" + encodeURIComponent(strURL);
		snsArray['blog']				= "http://share.naver.com/web/shareView.nhn?url="+encodeURIComponent(strURL)+"&title="+encodeURIComponent(strTitle);
        snsArray['line']				= "http://line.me/R/msg/text/?" + encodeURIComponent(strTitle) + " " + encodeURIComponent(strURL);
		snsArray['google']			= "https://plus.google.com/share?url=" + encodeURIComponent(strURL) + "&t=" + encodeURIComponent(strTitle);
        window.open(snsArray[sns]);
    }
</script>