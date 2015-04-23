$('a.item-ajax').on("click", function() {	
//	window.open($(this).attr('href'),"","width=200,height=100");
	window.open('http://google.com',"","width=200,height=100");
	return false;
});
$('a.future-ajax').on('click', function() {	
		$('#option').load(
			$(this).attr('href'),
			function(){
				$('#modalConfirmation').modal('toggle');
			}
		);
	return false;
});
