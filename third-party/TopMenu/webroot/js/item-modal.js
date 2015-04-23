$('a.tab-ajax').on("click", function() {
	$('#contentAjax').load(
			$(this).attr('href')).hide().fadeIn('fast');
	return false;
});
