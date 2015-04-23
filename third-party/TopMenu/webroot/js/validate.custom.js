// override jquery validate plugin defaults
$.validator.setDefaults({
    highlight: function(element) {
        $(element).closest('.form-group').addClass('has-error');
    },
    unhighlight: function(element) {
        $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    },
    errorElement: 'span',
    errorClass: 'help-block',
    errorPlacement: function(error, element) {
        if(element.parent('.input-group').length) {
            error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
    }
});

// Add US Phone Validation
jQuery.validator.addMethod('phoneUS', function(phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, ''); 
    return this.optional(element) || phone_number.length > 9 &&
        phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
    }, 
    'Please enter a valid phone number.'
);

// Add Password Strength Validation
jQuery.validator.addMethod('checkPassword', function(password, element) {
    var score = 0;
    var total = 0;
    var lookup = {
        upper: "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
        lower: "abcdefghijklmnopqrstuvwxyz",
        digits: "0123456789",
        symbols: "!@#$%^&*()_{}|[]\\;\'\",./<>?`~-=_+"
    };
    var occurrences = {
        upper: 0,
        lower: 0,
        mixed: 0,
        digits: 0,
        symbols: 0
    };
    for (var str in lookup) {
        var checkStr = lookup[str];
        for (i = 0; i < password.length; i++) {
            if (checkStr.indexOf(password.charAt(i)) > -1) {
                    occurrences[str]++;
            }
        }
    }
    occurrences.mixed = occurrences.upper + occurrences.lower;
    

/**
 * Password Length
 * Worth: 10 Points
 */
    if (
        password.length    >= 3
        && password.length <= 4
    ) {
        score += 2;
    } else if (
        password.length    >= 5
        && password.length <= 7
    ) {
        score += 5;
    } else if (password.length >= 8) {
        score += 10;
    }
    total += 10;


/**
 * Number of Letters
 * Worth 10 Points
 */

    if (
        occurrences.upper    === 0
        && occurrences.lower !== 0
    ) {
        score += 3;
    } else if (
        occurrences.upper    !== 0
        && occurrences.lower === 0
    ) {
        score += 4;
    } else if (
        occurrences.upper    !== 0
        && occurrences.lower !== 0
    ) {
        score += 5;
    }
    total += 5;

/**
 * Number Digits
 * Worth 10 Points
 */
    if (
        occurrences.digits    >= 1
        && occurrences.digits <= 3
    ) {
        score += 4;
    } else if (occurrences.digits >= 4) {
        score += 5;
    }
    total += 5;

/**
 * Number of Symbols
 * Worth 10 Points
 */
    if (occurrences.symbols >= 1) {
        score += 4;
    } else if (occurrences.symbols > 3) {
        score += 5;
    }
    total += 5;

/**
 * Is Alphanumeric
 * Worth 5 Points
 */
    if (
        occurrences.digits   !== 0
        && occurrences.mixed !== 0
    ) {
        score += 5;
    }
    total += 5;

/**
 * Is Alphanumeric and getoccurrences special chars
 * Worth 5 Points
 */
    if (
        occurrences.digits     !== 0
        && occurrences.mixed   !== 0
        && occurrences.symbols !== 0
    ) {
        score += 5;
    }
    total += 5;
/**
 * is Alphanumeric, getoccurrences special chars, and getoccurrences
 * both upper and lower case letters
 * Worth 10 Points
 */
    if (
        occurrences.digits     !== 0
        && occurrences.upper   !== 0
        && occurrences.lower   !== 0
        && occurrences.symbols !== 0
    ) {
        score += 10;
    }
    total += 10;

    return this.optional(element) || (((score / total) * 100) >= 30);
},'Please enter a valid phone number.');

jQuery.validator.addMethod("cdnPostal", function(postal, element) {
return this.optional(element) || 
postal.match(/[a-zA-Z][0-9][a-zA-Z]/);
}, "Please specify a valid postal code.");

jQuery.validator.addMethod("checkEmail", function(email, element) {
return this.optional(element) || 
email.match(/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}/);
}, "Please specify a valid email address.");



$('#registerForm').validate({ 
    debug: false,
    errorClass: "has-error",
    successClass: "has-success has-feedback",
    errorElement: "p",
    rules: { 
        "data[Profile][first_name]": "required",
        "data[Profile][last_name]": "required",
        "data[User][email]": {
            required: true,
            checkEmail: true
        },
        "data[User][password]" : {
            required: true,
            checkPassword : true
        },
        "data[User][password_confirm]" : {
            required: true,
            equalTo : "#UserPassword"
        },
        "data[Profile][phone]" : {
          required: true,
          phoneUS: true
        }
    },
    invalidHandler: function(form, validator) {
        $('.spinner').hide();   
    },

    submitHandler: function(form, validator) {
        $('.spinner').fadeIn(); 
        form.submit(); 
    }
}); 

$("#delivery").validate({
    debug: false,
    errorClass: "has-error",
    successClass: "has-success has-feedback",
    errorElement: "p",

    rules: {
        "data[Location][postal_code1]": {
            required: true,
            cdnPostal: true
        }
    },
    invalidHandler: function(form, validator) {
        $('#postalCodeModal').modal({
            show: true
        });
        $('.spinner').fadeOut();  
    },

    submitHandler: function(form, validator) {
        $('.spinner').fadeIn(); 
        form.submit(); 
    }
});

$("#modalForm").validate({
    debug: false,
    errorClass: "has-error",
    successClass: "has-success has-feedback",
    errorElement: "p",

    submitHandler: function(form, validator) {
        $('.spinner').fadeIn(); 
        form.submit(); 
    }
});

$('#addNewAddressForm').validate({ 
    debug: false,
    errorClass: "has-error",
    successClass: "has-success has-feedback",
    errorElement: "p",
    rules: { 
        "data[DeliveryAddress][name]": "required",
        "data[DeliveryAddress][address]": "required",
        "data[DeliveryAddress][city]": "required",
        "data[DeliveryAddress][province]": "required",
        "data[DeliveryAddress][phone]" : {
          required: true,
          phoneUS: true
        },
        "data[DeliveryAddress][postal_code]": "required"
    },
    invalidHandler: function(form, validator) {
        $('.spinner').hide(); 
    },

    submitHandler: function(form, validator) {
        $('.spinner').fadeIn(); 
        form.submit(); 
    }

}); 
