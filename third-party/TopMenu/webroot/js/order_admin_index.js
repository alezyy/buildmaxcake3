 $(document).ready(function(){
     
    // Use sessionStorage to keep track of the which timeout orders have been handle (call) by customer service
    var warningRowTable;
    var warningRowArray = [];
    warningRowTable = sessionStorage.getItem("warningRowTable");                // retrieve localstorage data

    if (typeof warningRowTable === 'undefined' || warningRowTable === null){    // FIRST LOAD OF THE SESSION (EMPTY DATASET)

        // Fill empty data set in session storage
        $('.warning').each(function(){
            var rowId = $(this).children(":first").html().trim();               // get id of the row 
            var rowObj = {id:rowId,checked:false};                
            warningRowArray.push(rowObj);
        });

        sessionStorage.setItem('warningRowTable', JSON.stringify(warningRowArray)); // create sessionStorage variable
        warningRowTable = sessionStorage.getItem("warningRowTable");                // retrieve localstorage data

    }else{                                                                      // WE HAVE DATA IN THE SESSIONSTORAGE

        // Update screen and sessionStorage
        var wrt = jQuery.parseJSON( warningRowTable);
        $('.warning').each(function(){                                          // ITERATE ROW OF TABLE IN DOM
            var rowElement = $(this);
            var rowId = $(this).children(":first").html().trim();               // get id of the row                 
            var exist = false;
            for(var i=0; i<wrt.length; i++){                                    // CHECK ROW ALREADY EXIST IN SESSIONSTORAGE

                // Check if row already in dataset                    
                var obj = wrt[i];
                if (obj.id === rowId){                                          

                    exist = true;                                               // THIS ROW IS NOT NEW

                    if (obj.checked === true){                                      
                        rowElement.attr('class', 'error');                      // ROW AS BEEN HANDLE CHANGE IT'S COLOR
                    }
                }                    
            }

            if(!exist){                                                         // ADD MISSING ROW
                var rowObj = {id:rowId,checked:false};                
                warningRowArray.push(rowObj);
            }                
        });

        // add missing row to sessionStorage
        for(var i=0; i<warningRowArray.length; i++){
            wrt[wrt.length] = (warningRowArray[i]);
        }

        sessionStorage.setItem('warningRowTable', JSON.stringify(wrt));

    }
    
    // Catch the 'OK' button for a row to make that row change collor
    $('.okActionButton').click(function(){

        var rowId = $(this).parents('tr').children(":first").html().trim();  // get id of the row                   

        // set the change in the sessionStorage variable
        var wrt = jQuery.parseJSON( warningRowTable);         
        for(var i=0; i<wrt.length; i++){        

            // if id matches then set to false            
            if (wrt[i]['id'] === rowId){
                wrt[i]['checked'] = true;                    
            }                       
        }        
        sessionStorage.setItem('warningRowTable', JSON.stringify(wrt));

        // change row color
        $(this).parents('tr').attr('class', 'error');

    });


	var nowTemp = new Date();
	var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

	var checkin = $('#QueryFrom').datepicker({
		'format': 'yyyy-mm-dd'
	}).on('changeDate', function(ev) {
		if (ev.date.valueOf() > checkout.date.valueOf()) {
			var newDate = new Date(ev.date)
			newDate.setDate(newDate.getDate() + 1);
			checkout.setValue(newDate);
		}
		checkin.hide();
		$('#QueryTo')[0].focus();
	}).data('datepicker');



	var checkout = $('#QueryTo').datepicker({
		'format': 'yyyy-mm-dd'
	}).on('changeDate', function(ev) {
		checkout.hide();
	}).data('datepicker');
});


// Auto reload page every 5min
setInterval(function() {window.location.reload();}, 5 * 1000 * 60); // 5 * 1000 = 5 sec; 5sec * 60 = 60 nub