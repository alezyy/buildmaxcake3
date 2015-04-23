$(function() {	$(".qty-spinner").spinner();});
$('input[id="tip"]').spinner({min: 0, max: 100});
$('input[id="qty"]').spinner({min: 0, max: 100});

$(".qty-spinner").on("spin", function() {
	disableProceedToPayment($(this).val(), $(this).attr('original'));
});