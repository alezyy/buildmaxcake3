// Maximum time the user waits
attempts = 0;
maxAttempts = $('#maxAttemps').val();           // maximum attemps made by device ('Topmenu.max_attempts' in core.php)
timeout = $('#tiemout_delai').val() * 100;       // interval between query to the database made by the current page (multiply by 10 to have milliseconds)// wifi = 120, sim = 300

console.log('maxAttempts ' + maxAttempts);
console.log('TimeoutDelai from PHP ' + $('#tiemout_delai').val());

refreshIntervalId = window.setInterval(function() {
    
//    $(window).on('beforeunload', function(){
//        return $('#pleaseDontLeave').val();
//    });

	url = $('#check_db').prop('href') ;
	sucess = $('#success_page').prop('href');

	$.ajax({
		url: url+ '/' + attempts,
		success: function(data) { 
            console.log('data ' + data.trim());
			if (data.trim() === 'accepted' || data.trim() === 'approved') {
				
//				// unbind the please don't leave message
//				$(window).unbind('beforeunload');
				
				// go to success page
				success = $('#success_page').prop('href');
				window.location = success;
				
			} else if (data.trim() === 'rejected') {
								
//				// unbind the please don't leave message	
//				$(window).unbind('beforeunload');
				
				// go fail success page
				fail = $('#fail_page').prop('href');
				window.location = fail;
				
			}else {
				attempts++;
				console.log('attempts ' + attempts);
				if (attempts > maxAttempts) {					// stop waiting
					
//					// unbind the please don't leave message
//					$(window).unbind('beforeunload');
				
					clearInterval(refreshIntervalId);
					reject = $('#fail_page').prop('href');
					window.location = reject;
				}
			}
		}        
	});

	return false;
}, timeout);
