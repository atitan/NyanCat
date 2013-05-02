(function($){
	if (!localStorage || localStorage.ienotify != '1'){
		var strings = ['這是禁止事項', '說好不提 IE 的...', '真是的，IE 真是太棒了！', '不好的是微軟，IE 並沒有錯', 'IE 還能再戰十年', 'IE 果然棒！', 'IE 超好用的！你有什麼不滿嗎！', '我有 IE 我超強的喔喔喔！', 'IE 的ㄋㄟㄋㄟ讚！', '不是 IE，是 Internet Explorer', 'IE？那是什麼？能吃嗎？'],
			content = '<div id="fuckyouie">'+
			'<div class="back"></div>'+
			'<div class="container">'+
				'<div class="wrapper">'+
					'<div class="cover">'+
						'<img src="images/QB/index.jpg">'+
					'</div>'+
					'<div class="content">'+
						'<h3>會 Lag 嗎？這不是您的錯！是微軟！</h3>'+
						'<div class="entry">事實上您正在使用全世界最棒的瀏覽器下載工具，只要和 QB 締約即可享有快速且安全的瀏覽器！</div>'+
						'<h4>簽契約</h4>'+
						'<div class="browsers">'+
							'<a href="http://moztw.org" target="_blank" title="Firefox"><img src="images/browsers/firefox.jpg"></a>'+
							'<a href="http://www.google.com/chrome" target="_blank" title="Google Chrome"><img src="images/browsers/chrome.jpg"></a>'+
							'<a href="http://www.opera.com" target="_blank" title="Opera"><img src="images/browsers/opera.jpg"></a>'+
							'<a href="http://www.apple.com/tw/safari/download" target="_blank" title="Safari"><img src="images/browsers/safari.jpg"></a>'+
							'<div class="clearfix"></div>'+
						'</div>'+
						'<h4>或者...</h4>'+
						'<a href="javascript:void(0)" class="close">'+strings[parseInt(Math.random()*strings.length)]+'</a>'+
					'</div>'+
				'</div>'+
			'</div>'+
		'</div>';

		setTimeout(function(){
			$('body').append(content);
			$('#fuckyouie').fadeIn(300).on('click', '.close', function(){
				$('#fuckyouie').fadeOut(300);
			});
			localStorage.ienotify = '1';
		}, 10000);
	}
})(jQuery);