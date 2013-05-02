(function($){
	$('#checksum').on('click', function(){
		$(this).select();
	});

	$('#print').show().on('click', function(){
		window.print();
	});

	$('#nyan').on('click', function(e){
		e.preventDefault();
		var wWidth = $(window).width(),
			wHeight = $(window).height(),
			html = '';

		for (var i=0; i<20; i++){
			html += '<div class="nyancat" style="top:'+Math.random()*wHeight+'px;left:'+Math.random()*wWidth+'px;"></div>';
		}

		if (!$('#nyancat-music').length){
			html += '<iframe id="nyancat-music" width="0" height="0" src="http://www.youtube.com/embed/QH2-TGUlwu4?autoplay=1&loop=1" frameborder="0" allowfullscreen></iframe>';
		}

		var runAnimate = function(){
			$(this).css({left: 0}).animate({left: wWidth}, wWidth * 10, 'linear', runAnimate);
		};

		$('body').append(html);
		$('.nyancat').each(function(){
			var distance = wWidth - $(this).offset().left;
			$(this).animate({left: wWidth}, distance * 10, 'linear', runAnimate);
		});
	});
})(jQuery);