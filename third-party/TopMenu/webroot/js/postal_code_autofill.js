$(document).ready(function (){
	var postal_code_one = [
	"H1A", "H1B", "H9R", "H9S", "H9W", "H9X", "J0L", "J2A", "J2B", "J2C", "J2E", "J2G", "J7Z", "J2H", "J2J", "J2K", "J2L", "J2M", "J2N", "J2R", "J2S", "J2T", "J2W", "J2X", "J2Y", "J3A", "J3B", "J3E", "J3G", "J3H", "J3L", "J3Y", "J0N", "J3M", "J7K", "J0S", "J6R", "J7J", "J5Y", "J4V", "J5R", "H8R", "H8S", "H8N", "H7A", "J5T", "J6Z", "J5V", "J6N", "J4W", "H1J", "J5Z", "J6J", "H4Y", "H9P", "J6W", "J3X", "J7V", "H3E", "H3Y", "J0K", "J7E", "J3P", "J6V", "J7R", "J3V", "J5C", "J5K", "J7T", "J3N", "J3R", "J3T", "J7B", "J7A", "J9X", "H1P", "H1R", "J5M", "J6E", "J0J", "H4L", "J4P", "J7X", "J5B", "J7M", "J6X", "J6Y", "H4G", "J4B", "J4Z", "G0R", "G0P", "J5J", "G0C", "J0X", "J6T", "J7C", "J7H", "J6K", "G3Z", "PCode", "G0L", "J0E", "J0B", "G0X", "J6S", "J0A", "J0W", "G0A", "J0C", "J5L", "G0S", "H4R", "J0Z", "J0R", "J7Y", "H4S", "J0H", "G0W", "J9Y", "J7P", "J4T", "J3Z", "H1C", "H1E", "H1H", "H1G", "H1L", "H1K", "H1M", "H1N", "H1S", "H1T", "H1V", "H1W", "H1X", "H1Y", "H1Z", "H2A", "H2B", "H2C", "H2E", "H2G", "H2H", "H2J", "H2K", "H2L", "H2M", "H2N", "H2P", "H2R", "H2S", "H2T", "H2V", "H2W", "H2X", "H2Y", "H2Z", "H3A", "H3B", "H3C", "H3G", "H3H", "H3J", "H3K", "H3L", "H3M", "H3N", "H3P", "H3R", "H3S", "H3T", "H3V", "H3W", "H3X", "H3Z", "H4A", "H4B", "H4C", "H4E", "H4H", "H4J", "H4K", "H4M", "H4N", "H4P", "H4T", "H4V", "H4W", "H4X", "H4Z", "H5A", "H7B", "H7C", "H7E", "H7G", "H7H", "H7J", "H7K", "H7L", "H7M", "PCode", "H7N", "H7P", "H7R", "H7S", "H7T", "H7V", "H7W", "H7X", "H7Y", "H8P", "H8T", "H8Y", "H8Z", "H9A", "H9B", "H9C", "H9E", "H9G", "H9H", "H9J", "H9K", "J4G", "J4H", "J4J", "J4K", "J4L", "J4M", "J4N", "J4R", "J4S", "J5A", "J4X", "J4Y", "J5W", "J5X", "J6A", "J7G", "J7L", "J7N", "J7W", "G0Z", "J0T" ];

	$('.postal_code1').typeahead({
		source: postal_code_one,
		items: 8
	});

	$('.postal_code2').typeahead({
		items: 8
	});


	$('.postal_code1').keyup(function () {
		var value = $(this).val();
		if (value.length >= 3) {
			$('.postal_code2').focus();
		}
	});
	$('.postal_code1').blur(function () {
		if ($(this).val().length >= 3) {
			var value = $(this).val();
			$.get('/street_addresses/getPostalCodesPart2/' + value + '.json', function (data) {
				var autocomplete = $('.postal_code2').typeahead();
				autocomplete.data('typeahead').source = data.codes;
			});
		}
	});
});