
$(document).ready(function() {
	
	$('.small_header_title').each(function() {
		
		if ($(this).height() > 40) {
//			$('.small_header_cntnr').height(100);
			$(this).parent('.small_header_cntnr').height(100);
			$(this).parent('.small_header_cntnr').css('background-image', 'url(/img/module_header_bg_small_high.jpg)');

		}
	});
});