// VALIDATE AND QUANTITY INPUT AND UPDATE GRAND TOTAL

/**
 *	validate quatity input
 */
$('input[id="qty"]').spinner({ min: 1, max: 100});

/**
 * convert click event to change events
 */
$('.ui-spinner-button').click(function() {
   $(this).siblings('input').change();
});
	
/**
 * On model open set the layout 
 */	
$('#modalConfirmation').on('shown', function() {

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
	
});

$('#duplicateChoices').click(function(){
	$('#submitBtn').removeAttr('disabled');					// validation
	$(".help-inline").hide();		// validation
	validationModal();										// validation
});

/**
 * Cancel button
 */
$('#cancelBtn').on("click", function(){
	$('#modalConfirmation').modal('toggle');
});

/**
 * On modal close
 */
$('#modalConfirmation').on('hidden', function() {

	// empty data to avoid adding it to subsequent modal forms	
	optionsSum = [];

});

/**
 *  update the price according to quantity and validate input
 */
$("#qty").change(function() {
   	
	// validate
	if ($.isNumeric($(this).val())) {
		
		//  update grand total
		writeOptionTotal();
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


// Prevent body, behind the modal, from scrolling
$("body").addClass("modal-open");

// re enable scrolling of the body
$("#modalConfirmation").on("hidden", function () {
  $("body").removeClass("modal-open");
});

$('input[id="qty"]').spinner({min:1,max:100});$(".ui-spinner-button").click(function(){$(this).siblings("input").change()});$("#modalConfirmation").on("shown",function(){$("#duplicateChoices").attr("checked")?$("[duplicate='true']").hide():$("[duplicate='true']").show();stopPleaseWait()});$("#cancelBtn").on("click",function(){$("#modalConfirmation").modal("toggle")});$("#modalConfirmation").on("hidden",function(){optionsSum=[]});$("#qty").change(function(){$.isNumeric($(this).val())&&writeOptionTotal()});
$("select").change(function(){
		
	// disable submit button
	validationModal();
	
	// Calculate total price
	"append"!==$(this).attr("append")&&writeOptionTotal();
});

$("#duplicateChoices").change(function(){$(this).attr("checked")?$("[duplicate='true']").hide():$("[duplicate='true']").show()});$("body").addClass("modal-open");$("#modalConfirmation").on("hidden",function(){$("body").removeClass("modal-open")});

/**
 * show the flash message of location/view.ctp in this modal
 */
if($('#flashMessage').length() > 0){
	$('#modalFlashMessage').html($('#flashMessage').html());
	$('#modalFlashMessage').css('display', 'inline-block');
}
$("form").submit(function (e) {
  e.preventDefault();
});

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