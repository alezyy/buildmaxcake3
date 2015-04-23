(function() {

    var itemUrl = '';

    $('a.tab-ajax').on("click", function() {
        $('#contentAjax').load(
                $(this).attr('href')).hide().fadeIn('fast');
        return false;
    });

    /**
     * Add tip (call seo javascript function before submitting)
     */

    $('.add_tip').click(function(e) {
        e.preventDefault();
        window.location = $(this).prop('href');
    });


    /**
     * Check in the url if a modal is expected to be open on load
     * 
     */
    $(document).ready(function() {
        var urlParameter = location.search;					// get parameter from URL 
        if (urlParameter.charAt(0) === '?') {				// check if parameter is for this function
            urlParameter = urlParameter.substr(1);
            $('a.item-ajax').each(function() {				// Find link in the page with the item id provided in the URL
                if ($(this).attr('href').indexOf(urlParameter) >= 0) {
                    $(this).click();						// Click that link;
                }
            });
        }
    });

    /**
     * Add item to basket 
     */
    $('a.item-ajax').on("click", function(event) {

        event.preventDefault();

        // check if user has a postal code in session
        var locationId = $('#OrderLocationId').val();
        itemUrl = $(this).attr('href');
        console.log(itemUrl);

        $.ajax({
            url: '/delivery_addresses/check_user_has_delivery_address/' + locationId
        }).done(function(data) {
            if (data.trim() !== '1') {

                console.log('data: ' + data);
                // open postal code prompt modal
                $('#postal_code_prompt_box').modal('show');
                $('#prompt_box_error_message').html(data);
                $('#please_wait_spinner').remove();
            } else {
                console.log(itemUrl);
                loadOptionModalForm(itemUrl);
            }
        });

        return false;
    });

    /**
     * Load the menu item option form
     * @param {string} itemUrl link clicked
     * @returns {Boolean}
     */
    function loadOptionModalForm() {
        console.log(itemUrl);
        $('#option').load(
                itemUrl,
                function() {
                    $('#modalConfirmation').modal('toggle');
                    rescale('#modalConfirmation');
                    /**
                     * show the flash message of location/view.ctp in this modal
                     */
                    if ($('#flashMessage').length > 0) {
                        $('#flashMessage').html($('#flashMessage').html());
                    }
                    $('#please_wait_spinner').remove();
                }
        );

        return false;
    }

    $('a.image-ajax').on('click', function() {
        $('#option').load(
                $(this).attr('href'),
                function() {
                    $('#modalConfirmation').modal('toggle');
                    rescale('#modalConfirmation');
                }
        );
        return false;
    });

    $('a.future-ajax').on("click", function() {
        return false;
    });


    $('a.future-ajax').on("click", function() {
        $('#option').load(
                $(this).attr('href'),
                function() {
                    $('#modalConfirmation').modal('toggle');
                    rescale('#modalConfirmation');
                }
        );
        return false;
    });


// rescale modal according to window
    function rescale(modalId) {

        var size = {
            height: $(window).height()
        };

        // CALCULATE SIZE
        var offset = 20;
        var offsetBody = 300;

        // SET SIZE

        $('.modal-body').css('max-height', size.height - (offset + offsetBody));

        // only use the appropriate height
        if ($('.modal-body').height() < size.height - 100) {
            $(modalId).css('height', $('.modal-body').css('max-height') + 100);
        }

        // 
        else {
            $(modalId).css('height', size.height - offset);
            $(modalId).css('top', 0);
        }
//	}
    }
    $(window).bind("resize", rescale);


    /*
     * Postal code prompt box
     */
    $('#prompt_box-postal_code_button').click(function() {

        $.ajax({
            url: '/delivery_addresses/add_postal_code/' + $('#prompt_box-postal_code_input').val()
        }).done(function(data) {

            if (data) {

                // Display validation error message
                $('#prompt_box_error_message').show();
            } else {
                $('#postal_code_prompt_box').modal('hide');
                console.log(itemUrl + ' one');
                loadOptionModalForm(itemUrl);
                $('#please_wait_spinner').hide();
            }
        });
    });
})();