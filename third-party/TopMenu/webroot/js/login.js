$(document).ready(function  () {
	var okToSubmit = false;
	$('form').submit(function (e) {
		if( !okToSubmit ) {
			e.preventDefault();
			$('#UserUsername').attr('readonly', true);
			$('#UserPassword').attr('readonly', true);
			setTimeout(function () {
				okToSubmit = true;
				$('form').submit();
			}, 2000);
		}
	});

});