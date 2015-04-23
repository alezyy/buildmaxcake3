/**
 * Initiates GeoLocation
 * @return {[type]} [description]
 */
function initiate_geolocation() {    
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(handle_geolocation_query, handle_geolocation_error);
	} else {
		$('#please_wait_spinner').fadeOut();
	}  
}

/**
 * Handles the AJAX call to Google once we have a location
 */
function handle_geolocation_query(position){
	var latitude  = position.coords.latitude;
	var longitude = position.coords.longitude;

	var payload = {
		"latlng": latitude + ',' + longitude,
		"sensor": false
	};

	$.get( "https://maps.googleapis.com/maps/api/geocode/json", payload ,function( data ) {
		if (data != null && data.status == 'OK') {
			var postal_code = extractFromAddress(data.results[0].address_components, 'postal_code');
			postal_code     = postal_code.substring(0,3);

			$('.postal_code').val(postal_code);
			setCookie('CakeCookie[postal_code]', postal_code, 10);
		}
//		$('#please_wait_spinner').fadeOut();
        $('#submit_home').click();
	});
}

/**
 * Called when an error occurs (no location available for example)
 * Hide the layover...
 */
function handle_geolocation_error(error) {
    alert("Erreur / Error\nNous ne pouvons vous localiser\nWe could not locate you");
	$('#please_wait_spinner').fadeOut();
}

/**
 * Extracts a component from the response Google gives us
 */
function extractFromAddress(components, type){
    for (var i = 0; i < components.length; i++) {
        for (var j = 0; j < components[i].types.length; j++) {
            if (components[i].types[j] == type) {
            	return components[i].long_name;
            }
	    }
	}
    return "";
}

/**
 * Gets the value of a cookie we've set
 */
function getCookie(cname) {
	var name = cname + "=";
	var ca   = document.cookie.split(';');

	for(var i = 0; i < ca.length; i++) {
		var c = ca[i].trim();
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

/**
 * Set a cookie
 * @param string   cname   Name of the Cookie
 * @param string   cvalue  Value of the cookie
 * @param int      expire  Number of minutes until the cookie expires
 */
function setCookie(cname, cvalue, expire) {
	var d = new Date();
	d.setTime(d.getTime() + (expire * 60 * 1000));

	var expires     = "expires=" + d.toGMTString();
	document.cookie = cname + "=" + cvalue + "; " + expires;
}


$('#geolocate_me').click( function(){$('#please_wait_spinner').show();initiate_geolocation()});