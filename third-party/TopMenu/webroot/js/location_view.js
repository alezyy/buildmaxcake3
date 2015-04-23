    //Menu tab
	$('#tab-menu').on('click', function(e) {		// from clicking the button
		e.preventDefault();
		toggleActive($(this));
		$('#contentMenu').show();
		$('#contentAjax').hide();
		return false;
	});	
	
    // Review tab
    $('#tab-reviews').on('click', function(e) {
        e.preventDefault();
        loadContent($(this));
        toggleActive($(this));
        return false;
        
    });
    
    //info tab
    $('#tab-info').on('click', function(e) {
        e.preventDefault();
		loadContent($(this));
        toggleActive($(this));
        return false;
		      
    });
	
// load content
function loadContent(theThis){
	$('#contentMenu').hide();
	 $('#contentAjax').load(theThis.attr('href'));
	 $('#contentAjax').show();
 
}
// Toggle active class on tabs
function toggleActive(theThis){
	$("li").removeClass("active");					// deactivat any previously activated tab
	$(theThis).parent().toggleClass( "active" );	// set the parent li to .active for bootstrap style
	
	if(theThis.attr('id') === 'tab-menu'){					// show collapse all only for the menu tab
		$('#toogleCollapsable').show();
	}else{
		$('#toogleCollapsable').hide();
	}
		
}
    
// CATCHES CHANGES TO THE DELIVERY/TAKE_OUT RADIO BUTTONS
$('[name="data[Order][type]"]').change(function(){
	document.getElementById($(this).prop('value')).submit();
	showPleaseWait();
});


// Return to the previously openened category
$(document).ready(function() {
    var anchor = window.location.hash.replace("#", "");
    $(".collapse").collapse('hide');
    $("#" + anchor).collapse('show');
});

/**
 * Toggle all Collapsable categories
 */
$('#toogleCollapsable').on('click', function(e) {
	
	e.preventDefault();
	showHide = $('#toogleCollapsable').attr('action');
	
	// collapse or hide
	$('.accordion-toggle').each(function() {
		if($(this).attr('data-parent') === '#accordion2'){
			$(this).next().collapse(showHide);
		}
	});

	// change the tab button
	tabHref = (showHide === 'show') ? 'hide' : 'show';
	tabHtml = (showHide === 'show') ? $('#closeAll').val() : $('#showAll').val();
	$('#toogleCollapsable').attr('action', tabHref);
	$('#toogleCollapsable').html(tabHtml);
	return false;
});

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
$(".deleteOption").on("click", function() {

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
    console.log("writeGrandTotal: " + $("#grandTotal").html());
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
      text.replace(/&/g, "&amp;")
      text.replace(/</g, "&lt;")
      text.replace(/>/g, "&gt;")
      text.replace(/"/g, "&quot;")
      text.replace(/'/g, "&#039;");
}