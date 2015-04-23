$('div.mobile_result_row').click(function(){
	console.log('test');
	url = $(this).find('a').prop('href');
	location.href= url;
});
