$(document).ready(function() {
	
	if($('#openModal').html() === 'open'){
		$('#deliveryAddressModalForm').modal('show');
	}
});

$('#change_delivery_address').click(function(){
		$('#deliveryAddressModalForm').modal('show');
		return false;
});