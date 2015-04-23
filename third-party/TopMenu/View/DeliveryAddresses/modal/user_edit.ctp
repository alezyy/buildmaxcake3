<style>
	.form-horizontal .controls{
		margin-left: 0;
	}
</style>
<div class="successMessage" style="display: none;">
	<?php echo __('Data saved') ?>
</div>
<?php echo $this->Form->create('DeliveryAddress', 
		array(
			'url' => array('controller' => 'delivery_addresses', 'action' => 'user_edit'),
			'default' => false)); ?>
<fieldset style="padding-right: 50px">            
	<?php
	echo $this->Form->input('name', array('label' => __('Address Label')));
	echo $this->Form->input('phone');
	echo $this->Form->input('address');
	echo $this->Form->input('address2');
	echo $this->Form->input('city');
	echo $this->Form->input('postal_code');
	echo $this->Form->input('cross_street');
	echo $this->Form->hidden('id', array('id' => '53689354809'));
	?>
    <?php
echo $this->Form->end(
	array(
		'class' => 'btn btn-danger pull-right',
		'label' => __('Save')
	)
);
?>
</fieldset>

<script>
/**
 * Form Submission
 */

/**
 * Check if the given object is declared and is a function 
 * 
 * @param {object} possibleFunction
 * @returns {Boolean}
 * @author http://stackoverflow.com/users/1790/jason-bunting
 */
function isFunction(possibleFunction) {
  return (typeof(possibleFunction) === typeof(Function));
}

$(function() {

	$('#please_wait_spinner').remove();		// supress full page please wait animation
	var _loadingDiv = $("#loadingDiv");		// Please wait animation
	var posting;
	var currentForm;

	$('#DeliveryAddressUserEditForm').submit(function(event) {

		// Prepare posting
		$('.help-inline').remove();	// remove previous error message
		_loadingDiv.show();			// show spinner
		currentForm = $(this);

		// Post data
		posting = $.post($(this).prop('action'), $(this).serialize());

		// Handle response
		posting.done(function(data) {
			
			_loadingDiv.hide();				// remove spinner
			if (data === '1') {

				// Trigger the page specific success function that should be added after this script
				if(isFunction(handleSuccessfulPost)){
					location.reload(true);
				}else{
					$('.successMessage').show();
				}
			} else {

				// Validation errors
				var parseData = $.parseJSON(data);
				currentForm.find('input').each(function() {		// itereate all inputs in form 
					if (parseData[$(this).prop('id')] !== undefined) {			// If input as an error add the message after it 
						$(this).after("<div class='help-inline'>" + parseData[$(this).prop('id')] + "</div>");
					}
				});
			}
		});
		event.preventDefault();
	});
});
</script>