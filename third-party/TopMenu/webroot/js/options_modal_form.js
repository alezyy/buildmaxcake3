var optionsSum = new Array();


// Catch any change in select box and recaculate the options
$( "select" ).change(function () {
	if ($(this).attr('append') !== 'append') {
		writeOptionTotal();
	}
}); 

// Add items option to the form
$(".addOption").on("click", function() {

	var id = '';
	var selId = '';
	var addItemId = '';
	var addItemNiceName = '';
	var addItemPrice = 0;
	var addItemNicePrice = '';

	id = $(this).attr('id');
	inputId = $(this).attr('inputId');
	selId = id.replace('btn_', '');
	
	// dont do nothing if empty option (idnex 0) is selected
	if (document.getElementById(selId).selectedIndex === 0) {
		return false;
	}
	
	
	inputId = $('#' + selId).find(":selected").attr('optionId');
	addItemId = $('#' + selId).find(":selected").val();// attr('value');
	addItemNiceName = $('#' + selId).find(":selected").attr('nameonly');
	addItemPrice = parseFloat($('#' + selId).find(":selected").attr('price'));
	addItemNicePrice = $('#' + selId).find(":selected").attr('niceprice');
	whatHalf = $('#' + selId).attr('half');
	optionsSum.push(addItemPrice);
	osl = optionsSum.length;

	


	// output item list to user	
	var outputSelected = "<tr id='tr_" + osl + "'><td>"; // texte to display
	outputSelected += "<input name='data[MenuItemOptionValues][NotRequired][Extras][0][Entities][" + whatHalf + "][" + osl + "]' type='hidden' value ='" + addItemId + "' />";
	outputSelected += "<input class='readonlyList' readonly='readonly' value ='" + escapeHtml(addItemNiceName) + "' />";
	outputSelected += "</td><td>";
	outputSelected += "<input class='readonlyListPrice' priceindex='" + osl + "' readonly='readonly' value ='" + addItemNicePrice + "' />";
	outputSelected += "<button class='btn btn-danger deleteOption' id='delBtn_" + osl + "' type='button'>-</button>";	// delete button
	outputSelected += "</td></tr>";
	$('#extraList-' + whatHalf + ' > tbody:last').append(outputSelected);

	// count and write total
	writeOptionTotal();

});


// delete the selected extra form the list
$("table.item_option-modal").on("click",  "button.deleteOption", function() {
        

	id = $(this).attr('id').replace('delBtn_', '');	// row id and array index

	// substract the rows price from the total
	optionsSum[id - 1] = 0;

	// delete entire row
	$('tr#' + "tr_" + id).remove();

	// count and write total
	writeOptionTotal();

});


/**
 *  update the price according to quantity and validate input
 */
$("#qty").change(function() {
	// validate
	if ($.isNumeric($(this).val())) {

		//  update grand total
		writeOptionTotal();
	}

});

// hide show second column when the duplicate checbox is toggled
		$("#duplicateChoices").change(function() {

	// hide if checkbox is checked
	if ($(this).attr('checked')) {
		$("[duplicate='true']").hide();
	}
	// show
	else {
		$("[duplicate='true']").show();
	}

});

/**
 * 
 * @returns {Number}	total of all the selected option of all the select box
 */
function selectBoxTotal() {

	total = 0;
	i = 0;

	// add all selected option price from select boxes
	$('select').each(function() {	
		if( $(this).find(":selected").attr('price') &&
			$(this).attr('append') !== 'append'){
			total += parseFloat($(this).find(":selected").attr('price'));
			i++;
		}
	});

	return total;
}

/**
 * Calculate options total
 * 
 * @returns {Number}
 */
function writeOptionTotal() {
	total = 0;
	
	

	// calculaite
	for (var i = 0; i < optionsSum.length; i++) {
		total += optionsSum[i];
	}

	// output
	$('#extrasTotalPriceTd').show();
	$("#extrasTotalPriceTd").html(toCurrentCurrencyFormat( total.toFixed(2)));

	total += selectBoxTotal();
	writeGrandTotal(total);

	return total;
}

/**
 * Calculate the item's total
 * 
 * @param {type} optionTotal
 * @returns {writeGrandTotal.itemPriceFloat}
 */
function writeGrandTotal(optionTotal) {

	// get item price
	var itemPriceStr = $("#grandTotal").html();
	var itemPriceFloat = parseFloat($("#itemPrice").val());	

	// calculate
	var total = (itemPriceFloat + optionTotal) * parseInt($("#qty").val());
	// write
	$("#grandTotal").html(toCurrentCurrencyFormat( total));

	return total;
}

/**
 * Formats the currency accordingly to the current localisation of the user (fr_CA or en_CA)
 * 
 * @param {float} amount			Amount to be formated
 * @returns {string}				formated price
 */
function toCurrentCurrencyFormat(amount) {
	var num = new Number(amount);
	outputString =  num.toFixed(2);
	switch  ($('#user_i18n').val()) {
		case 'fr_CA' :		
			outputString = outputString + ' $';
			break;
		case 'en_CA' :
			outputString = '$ ' + outputString;
			break;
	}
	
	return outputString;

}

/**
 * Validated fields before submitting
 */
$('#modalFormForm').submit(function() {

	valid = true;	// flag
	var total = $('#grandTotal').html();
	total = total.replace('$', '');
	total = total.replace(' ', '');		
	
	// required inputs
	$("input[required]").each(function() {
		if ($(this).val() === '') {
			valid = false;
		}
	});

	$("select[required]").each(function() {
		if ($(this).find(":selected").index() === 0) {

			$(this).parent().addClass('error');
			$('#submit-button-control').addClass('error');

			$(this).next().css('display', 'block');
			$('#submit-button-help').css('display', 'block');

			valid = false;
		} else {
			$(this).parent().removeClass('error');
			$('#submit-button-control').removeClass('error');

			$(this).next().css('display', 'block');
			$('#submit-button-help').css('display', 'none');
		}
	});

	

	return valid;

});


function escapeHtml(text) {
  return text
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
}