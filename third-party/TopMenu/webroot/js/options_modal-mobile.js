/**
 * On page load set the layout 
 */	
window.onload = function() {

	// hide if checkbox is checked
	if ($("#duplicateChoices").attr('checked')) {				
		$("[duplicate='true']").hide();				
	}
	// show
	else{		
		$("[duplicate='true']").show();		
	}
	
	// also stop please wait animation
	stopPleaseWait();
	
};

//$("form").submit(function (e) {
//  e.preventDefault();
//});


$('#duplicateChoices').click(function(){
	$('#submitBtn').removeAttr('disabled');					// validation
	$(".help-inline").hide();		// validation
	validationModal();										// validation
});


/**
 *  update the price according to quantity and validate input
 */
$("#qty").change(function() {
   	
	// validate
	if ($.isNumeric($(this).val())) {
		
		//  update grand total
//		writeOptionTotal();
	}
	
});

// Catch any change in select box and recaculate the options
$( "select" ).change(function () {
	if ($(this).attr('append') !== 'append') {
	writeOptionTotal();
	}
});  


// hide show second column when the duplicate checbox is toggled
$("#duplicateChoices").change(function() {

	// hide if checkbox is checked
	if ($(this).attr('checked')) {
		$("[duplicate='true']").hide();
	}
	// show
	else {
		$("[duplicate='true']").show();
	}

});



$("#duplicateChoices").change(function(){$(this).attr("checked")?$("[duplicate='true']").hide():$("[duplicate='true']").show()});$("body").addClass("modal-open");$("#modalConfirmation").on("hidden",function(){$("body").removeClass("modal-open")});


function validationModal(){
		disable = false;
	$('.required').each(function() {
		if ($(this).val() === '' && $(this).is(":visible") ) {
			disable = true;	
			$(this).parent().children( ".help-inline" ).show();
		}else{
			$(this).parent().children( ".help-inline" ).hide();
		}
	});
	
	if(disable){
		$('#submitBtn').attr('disabled', 'disabled');
	}else{
		$('#submitBtn').removeAttr('disabled');
	}
}