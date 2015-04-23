runMeter($('#UserPassword').val());
$(document).ready(function() {
	var meter = $('#password_meter_div').detach().show();

	// Init popover/tooltip
	$('#UserPassword').popover({
		html: true,
		title: $('#meter_title').text(),
		content: meter,
		trigger: 'focus',
		placement: 'right'
	});


	$('#UserPasswordConfirm').tooltip({
		title: $('#pw_match').detach().show().text(),
		trigger: 'manual',
		placement: 'top'
	});

	// Hide tooltip when focus changes
	$('#UserPasswordConfirm').focusout(function () {
		$('#UserPasswordConfirm').tooltip('hide');
	});

	// Display tooltip if confirm password is focussed, and
	// passwords match
	$('#UserPasswordConfirm').focus(function () {
		var password = $('#UserPassword').val();
		if ($(this).val() === password && password !== '') {
			$('#UserPasswordConfirm').tooltip('show');
		}
	});

	//Password meter stuff
	$('#UserPassword').keyup(function () {
		$('#UserPasswordConfirm').parent()
								.parent()
								.removeClass('has-error')
								.removeClass('has-success');


		runMeter($(this).val());
	});

	// Check to see if passwords match
	$('#UserPasswordConfirm').keyup(function () {

		if ($('#UserPassword').val() === '') {

			$(this).parent().parent().removeClass('has-error').removeClass('has-success');
			$("#UserPasswordConfirm").tooltip('hide');

		} else if ($(this).val() === $('#UserPassword').val()) {

			$(this).parent().parent().removeClass('has-error').addClass('has-success');
			$("#UserPasswordConfirm").tooltip('show');

		} else {

			$(this).parent().parent().removeClass('has-success').addClass('has-error');
			$("#UserPasswordConfirm").tooltip('hide');

		}
	});
});


function runMeter(password) {
	var password_strength = checkPassword(password);
	var contains = getOccurrences(password);

	reset_meter();

	$('#UserPasswordConfirm').tooltip('hide').val('');
	if (password_strength >= 90) {

		$('#verystrong').show();
		$('#password_meter').addClass('progress-success');
		$('#UserPassword').parent().parent().addClass('has-success');

	} else if (password_strength >= 80) {

		$('#strong').show();
		$('#password_meter').addClass('progress-success');
		$('#UserPassword').parent().parent().addClass('has-success');

	} else if (password_strength >= 60) {

		$('#strong').show();
		$('#password_meter').addClass('progress-info');
		$('#UserPassword').parent().parent().addClass('has-success');

	} else if (password_strength >= 30) {

		$('#average').show();
		$('#password_meter').addClass('progress-warning');
		$('#UserPassword').parent().parent().addClass('has-success');

	} else {

		if (password_strength > 15) {

			$('#weak').css('color', 'white');

		} else {

			$('#weak').css('color', 'black');

		}
		$('#weak').show();
		$('#password_meter').addClass('progress-danger');
	}
	$('.bar').css('width', password_strength + '%');

}
/**
 * Resets the state of the password meter
 * @return {void}
 */
function reset_meter() {
	$('#weak').hide();
	$('#average').hide();
	$('#strong').hide();
	$('#verystrong').hide();
	$('#password_meter').removeClass('progress-danger')
						.removeClass('progress-info')
						.removeClass('progress-success')
						.removeClass('progress-warning');

	$('#password_length').removeClass('text-success');
	$('#lower_case').removeClass('text-success');
	$('#upper_case').removeClass('text-success');
	$('#numbers').removeClass('text-success');
	$('#symbols').removeClass('text-success');

	$('#password_length i').hide();
	$('#lower_case i').hide();
	$('#upper_case i').hide();
	$('#numbers i').hide();
	$('#symbols i').hide();

	$('#UserPassword').parent().parent().removeClass('has-success');
}

/**
 * Checks a password for strength and returns
 * a perctage value based on total_points / total_available_points
 * @param  {string} password
 * @return {float}          Percentage score
 */
function checkPassword(password)
{
	var score = 0;
	var total = 0;
	var occurrences = getOccurrences(password);

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

	return (score / total) * 100;
}
/**
 * Gets number of occurrences in the password
 * @param  {string} password
 * @return {object}
 */
function getOccurrences(password) {
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
	return occurrences;
}