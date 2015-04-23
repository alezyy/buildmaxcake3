    $('a.js-ajax').on("click", function() {
        $('#contentAjax').load(
                $(this).attr('href')
                , function() {
            $(this).fadeIn(300);
        });
        return false;
    });