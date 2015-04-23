$( document ).ready(function() { 
    imagePreview();
    affixWidth();
    $('[data-toggle="tooltip"]').tooltip();  
});

// ensure the affix element maintains it width
function affixWidth() {
    
    $('.sidebar-right .sidebar').width($('.sidebar-right').width());

    $('.sidebar-right .sidebar').affix({
        offset: {
            top: 230
        }
    });
}

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

// Tabs menus, infos and ratings
$('[data-toggle="tabajax"]').click(function(e) {
    var $this = $(this),
        loadurl = $this.attr('href'),
        targ = $this.attr('data-target');

    $.get(loadurl, function(data) {
        $(targ).html(data);
        $.ajax({
            dataType: 'script',
            url: '/js/star-rating.js',
            crossDomain:true,
            success: function(response)
            {
                // Whatever
            }
        });
    });

    $this.tab('show');
    return false;
});

// toogle chevron icons + - for the accordion
function toggleChevron(e) {
    $(e.target)
        .prev('.panel-heading')
        .find("i.indicator")
        .toggleClass('fa-minus fa-plus');
}
$('#accordion').on('hidden.bs.collapse', toggleChevron);
$('#accordion').on('shown.bs.collapse', toggleChevron);


// Menu item Image preview on thumbnail hover
this.imagePreview = function(){ 
    /* CONFIG */
        
        xOffset = 10;
        yOffset = 30;
        
        // these 2 variable determine popup's distance from the cursor
        // you might want to adjust to get the right result
        
    /* END CONFIG */
    $("a.preview").hover(function(e){
        this.t = this.title;
        this.title = "";    
        var c = (this.t != "") ? "<br/>" + this.t : "";
        $("body").append("<p id='preview'><img src='"+ this.href +"' alt='Image preview' class='preview' />"+ c +"</p>");                                
        $("#preview")
            .css("top",(e.pageY - xOffset) + "px")
            .css("left",(e.pageX + yOffset) + "px")
            .fadeIn("fast");                        
    },
    function(){
        this.title = this.t;    
        $("#preview").remove();
    }); 
    $("a.preview").mousemove(function(e){
        $("#preview")
            .css("top",(e.pageY - xOffset) + "px")
            .css("left",(e.pageX + yOffset) + "px");
    });         
};


// Ajax links handlers
$("body").on('click', 'a.ajax', function(event){
    event.preventDefault();
    $('.spinner').fadeIn();
    history.pushState({}, '', $(this).attr("href"));
    $.get($(this).attr('href'),{},function(data){
        $('#content').html(data);
        $(this).addClass('active');
        $('.spinner').fadeOut();
        $.ajax({
            dataType: 'script',
            url: '/js/star-rating.js',
            crossDomain:true,
            success: function(response)
            {
                // Whatever
            }
        });
    });
    return false;
});

// Ajax cart links handlers
$("body").on('click', 'a.ajax_cart', function(event){
    event.preventDefault();
    $.get($(this).attr('href'),{},function(data){
        $('#cart').html(data);
        $('#topBarTotal').html(jQuery(data).find('#cartTotal').html());
    });
    $("#cart").load(location.href + " #cart");
    return false;
});

$(document).on('submit', 'form#modalForm', function(event) { 
    event.preventDefault();
    $(this).validate();
    $.ajax({  
        url: $(this).attr('action'),  
        type: $(this).attr('method'),
        data: $(this).serialize(),
        success: function(data){           
            $("#options_modal").modal('hide');
            $('#options_modal .modal-content', this).empty();
            $(this).removeData('bs.modal');
            $('#cart').html(data);
            $('#topBarTotal').html(jQuery(data).find('#cartTotal').html());
        }
    });
});


$(document).on('change', '#billingAddressForm select', function(event) { 
    $.ajax({  
        url: $('#billingAddressForm').attr('action'),  
        type: $('#billingAddressForm').attr('method'),
        data: $('#billingAddressForm').serialize(),
        success: function(data){           
            $("#billingAddress").html(data);
        }
    });
});

$(document).on('change', '#deliveryAddressForm select', function(event) { 
    $.ajax({  
        url: $('#deliveryAddressForm').attr('action'),  
        type: $('#deliveryAddressForm').attr('method'),
        data: $('#deliveryAddressForm').serialize(),
        success: function(data){           
            $("#deliveryAddress").html(data);
        }
    });
});

// destroy menu item options modal after hiding it
$('body').on('hidden.bs.modal', '.modal', function () {
    $('#options_modal .modal-content', this).empty();
    $(this).removeData('bs.modal');
});

// Get first three characters of postal code using reverse geocoding API
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position){
            $.getJSON( "http://reverse.geocoder.cit.api.here.com/6.2/reversegeocode.json?prox="+position.coords.latitude+","+position.coords.longitude+",100&mode=retrieveAddresses&app_id=B2tEQPbluM3QmMVi5onW&app_code=WdFEvbedsqSxlvTXAp4xUQ&gen=8", function( data ) {
              var postal_code = data.Response.View[0].Result[0].Location.Address.PostalCode.substring(0, 3);
              $('#LocationPostalCode1').val(postal_code);
            });
        });
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}
