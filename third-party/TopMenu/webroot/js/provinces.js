$(document).ready(function(){
  $('#country').on('change', function() {
	doCountryAjaxCall($(this).val());
	});
});

function doCountryAjaxCall(target) {
	if(target.length !== 0) {
		if(!$.getJSON('/users/get_provinces/' + target, function(provinces) {
			populateProvincesList(provinces);
		})){
			populateProvincesList(0);
		}
	}
}
function populateProvincesList(provinces) {
  var options = '';
  if(provinces !== null && $.each(provinces, function(index, Province) {
	options += '<option value="' + index + '">' + Province + '</option>';
  })) {
	//continue;
  } else {
	options += '<option value="">N/A</option>';
  }
  $('#provinces').html(options);
}
/*
// Geolocation

var url = 'https://www.geoplugin.net/json.gp?jsoncallback=?';

$(document).ready(function() {
	if($('#country option:selected').val() == '') {
		$.getJSON(url)
			.success(function(data){
				var country_code = data.geoplugin_countryCode;
				var name = data.geoplugin_regionName;
				$('#country option[value=' + country_code + ']').attr('selected', 'selected');
				doCountryAjaxCall(country_code);
				$('#country').ajaxComplete(function () {
					$('#provinces option[value="' + name + '"]').attr('selected', 'selected');
				});

			});
	}

});
*/