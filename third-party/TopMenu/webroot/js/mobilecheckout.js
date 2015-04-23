/**
	* Increment and Decrement links on form
	* 
	* It is stupid to use jquery to send a request on the server side and then reload the page to refresh the data
	* on the page but this way we can reuse the desktop version which relies on ajax call to do the same thing.
	* I think it's good trade off... I mean: laziness > good sense
	 */
	$('.increment-item').click(function(event){

        showPleaseWait();
        
		// Update the order in the right panel
		$.ajax({            
			url: $(this).prop('href'),
			error: function(){
                stopPleaseWait();
                alert('Error / Erreur');}
		}).done(function(msg){
            stopPleaseWait();
			location.reload(true);
		});			
		event.preventDefault();
	});
	
	$('.decrement-item').click(function(event){
        
        showPleaseWait();
        
		var answer = true;

		// Check if if decrement this item will delete the order because no items will be left in it
		if( $(this).attr('data-qty') === '1' && $('#orderItemsCount').val() === '1'){
			 answer = confirm($('#orderItemsCount').attr('data-message'));
		}

		// Update the order in the right panel
		if(answer){			
			$.ajax({
				url: $(this).prop('href'),
				error: function(){
                    stopPleaseWait();
                    alert('Error / Erreur');}
			}).done(function(msg){
                stopPleaseWait();
				location.reload(true);
			});			
		}
			
		event.preventDefault();
	});
	
	
/**
 * Apply the discount coupon
 */
$('#apply_coupon').click(function(event) {

    showPleaseWait();

    var url = $(this).prop('href') + '/' + encodeURIComponent($('#couponCode').val());
    
    $.ajax({
        url: url,
        error: function() {
            alert('Error / Erreur');
        }
    }).done(function(msg) {
        location.reload(true);
    });

    event.preventDefault();
});