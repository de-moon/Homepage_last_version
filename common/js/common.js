$(function(){

	var win = $(window);
	var vh = 0;
   $(window).load(function(){
		$('#header').addClass('load');
	//	$('#wrap.sub').find('#header').addClass('bgbg');
	});

	$('.winH').height(win.height());
    $(window).on('load resize',function(){
        $('.winH').height($(this).height());
        vh = $(window).height();
		if( $(this).width() < 1200 ){
			$('#left_menuWrap').removeClass('load');
			$('.mobileTab').removeClass('active');
		}else{
			$('#left_menuWrap').addClass('load');
		}
    });

	$('.langBox').click(function(){
		if( $(this).hasClass('on') ){
			$(this).removeClass('on');
			$('.langBox li.hide').hide(0);
		}else{
			$(this).addClass('on');
			$('.langBox li.hide').show(0);
		}
	});

	$('.btn_all_menu').click(function(e){
		e.preventDefault();
		if( $(this).hasClass('active') ){
			$('.allMenuWrap ').fadeOut(400);
		//	$('.allMenuWrap ').removeClass('show');
			$('#header').removeClass('active');
			$('.btn_all_menu').removeClass('active');
			$('.langBox').removeClass('active');
			$('.langBox li.hide').hide(0);
		}else{
			$('.allMenuWrap').fadeIn(400);
		//	$('.allMenuWrap ').addClass('show');
			$('#header').addClass('active');
			$('.btn_all_menu').addClass('active');
			$('.langBox').addClass('active');
		}
	});


	$('.allMenu > li > span').click(function(){
		if( $(this).parent().find('ul').css('display') == 'block' ){
			$(this).parent().find('ul').hide();
		}else {
			$('.allMenu li ul').hide();
			$(this).parent().find('ul').show();
		}
	});

	$(window).on('load resize', function(){
		if(window.innerWidth > 1024){
			$('#header').removeClass('active');
			$('#header .allMenuWrap').hide();
			$('.btn_all_menu').removeClass('active');
			$('.langBox').removeClass('active');
			$('.langBox li.hide').hide(0);
		}
	});

	
	/* 반응형 테이블 스와이프아이콘 노출 & 비노출  */
	$(window).on('load resize',function(){
		$('.tblArea').each(function(){
			if($(this).find('table').width() > $(this).width()){
				$(this).addClass('swipe');
			}else{
				$(this).removeClass('swipe');
			}
		});

		$('.swipeWrap').each(function(){
			if($(this).find('.swipe_item').width() > $(this).width()){
				$(this).addClass('swipe');
			}else{
				$(this).removeClass('swipe');
			}
		});
	});

	$('.tblWrap, .swipeWrap').on({ 'touchstart' : function () {
		$(this).addClass('active'); 
		}, 'touchend' : function () { 
			$(this).removeClass('active'); 
		}
	});

	$(window).on('load resize',function(){
	// Hide Header on on scroll down
		var didScroll = false;
		var lastScrollTop = 0;
		var delta = 5;
		var navbarHeight = $('#header').outerHeight();

		$(window).scroll(function(event){
			
			//$('#header').addClass('scrolled');
			didScroll = true;
		});

		
			setInterval(function() {
				if (didScroll) {
					hasScrolled();
					didScroll = false;
				}
			}, 0);


		

		function hasScrolled() {
			var st = $(this).scrollTop();
			
			// Make sure they scroll more than delta
			if(Math.abs(lastScrollTop - st) <= delta)
				return;
			
			// If they scrolled down and are past the navbar, add class .nav-up.
			// This is necessary so you never see what is "behind" the navbar.
			
			//console.log(st-lastScrollTop);

			
			if (st > lastScrollTop && st > navbarHeight){
				// Scroll Down
				if($('#header').hasClass('active')){
				
				}else{
					$('#header').removeClass('nav-up').addClass('nav-down');
				}
				
			} else {
				// Scroll Up
				if(st + $(window).height() < $(document).height()) {
					$('#header').removeClass('nav-down').addClass('nav-up');
				}
			}
			
			lastScrollTop = st;
		}

		if(window.innerWidth > 1400){
			$('#header .gnbWrap #gnb > li > .dep2').removeAttr('style');
		}
	});

	$(window).on('load scroll', function(){
		$('#header').addClass('load');
		$('#wrap.sub').find('#header').addClass('bgbg');

		if($('.subVisual ').length > 0 ){
			if($(window).scrollTop() >=  $('#header').outerHeight()){
				$('#header').removeClass('bgbg2');
			}else{
				$('#header').addClass('bgbg2');
			}
		}else{
			if($(window).scrollTop() >=  ($(window).height() - $('#header').outerHeight())){
				$('#header').addClass('bgbg');
			}else{
				$('#header').removeClass('bgbg');
			}
		}
	});

	$('#scrTop').click(function(e){
		e.preventDefault();
		$('html, body').animate({scrollTop: '0'}, 650, 'easeInCubic');	
	});

	$(window).on('load resize', function(){

	});
	
	/* gogo js */ 

	$.fn.isInViewport = function() {
	  var elementTop = $(this).offset().top;
	  var elementBottom = elementTop + $(this).outerHeight();

	  var viewportTop = $(window).scrollTop();
	  var viewportBottom = viewportTop + $(window).height();

	  return (elementBottom > viewportTop + (vh/18))  && (elementTop < viewportBottom - (vh/18)) ;
	};

	$.fn.isInViewport2 = function() {
	  var elementTop = $(this).offset().top;
	  var elementBottom = elementTop + $(this).outerHeight();

	  var viewportTop = $(window).scrollTop();
	  var viewportBottom = viewportTop + $(window).height();

	  return elementBottom > viewportTop && elementTop < viewportBottom;
	};

	$(window).on('load resize scroll',function(){
		

		$('.subVisual, .subTit, .subContTit, .solutionSecTit, .solutionSecTit + p, .mc3_slide_sec1 ').each(function(){
			if($(this).isInViewport()){
				$(this).addClass('on');
			}
		});
		
		
		$('.aniBox').each(function(){
			if($(this).isInViewport()){
				$(this).addClass('gogo');
			}
		});

		$('.aniBox2').each(function(){
			if($(this).isInViewport2()){
				$(this).addClass('gogo');
			}
		});
	});




	
	/* elements height 동일하게 */
	$(function(){
		function height_set(){
			var heights = $(".sameHeight").map(function (){
				return $(this).height();
			}).get();
			maxHeight = Math.max.apply(null, heights);
			$(".sameHeight").each(function(){
				$(this).height(maxHeight);
			});
		}
		height_set();
		$(window).on('load resize',function(){
			$(".sameHeight").removeAttr('style');
			height_set();
		});
	});
	
});


