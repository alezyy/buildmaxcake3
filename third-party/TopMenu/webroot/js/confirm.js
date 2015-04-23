	$('#DeliveryAddressConfirmFormSubmitButton').click(function(event) {		
		$('#DeliveryAddressConfirmForm').submit();
		$('#DeliveryAddressConfirmBillingAddressForm').submit();
		event.preventDefault();
	});
	
	$('#newAddressClickable').click(function(){
		$('#newAddressForm').toggle('slow');
	});