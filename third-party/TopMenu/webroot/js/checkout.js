/**
 * 
 * Place order button
 */
$('document').ready(function() {
    disableEnablePlaceOrderButton();
    
    // wait for browser to autofill the credit card number field and check if it's valid
    // if not autofill the onkeyup will be use to validate the field    
    window.setTimeout(function(){
        var pccnVal = $("#PaymentCreditCardNumber").val();
        if(pccnVal){
            if(!valid_credit_card(pccnVal)){
                $("#PaymentCreditCardNumber").next('.help-inline').show();
            }else{
                $("#PaymentCreditCardNumber").next('.help-inline').hide();
            }
        }
    }, 2000); // 2 seconds
            
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
$('#OrderSpecialInstruction').change(function() {
    $('#OrderSpecialInstructionCash').val($(this).val());
});

/**
 * 
 * Copy the special instruction field for credit card into the one for cash (this is the only one use in the server side code)
 */
$('#OrderSpecialInstructionCredit').change(function() {
    $('#OrderSpecialInstructionCash').val($('#OrderSpecialInstructionCredit').val());
});


/**
 * 
 * Open confirmation popup
 * 
 */

$('#placeOrderLink').click(function(event) {
    event.preventDefault();
    var valid = true;

    // CLIENT SIDE VALIDATION OF CREDIT CARD FORM
    if ($('input[name=data\\[Payment\\]\\[method_of_payment\\]]:checked').val() === 'creditcard') {

        // hide the flash message
        $('#flashMessage').hide();

        // Name of credit card
        if (!$('#PaymentCreditCardFirstName').val()) {
            valid = false;
            $('#PaymentCreditCardFirstName').next('.help-inline').show();
        } else {
            $('#PaymentCreditCardFirstName').next('.help-inline').hide();
        }

        // Credit Card number
        var regex = new RegExp($('#PaymentCreditCardNumber').attr('pattern'));	// get regex parrtern from input
        if (!$('#PaymentCreditCardNumber').val()) {									// empty
            valid = false;
            $('#PaymentCreditCardNumber').next('.help-inline').show();
        } else if (!$('#PaymentCreditCardNumber').val().match(regex)) {				// Invalid number
            valid = false;
            $('#PaymentCreditCardNumber').next('.help-inline').show();
        } else {
            $('#PaymentCreditCardNumber').next('.help-inline').hide();
        }

        // Expiration date		
        var d = new Date();
        var nowYear = parseInt(d.getFullYear().toString().substr(2, 2));
        var expYear = parseInt($('#PaymentCreditCardExpireYearYear').find(":selected").text());
        var nowMonth = d.getMonth();
        var expMonth = $('#PaymentCreditCardExpireMonth').find(":selected").text();
        if (isNaN(expMonth) || isNaN(expYear)) {										// empty values
            valid = false;
            $('#PaymentCreditCardExpireYearYear').next('.help-inline').show();
        } else if (expYear < nowYear) {												// expired last year
            valid = false;
            $('#PaymentCreditCardExpireYearYear').next('.help-inline').show();
        } else if (expYear === nowYear && expMonth < nowMonth) {						// expired yearlier this year
            valid = false;
            $('#PaymentCreditCardExpireYearYear').next('.help-inline').show();
        } else {
            $('#PaymentCreditCardExpireYearYear').next('.help-inline').hide();
        }

        // CVV2 number
        regex = new RegExp($('#PaymentCreditCardCvv2').attr('pattern'), 'g');	// get regex parrtern from input
        if (!$('#PaymentCreditCardCvv2').val()) {									// empty
            valid = false;
            $('#PaymentCreditCardCvv2').next('.help-inline').show();
        } else if (!$('#PaymentCreditCardCvv2').val().match(regex)) {			// Invalid number
            valid = false;
            $('#PaymentCreditCardCvv2').next('.help-inline').show();
        } else {
            $('#PaymentCreditCardCvv2').next('.help-inline').hide();
        }

        // Delivery Address

        if ($('input[name=data\\[Payment\\]\\[delivery\\]]').length) {

            // if delivery order
            if (!$('input[name=data\\[Payment\\]\\[delivery\\]]:checked').val()) {
                valid = false;
                $('#pleaseChooseDeliveryAddress').show();
            } else {
                $('#pleaseChooseDeliveryAddress').hide();
            }
        } else {

            // Pickup address
            $('#pleaseChooseDeliveryAddress').hide();
        }

        // Billing info
        if (!$('input[name=data\\[Payment\\]\\[billing\\]]:checked').val()) {
            valid = false;
            $('#pleaseChooseBillingAddress').show();
        } else {
            $('#pleaseChooseBillingAddress').hide();
        }


    }

    if (valid)
    {
        $('#modalConfirmation').modal('show');
    }

});

/**
 * Catch the  Confirmation modal button click and call approprate form
 * */
$('#modalConfirmationPlaceOrder').click(function() {
    $('#proceedToPaymentForm').submit();
});



// AESTHETICS



/**
 * Change section button on expansion
 */
$(".collapse").on('show', function() {

    // Left side accordion
    $(this).parent('.accordion-group').children('.accordion-heading').children('.checkout_header_button').children('.accordion-toggle').html($('#i18nCancel').html());

    // Right side accordion
    $(this).parent('.accordion-group').children('.accordion-heading').children('.right').children('a').children('img').prop('src', '/img/checkout/collapse.png');
});

/**
 * Show Add new address form
 */
$('#add_addresse_form_button').click(function(event) {
    event.preventDefault();
    $('#add_addresse_form_hidden').slideToggle();
});


/**
 * Change section button on collapse
 */
$(".collapse").on('hide', function() {
    $(this).on('hidden', function() {

        // Left side accordion						
        $(this).parent('.accordion-group').children('.accordion-heading').children('.checkout_header_button').children('.accordion-toggle').html($('#i18nEdit').html());

        // Right side accordion
        $(this).parent('.accordion-group').children('.accordion-heading').children('.right').children('a').children('img').prop('src', '/img/checkout/expand.png');
    });
});

/**
 * Method payment edit button toggling
 */
$('#edit_payment_method').on('hidden', function() {
    $('#payment_method_edit_button').show();
});
$('#edit_payment_method').on('shown', function() {
    $('#payment_method_edit_button').hide();
});

$('document').ready(function() {
    setTheRightMethodOfPayment();
});

/**
 * Switch the cash and credit card info form
 */
$(".credit_or_cash_radio").change(function() {

    // update session 
    $.ajax({
        url: '/orders/credit_or_cash/' + $(this).prop('value'),
        error: function() {
            alert('Error / Erreur');
        }
    }).done(function(msg) {
        $('#checkout_right_wrapper').html(msg);

        // update text on left side
        updateTextOnLeftSide();
    });

    setTheRightMethodOfPayment();
});

function setTheRightMethodOfPayment() {

    // Change form displayed to user
    if ($("input[type='radio'][name='data\\[Payment\\]\\[method_of_payment\\]']:checked").val() === 'creditcard') {
        $('#creditcard_info').show();
        $('#cash_info').hide();
    } else {
        $('#cash_info').show();
        $('#creditcard_info').hide();
    }
}

$('#termOfUse').change(function() {
    checkoutValidation();
});

// Validation for the creditcard or cash select box
$('#CheckoutMethodOfPayment').change(function() {
    checkoutValidation();
});


/**
 * Addresses
 */

// delivery info
$('input[name=data\\[Payment\\]\\[delivery\\]]:radio').change(function() {

    var addressId = $(this).val();
    window.location = "/delivery_addresses/change_delivery_address_in_session/" + addressId;

});

// Billing info
$('input[name=data\\[Payment\\]\\[billing\\]]:radio').change(function() {

    var addressId = $(this).val();
    window.location = "/delivery_addresses/set_billing_address/" + addressId;
});

/**
 * Reomve the setFlash message after any ajax call as the call itself should generate a new flash message
 */

$(document).ajaxComplete(function() {
    $('#flashMessage').hide();
});


// HIGHLIGHT

$(document).ready(function() {
    var options = {};
    $("#deliveryChargeTotal").effect('highlight', options, 1000);
});

// AJAX SUBMIT FORM


/**
 * Form Submission
 */

/**
 * Check if the given object is declared and is a function 
 * 
 * @param {object} possibleFunction
 * @returns {Boolean}
 * @author http://stackoverflow.com/users/1790/jason-bunting
 */
function isFunction(possibleFunction) {
    return (typeof (possibleFunction) === typeof (Function));
}

$(function() {

    $('#please_wait_spinner').remove();		// supress full page please wait animation
    var _loadingDiv = $("#loadingDiv");		// Please wait animation
    var posting;
    var currentForm;

    $('#ProfileCheckoutForm').submit(function(event) {

        // Prepare posting
        $('.help-inline').remove();	// remove previous error message
        _loadingDiv.show();			// show spinner
        currentForm = $(this);

        // Post data
        posting = $.post($(this).prop('action'), $(this).serialize());

        // Handle response
        posting.done(function(data) {

            _loadingDiv.hide();				// remove spinner
            if (data === '1') {

                // Trigger the page specific success function that should be added after this script
                if (isFunction(handleSuccessfulPost)) {
                    handleSuccessfulPost(currentForm, currentForm.contents());
                } else {
                    $('.successMessage').show();
                }
            } else {

                // Validation errors
                var parseData = $.parseJSON(data);
                currentForm.find('input').each(function() {		// itereate all inputs in form 
                    if (parseData[$(this).prop('id')] !== undefined) {			// If input as an error add the message after it 
                        $(this).after("<div class='help-inline'>" + parseData[$(this).prop('id')] + "</div>");
                    }
                });
            }
        });
        event.preventDefault();
    });
});

/**
 * @description Applies the luhn algorythm to the credit card number entered by the client to make sure it's valid
 * @param {string} value credit card number to validate
 * @returns {Boolean} Valid or not
 * @author https://gist.github.com/DiegoSalazar/4075533
 */
function valid_credit_card(value) {       
    
    console.log('wwww');
    console.log(value);
    
    // Strip spaces from string
    value = value.replace(/\s/g, '');
    console.log(value);
    console.log('vvvv');
    
    // Basic regex for credit card (master card and visa)    
	if (!(/^[4-5] {0,1}([0-9] {0,1}){12,15}$/.test(value))){
        $('#placeOrderLink').attr('disabled', 'disabled');
        return false;
    };

	// The Luhn Algorithm.
	var nCheck = 0, nDigit = 0, bEven = false;
	value = value.replace(/\D/g, "");

	for (var n = value.length - 1; n >= 0; n--) {
		var cDigit = value.charAt(n),
			  nDigit = parseInt(cDigit, 10);

		if (bEven) {
			if ((nDigit *= 2) > 9) nDigit -= 9;
		}

		nCheck += nDigit;
		bEven = !bEven;
	}
    console.log('valid_credit_card: ' + ((nCheck % 10) === 0));
	if((nCheck % 10) === 0){
        $('#placeOrderLink').removeAttr('disabled');
        return true;
    }else{        
        $('#placeOrderLink').attr('disabled', 'disabled');
        return false;
    };
}

$("#PaymentCreditCardNumber").keyup(function(){
    if(!valid_credit_card($(this).val())){
        $(this).next('.help-inline').show();
    }else{
        $(this).next('.help-inline').hide();
    }
});