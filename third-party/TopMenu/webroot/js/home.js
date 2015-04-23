$( document ).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();  
});

// Footer Menu Animation
$("#menu-cuisines").click(function(event){
    event.preventDefault();
    $("#secteurs").hide();
    $("#menu-cuisines").toggleClass('active');
    $("#menu-secteurs").removeClass('active');
    $("#cuisines").slideToggle();
});
$("#menu-secteurs").click(function(event){
    event.preventDefault();
    $("#cuisines").hide();
    $("#menu-secteurs").toggleClass('active');
    $("#menu-cuisines").removeClass('active');
    $("#secteurs").slideToggle();
});

// Chat pop up window
function popitup(url) {
    newwindow = window.open(url, 'name', 'height=600,width=800');
    if (window.focus) {
        newwindow.focus()
    }
    return false;
}
// Get first three characters of postal code using reverse geocoding API
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position){
            $.getJSON( "//reverse.geocoder.cit.api.here.com/6.2/reversegeocode.json?prox="+position.coords.latitude+","+position.coords.longitude+",100&mode=retrieveAddresses&app_id=B2tEQPbluM3QmMVi5onW&app_code=WdFEvbedsqSxlvTXAp4xUQ&gen=8", function( data ) {
              var postal_code = data.Response.View[0].Result[0].Location.Address.PostalCode.substring(0, 3);
              $('#LocationPostalCode1').val(postal_code);
            });
        });
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}
