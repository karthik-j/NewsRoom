if($.cookie("csss")) {
	$("link#switchyuk").attr("href",$.cookie("csss"));
}
if($.cookie("bodybackground")) {
	var bg = $.cookie("bodybackground");
	$('body').css('background', 'url("' + bg + '")');
}

$(document).ready(function() { 
	$("#switcher li a").click(function() { 
		$("link#switchyuk").attr("href",$(this).attr('rel'));
		$.cookie("csss",$(this).attr('rel'), {expires: 365, path: '/'});
		return false;
	});
	$("#bodybg li a").click(function() { 
		var bg = $(this).attr('rel');
		$('body').css('background', 'url("' + bg + '")');
		$.cookie("bodybackground",$(this).attr('rel'), {expires: 365, path: '/'});
		return false;
	});
	
	
	/* OPEN CLOSE PANEL */
	$(".openedit").click(function() { 
		//$(".ganti").animate({left:"-203px"}, 500);
		var $lefty = $('.ganti');
		$lefty.animate({
		  left: parseInt($lefty.css('left'),10) == 0 ?
			-$lefty.outerWidth() :
			0
		});
	});
	
	
	/* LAYOUT */
	$("#layout-switcher").on('change', function() {
		if($(this).val()=='boxed'){
			$('.parentcontainer').addClass('boxed');
			createCookie('boxed', 'true', 1);
		}else{
			$('.parentcontainer').removeClass('boxed');
			eraseCookie('boxed', 'true', 1);
		}
	});
	if (readCookie('boxed') === 'true') {
		$('.parentcontainer').addClass('boxed');
		$("#layout-switcher option[value=boxed]").prop("selected", "selected");
	} else {
		$('.parentcontainer').removeClass('boxed');
		$("#layout-switcher option[value=full]").prop("selected", "selected");
	};
});