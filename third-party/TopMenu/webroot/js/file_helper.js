$(document).ready(function () {

	$('.delete-file').on('click', function () {
		return confirm($(this).attr('message'));
	});


});