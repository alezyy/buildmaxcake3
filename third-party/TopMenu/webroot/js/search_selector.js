$(document).ready(function() {
    
    // Check in the session if the user previousl requested a cusine type to filter the search result
    $.ajax({
        url: '/app/read_session/Search.Cuisines.0',
        error: function() {
            alert('Error / Erreur');
        }
    }).done(function(msg) {
        if (msg) {  // not empty
            console.log(msg);
            filterByCuisineType( msg.replace(/\"/g, ""));   // we are receiving a json object meaning the string is surronded with double quotes
        }
    });
});

/**
 * 
 * @param {string} cuisineType cuisine type to keep
 */
function filterByCuisineType(cuisineType) {
    console.log(cuisineType);

    // Reinititate the the result set
    $('.result_row').each(function() {
        $(this).show();
    });
    $('.separator_horizontal_dim').each(function() {
        $(this).show();
    });

    if ($("option:selected", this).val() !== '0' && $("option:selected", this).val() !== '') {

        // Itereate the result to hide the result not containing the selected cuisine type				
        if ($('.cusineTypesTd')) {

            // Check if the select cuisine type is in this restaurant
            $('.result_row').each(function() {

                // Hide row if it does not have cuisine types 					
                if ($(this).find('.cusineTypesTd').length > 0) {

                    // Hide row if selected cuisine type is not present in it's 					
                    if ($(this).find('.cusineTypesTd').html().search(cuisineType) === -1) {
                        $(this).hide();
                        $(this).next('div').hide();
                    }

                } else {
                    console.log($(this).find('.cusineTypesTd').length);
                    $(this).hide();
                    $(this).next('div').hide();
                }
            });
        }
    }
}

/**
 * Filter by cuisine type when select box in the search bar is selected
 */
$('#cuisineTypesSelect').change(function(event) {
    filterByCuisineType($("option:selected", this).html());
});   