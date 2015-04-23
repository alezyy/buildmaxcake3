    //Menu tab
	$('#tab-menu').on("click", function(e) {		// from clicking the button
		e.preventDefault();
		toggleActive($(this));
		$('#contentMenu').show();
		$('#contentAjax').hide();
		return false;
	});	
	
    // Review tab
    $('#tab-reviews').on("click", function(e) {
        e.preventDefault();
        loadContent($(this));
        toggleActive($(this));
        return false;
        
    });
    
    //info tab
    $('#tab-info').on("click", function(e) {
        e.preventDefault();
		loadContent($(this));
        toggleActive($(this));
        return false;
		      
    });
	
// load content
function loadContent(theThis){
	$('#contentMenu').hide();
	 $('#contentAjax').load(theThis.attr('href'));
	 $('#contentAjax').show();
 
}
// Toggle active class on tabs
function toggleActive(theThis){
	$("li").removeClass("active");					// deactivat any previously activated tab
	$(theThis).parent().toggleClass( "active" );	// set the parent li to .active for bootstrap style
	
	if(theThis.attr('id') === 'tab-menu'){					// show collapse all only for the menu tab
		$('#toogleCollapsable').show();
	}else{
		$('#toogleCollapsable').hide();
	}
		
}
    
// CATCHES CHANGES TO THE DELIVERY/TAKE_OUT RADIO BUTTONS
$('[name="data[Order][type]"]').change(function(){
	document.getElementById($(this).prop('value')).submit();
	showPleaseWait();
});


// Return to the previously openened category
$(document).ready(function() {
    var anchor = window.location.hash.replace("#", "");
    $(".collapse").collapse('hide');
    $("#" + anchor).collapse('show');
});

/**
 * Toggle all Collapsable categories
 */
$('#toogleCollapsable').on("click", function(e) {
	
	e.preventDefault();
	showHide = $('#toogleCollapsable').attr('action');
	
	// collapse or hide
	$('.accordion-toggle').each(function() {
		if($(this).attr('data-parent') === '#accordion2'){
			$(this).next().collapse(showHide);
		}
	});

	// change the tab button
	tabHref = (showHide === 'show') ? 'hide' : 'show';
	tabHtml = (showHide === 'show') ? $('#closeAll').val() : $('#showAll').val();
	$('#toogleCollapsable').attr('action', tabHref);
	$('#toogleCollapsable').html(tabHtml);
	return false;
});