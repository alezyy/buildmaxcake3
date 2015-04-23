$('document').ready(function() {
	disableEnablePlaceOrderButton();
});
$('#terms_checkbox').change(function() {
	disableEnablePlaceOrderButton();
});

function disableEnablePlaceOrderButton() {

	if ($('#terms_checkbox').prop('checked')) {
		$('#modalConfirmationPlaceOrder').removeAttr('disabled');

		// Cash button on mobile site
		if ($('#modalConfirmationPlaceOrderCash').length) {
			$('#modalConfirmationPlaceOrderCash').removeAttr('disabled');
		}
	} else {
		$('#modalConfirmationPlaceOrder').attr('disabled', 'disabled');

		// Cash button on mobile site
		if ($('#modalConfirmationPlaceOrderCash').length) {
			$('#modalConfirmationPlaceOrderCash').attr('disabled', 'disabled');
	}
}
}

/** 
 *	Copy the value of the special_instruction field into the it's clone field (for the mobile site only) in the cash form
 */
$('#OrderSpecialInstruction').change(function(){
	$('#OrderSpecialInstructionCash').val($(this).val());
});